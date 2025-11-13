#!/usr/bin/env python3
"""
Advanced JSON fixer - Analizza carattere per carattere e ripara:
- Virgolette non escapate nelle stringhe
- Caratteri di controllo non validi
- Newline letterali nelle stringhe
"""

import json
import os
import re
from pathlib import Path

INPUT_DIR = 'razze-complete'
OUTPUT_DIR = 'razze-complete-fixed'

def advanced_fix_json(content):
    """
    Fix JSON character by character, tracking state
    """
    # Prima fase: preprocessing
    # 1. Sostituisci virgolette tipografiche curve
    fixed = content.replace('"', '"').replace('"', '"')
    fixed = fixed.replace(''', "'").replace(''', "'")
    fixed = fixed.replace('«', '"').replace('»', '"')

    # 2. Rimuovi caratteri di controllo problematici (tranne \n, \r, \t)
    fixed = re.sub(r'[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]', '', fixed)

    # Seconda fase: fix virgolette non escapate e newline nelle stringhe
    result = []
    i = 0
    in_string = False
    after_backslash = False

    while i < len(fixed):
        char = fixed[i]

        if after_backslash:
            # Carattere dopo backslash, lo manteniamo
            result.append(char)
            after_backslash = False
            i += 1
            continue

        if char == '\\':
            result.append(char)
            after_backslash = True
            i += 1
            continue

        if char == '"':
            # È una virgoletta
            if not in_string:
                # Inizia una stringa
                # Verifica che sia in posizione valida (dopo : o [ o ,)
                # Guarda indietro per vedere il contesto
                prev_chars = ''.join(result[-10:]).strip()
                if prev_chars.endswith(':') or prev_chars.endswith('[') or prev_chars.endswith(',') or prev_chars == '':
                    # Questa è l'apertura di una stringa JSON
                    in_string = True
                    result.append(char)
                else:
                    # Virgoletta strana, potrebbe essere interna a una stringa
                    # Escapiamola
                    result.append('\\')
                    result.append(char)
            else:
                # Siamo dentro una stringa
                # Questa virgoletta chiude la stringa?
                # Guarda avanti per vedere cosa c'è dopo
                next_chars = fixed[i+1:i+10].lstrip()
                if next_chars.startswith(',') or next_chars.startswith('}') or next_chars.startswith(']') or next_chars.startswith('\n'):
                    # Questa è la chiusura della stringa
                    in_string = False
                    result.append(char)
                else:
                    # Virgoletta dentro la stringa, escapiamola
                    result.append('\\')
                    result.append(char)
            i += 1
            continue

        if in_string:
            # Siamo dentro una stringa JSON
            if char == '\n' or char == '\r':
                # Newline letterale in una stringa, sostituisci con spazio
                result.append(' ')
            elif char == '\t':
                # Tab in una stringa, sostituisci con spazio
                result.append(' ')
            else:
                result.append(char)
        else:
            # Fuori dalle stringhe, mantieni tutto
            result.append(char)

        i += 1

    return ''.join(result)

def smart_fix_json(content):
    """
    Approccio alternativo: usa regex per fix mirati
    """
    # 1. Preprocessing base
    fixed = content.replace('"', '"').replace('"', '"')
    fixed = fixed.replace(''', "'").replace(''', "'")
    fixed = re.sub(r'[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]', '', fixed)

    # 2. Fix newline/tab nelle stringhe (pattern: "...\n...")
    # Trova tutte le stringhe e sostituisci newline/tab al loro interno
    def fix_string(match):
        string_content = match.group(0)
        # Sostituisci newline e tab con spazi
        string_content = string_content.replace('\n', ' ')
        string_content = string_content.replace('\r', ' ')
        string_content = string_content.replace('\t', ' ')
        # Riduci spazi multipli
        string_content = re.sub(r'  +', ' ', string_content)
        return string_content

    # Pattern per trovare stringhe JSON (semplificato)
    # Questo non è perfetto ma cattura la maggior parte dei casi
    fixed = re.sub(r'"[^"]*?"', fix_string, fixed, flags=re.DOTALL)

    return fixed

def process_file(input_path, output_path):
    """Processa un singolo file JSON con entrambi i metodi"""
    try:
        with open(input_path, 'r', encoding='utf-8') as f:
            content = f.read()

        # Prova prima il metodo smart (più semplice)
        fixed_content = smart_fix_json(content)

        try:
            data = json.loads(fixed_content)
            # Successo con metodo smart
            with open(output_path, 'w', encoding='utf-8') as f:
                json.dump(data, f, ensure_ascii=False, indent=2)
            return True, len(data), 'smart'
        except json.JSONDecodeError:
            # Prova metodo advanced
            fixed_content = advanced_fix_json(content)
            try:
                data = json.loads(fixed_content)
                # Successo con metodo advanced
                with open(output_path, 'w', encoding='utf-8') as f:
                    json.dump(data, f, ensure_ascii=False, indent=2)
                return True, len(data), 'advanced'
            except json.JSONDecodeError as e:
                # Ancora fallito, salva per debug
                with open(output_path + '.debug', 'w', encoding='utf-8') as f:
                    f.write(fixed_content)
                return False, f"Line {e.lineno}, Col {e.colno}: {e.msg[:30]}", 'failed'

    except Exception as e:
        return False, str(e)[:50], 'error'

def main():
    Path(OUTPUT_DIR).mkdir(exist_ok=True)

    files = sorted([f for f in os.listdir(INPUT_DIR) if f.endswith('.json')])

    print(f"🔧 Advanced JSON Fixer - Processing {len(files)} files\n")
    print("File" + " " * 12 + "| Status | Razze | Method")
    print("-" * 65)

    stats = {'smart': 0, 'advanced': 0, 'failed': 0, 'error': 0}
    total_breeds = 0
    failed_files = []

    for filename in files:
        input_path = os.path.join(INPUT_DIR, filename)
        output_path = os.path.join(OUTPUT_DIR, filename)

        success, result, method = process_file(input_path, output_path)

        if success:
            stats[method] += 1
            total_breeds += result
            print(f"{filename:15} | ✓      | {result:5} | {method}")
        else:
            stats[method] += 1
            failed_files.append((filename, result))
            print(f"{filename:15} | ✗      | {str(result)[:5]} | {method}")

    print("-" * 65)
    print(f"\n📊 Risultati:")
    print(f"  ✅ File riparati: {stats['smart'] + stats['advanced']}/{len(files)}")
    print(f"     - Smart fix: {stats['smart']}")
    print(f"     - Advanced fix: {stats['advanced']}")
    print(f"  ❌ File ancora invalidi: {stats['failed']}")
    print(f"  ⚠️  Errori: {stats['error']}")
    print(f"  📦 Razze totali: {total_breeds}")

    if failed_files:
        print(f"\n❌ File con errori rimasti ({len(failed_files)}):")
        for fname, error in failed_files[:10]:
            print(f"   {fname}: {error}")

    print(f"\n💾 File salvati in: {OUTPUT_DIR}/")

if __name__ == "__main__":
    main()
