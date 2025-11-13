#!/usr/bin/env python3
"""
Precise JSON fixer - Fix solo i VALORI delle stringhe, non i campi
"""

import json
import os
import re
from pathlib import Path

INPUT_DIR = 'razze-complete'
OUTPUT_DIR = 'razze-complete-fixed'

def precise_fix_json(content):
    """
    Fix JSON in modo preciso:
    1. Preprocessing: virgolette curve -> dritte
    2. Fix solo i valori delle stringhe (dopo ": ")
    3. Mantieni intatta la struttura JSON
    """
    # Fase 1: Sostituzioni base
    fixed = content

    # Sostituisci virgolette tipografiche curve con dritte
    fixed = fixed.replace('"', '"').replace('"', '"')
    fixed = fixed.replace(''', "'").replace(''', "'")
    fixed = fixed.replace('«', '"').replace('»', '"')

    # Rimuovi caratteri di controllo problematici (tranne \n, \r, \t che sono nella struttura)
    fixed = re.sub(r'[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]', '', fixed)

    # Fase 2: Fix valori stringa (pattern: ": "valore")
    # Match: ": "qualcosa che può contenere virgolette o newline"
    # Questo pattern cattura: nome_campo": "valore con possibili virgolette"

    def fix_string_value(match):
        field_name = match.group(1)  # nome campo
        colon_quote = match.group(2)  # ": "
        value = match.group(3)  # contenuto valore
        closing_quote = match.group(4)  # " finale

        # Fix il valore:
        # 1. Rimuovi newline e tab letterali
        value = value.replace('\n', ' ').replace('\r', ' ').replace('\t', ' ')

        # 2. Riduci spazi multipli
        value = re.sub(r'  +', ' ', value)

        # 3. Escape virgolette interne che non sono già escapate
        # Cerca virgolette che non hanno \ davanti
        value = re.sub(r'(?<!\\)"', r'\"', value)

        return f'{field_name}{colon_quote}{value}{closing_quote}'

    # Pattern per matchare campi JSON: "campo": "valore"
    # Il pattern deve essere greedy ma bilanciato
    # Match: "qualsiasi_campo": "valore che può essere multi-linea"
    # Usa lookahead negativo per fermarsi alla prima " seguita da , o }

    pattern = r'("[\w_]+")(\s*:\s*")(.+?)("(?=\s*[,}\]]))'
    fixed = re.sub(pattern, fix_string_value, fixed, flags=re.DOTALL)

    return fixed

def ultra_precise_fix(content):
    """
    Approccio ultra-preciso: parse line-by-line con stato
    """
    lines = content.split('\n')
    result = []
    in_multiline_string = False
    multiline_buffer = ""

    for line in lines:
        # Sostituzioni base su ogni linea
        line = line.replace('"', '"').replace('"', '"')
        line = line.replace(''', "'").replace(''', "'")
        line = re.sub(r'[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]', '', line)

        if in_multiline_string:
            # Siamo dentro una stringa multi-linea
            # Aggiungi al buffer con spazio invece di newline
            multiline_buffer += " " + line.strip()

            # Verifica se finisce la stringa (cerca " seguito da , o })
            if re.search(r'"\s*[,}\]]', line):
                # Fine stringa multi-linea
                in_multiline_string = False
                # Fix virgolette non escapate nel buffer
                multiline_buffer = re.sub(r'(?<!\\)"(?!s*[,}\]])', r'\"', multiline_buffer)
                result.append(multiline_buffer)
                multiline_buffer = ""
        else:
            # Siamo fuori da stringhe multi-linea
            # Verifica se questa linea inizia una stringa che non finisce
            # Pattern: "campo": "valore... ma NON termina con ",
            if re.match(r'\s*"[\w_]+"\s*:\s*".*[^"]$', line) or \
               (re.match(r'\s*"[\w_]+"\s*:\s*"', line) and not re.search(r'"\s*[,}\]]', line)):
                # Inizia stringa multi-linea
                in_multiline_string = True
                multiline_buffer = line
            else:
                # Linea normale, fix virgolette nelle stringhe di questa linea
                # Pattern: "campo": "valore con (virgolette) possibili"
                def fix_inline(match):
                    prefix = match.group(1)  # tutto prima del valore
                    value = match.group(2)   # il valore
                    suffix = match.group(3)  # " finale + , o }

                    # Escape virgolette interne
                    value = re.sub(r'(?<!\\)"', r'\"', value)
                    return prefix + value + suffix

                line = re.sub(r'(:\s*")([^"]*(?:\\"[^"]*)*)"(\s*[,}\]])', fix_inline, line)
                result.append(line)

    return '\n'.join(result)

def process_file(input_path, output_path):
    """Prova entrambi i metodi precisi"""
    try:
        with open(input_path, 'r', encoding='utf-8') as f:
            content = f.read()

        # Prova metodo ultra-precise
        fixed_content = ultra_precise_fix(content)

        try:
            data = json.loads(fixed_content)
            with open(output_path, 'w', encoding='utf-8') as f:
                json.dump(data, f, ensure_ascii=False, indent=2)
            return True, len(data), 'ultra-precise'
        except json.JSONDecodeError:
            # Prova metodo precise
            fixed_content = precise_fix_json(content)
            try:
                data = json.loads(fixed_content)
                with open(output_path, 'w', encoding='utf-8') as f:
                    json.dump(data, f, ensure_ascii=False, indent=2)
                return True, len(data), 'precise'
            except json.JSONDecodeError as e:
                with open(output_path + '.debug', 'w', encoding='utf-8') as f:
                    f.write(fixed_content)
                return False, f"L{e.lineno}:C{e.colno}", 'failed'

    except Exception as e:
        return False, str(e)[:20], 'error'

def main():
    Path(OUTPUT_DIR).mkdir(exist_ok=True)
    files = sorted([f for f in os.listdir(INPUT_DIR) if f.endswith('.json')])

    print(f"🎯 Precise JSON Fixer - Processing {len(files)} files\n")
    print("File" + " " * 12 + "| Status | Razze | Method")
    print("-" * 65)

    stats = {'ultra-precise': 0, 'precise': 0, 'failed': 0}
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
            stats['failed'] += 1
            failed_files.append((filename, result))
            print(f"{filename:15} | ✗      | {result:5} | {method}")

    print("-" * 65)
    print(f"\n📊 Risultati:")
    print(f"  ✅ Riparati: {stats['ultra-precise'] + stats['precise']}/{len(files)}")
    print(f"     - Ultra-precise: {stats['ultra-precise']}")
    print(f"     - Precise: {stats['precise']}")
    print(f"  ❌ Falliti: {stats['failed']}")
    print(f"  📦 Razze: {total_breeds}/{len(files)*10}")

    if failed_files:
        print(f"\n❌ File con errori ({len(failed_files)}):")
        for fname, error in failed_files[:10]:
            print(f"   {fname}: {error}")

if __name__ == "__main__":
    main()
