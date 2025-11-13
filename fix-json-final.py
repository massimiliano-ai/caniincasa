#!/usr/bin/env python3
"""
Final JSON fixer - Approccio character-by-character robusto
"""

import json
import os
import re
from pathlib import Path

INPUT_DIR = 'razze-complete'
OUTPUT_DIR = 'razze-complete-fixed'

def final_fix_json(content):
    """
    Fix character-by-character con state machine
    """
    # Fase 1: Preprocessing
    content = content.replace('"', '"').replace('"', '"')
    content = content.replace(''', "'").replace(''', "'")
    content = content.replace('«', '"').replace('»', '"')
    content = re.sub(r'[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]', '', content)

    # Fase 2: Character-by-character parsing
    result = []
    i = 0
    length = len(content)

    # Stati
    IN_FIELD_NAME = 1
    IN_VALUE_STRING = 2
    OUTSIDE = 3

    state = OUTSIDE
    escape_next = False

    while i < length:
        char = content[i]

        if escape_next:
            # Carattere dopo backslash, mantienilo
            result.append(char)
            escape_next = False
            i += 1
            continue

        if char == '\\':
            result.append(char)
            escape_next = True
            i += 1
            continue

        if char == '"':
            if state == OUTSIDE:
                # Inizia un campo nome o valore
                # Guarda indietro per capire il contesto
                prev = ''.join(result[-10:]).strip()

                if prev.endswith(':'):
                    # Inizia valore stringa
                    state = IN_VALUE_STRING
                    result.append(char)
                elif prev.endswith(',') or prev.endswith('{') or prev.endswith('[') or not prev:
                    # Inizia nome campo
                    state = IN_FIELD_NAME
                    result.append(char)
                else:
                    # Contesto ambiguo, assume valore
                    state = IN_VALUE_STRING
                    result.append(char)

            elif state == IN_FIELD_NAME:
                # Fine nome campo
                # Guarda avanti per confermare
                next_chars = content[i+1:i+10].lstrip()
                if next_chars.startswith(':'):
                    # Confermato fine nome campo
                    state = OUTSIDE
                    result.append(char)
                else:
                    # Virgoletta dentro nome campo (raro), escapala
                    result.append('\\')
                    result.append(char)

            elif state == IN_VALUE_STRING:
                # Possibile fine valore stringa
                # Guarda avanti per confermare
                next_chars = content[i+1:i+15].lstrip()
                if next_chars.startswith(',') or next_chars.startswith('}') or next_chars.startswith(']'):
                    # Confermato fine valore
                    state = OUTSIDE
                    result.append(char)
                else:
                    # Virgoletta dentro valore, escapala
                    result.append('\\')
                    result.append(char)

        elif state == IN_VALUE_STRING and (char == '\n' or char == '\r' or char == '\t'):
            # Newline o tab dentro valore, sostituisci con spazio
            if result and result[-1] != ' ':
                result.append(' ')
            # Skip il carattere

        else:
            # Carattere normale
            result.append(char)

        i += 1

    return ''.join(result)

def process_file(input_path, output_path):
    """Processa un file con il fix finale"""
    try:
        with open(input_path, 'r', encoding='utf-8') as f:
            content = f.read()

        fixed_content = final_fix_json(content)

        # Tenta parsing
        try:
            data = json.loads(fixed_content)
            # Successo!
            with open(output_path, 'w', encoding='utf-8') as f:
                json.dump(data, f, ensure_ascii=False, indent=2)
            return True, len(data)
        except json.JSONDecodeError as e:
            # Salva per debug
            with open(output_path + '.debug', 'w', encoding='utf-8') as f:
                f.write(fixed_content)

            # Mostra errore dettagliato
            lines = fixed_content.split('\n')
            error_line = lines[e.lineno - 1] if e.lineno <= len(lines) else ""
            error_context = error_line[max(0, e.colno-40):min(len(error_line), e.colno+40)]

            return False, f"L{e.lineno}:C{e.colno} - {e.msg[:20]} - Context: ...{error_context}..."

    except Exception as e:
        return False, f"Exception: {str(e)[:30]}"

def main():
    Path(OUTPUT_DIR).mkdir(exist_ok=True)
    files = sorted([f for f in os.listdir(INPUT_DIR) if f.endswith('.json')])

    print(f"🚀 Final JSON Fixer - Character-by-Character Parser\n")
    print("File" + " " * 12 + "| Status | Razze")
    print("-" * 50)

    total_success = 0
    total_breeds = 0
    failed_files = []

    for filename in files:
        input_path = os.path.join(INPUT_DIR, filename)
        output_path = os.path.join(OUTPUT_DIR, filename)

        success, result = process_file(input_path, output_path)

        if success:
            total_success += 1
            total_breeds += result
            print(f"{filename:15} | ✓      | {result:3}")
        else:
            failed_files.append((filename, result))
            print(f"{filename:15} | ✗      |")

    print("-" * 50)
    print(f"\n📊 Risultati Finali:")
    print(f"  ✅ File riparati: {total_success}/{len(files)}")
    print(f"  ❌ File falliti: {len(failed_files)}")
    print(f"  📦 Razze importabili: {total_breeds}/320")
    print(f"  📈 Percentuale successo: {(total_success/len(files)*100):.1f}%")

    if failed_files:
        print(f"\n❌ File ancora con errori ({len(failed_files)}):")
        for fname, error in failed_files[:5]:
            print(f"\n  {fname}:")
            # Tronca l'errore se troppo lungo
            error_lines = str(error).split(' - ')
            for line in error_lines[:2]:
                print(f"    {line[:80]}")

    print(f"\n💾 File salvati in: {OUTPUT_DIR}/")

    if total_success > 20:
        print(f"\n✨ Ottimo! {total_success} file riparati - puoi procedere con l'importazione")

if __name__ == "__main__":
    main()
