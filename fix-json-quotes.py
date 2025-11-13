#!/usr/bin/env python3
"""
Script per riparare i file JSON con virgolette curve
"""

import json
import os
from pathlib import Path

INPUT_DIR = 'razze-complete'
OUTPUT_DIR = 'razze-complete-fixed'

def fix_quotes_and_control_chars(content):
    """
    Sostituisce virgolette tipografiche curve con virgolette dritte
    e rimuove caratteri di controllo problematici
    """
    # Sostituisci virgolette curve con virgolette dritte
    fixed = content.replace('"', '"')  # Left double quotation mark
    fixed = fixed.replace('"', '"')  # Right double quotation mark
    fixed = fixed.replace(''', "'")  # Left single quotation mark
    fixed = fixed.replace(''', "'")  # Right single quotation mark
    fixed = fixed.replace('«', '"')  # Left-pointing double angle quotation mark
    fixed = fixed.replace('»', '"')  # Right-pointing double angle quotation mark

    # Sostituisci caratteri di controllo Unicode problematici
    # ma mantieni newline e tab che sono parte della struttura JSON
    import re
    # Rimuovi solo i caratteri di controllo davvero problematici (0x00-0x1F tranne \n, \r, \t)
    fixed = re.sub(r'[\x00-\x08\x0B\x0C\x0E-\x1F]', '', fixed)

    return fixed

def process_file(input_path, output_path):
    """Processa un singolo file JSON"""
    try:
        # Leggi il contenuto raw
        with open(input_path, 'r', encoding='utf-8') as f:
            content = f.read()

        # Ripara virgolette e caratteri di controllo
        fixed_content = fix_quotes_and_control_chars(content)

        # Prova a parsare
        data = json.loads(fixed_content)

        # Salva la versione prettified
        with open(output_path, 'w', encoding='utf-8') as f:
            json.dump(data, f, ensure_ascii=False, indent=2)

        return True, len(data)

    except json.JSONDecodeError as e:
        # Salva comunque il tentativo per debug
        with open(output_path + '.debug', 'w', encoding='utf-8') as f:
            f.write(fixed_content)
        return False, f"Line {e.lineno}, Col {e.colno}: {e.msg}"
    except Exception as e:
        return False, str(e)

def main():
    # Crea directory di output
    Path(OUTPUT_DIR).mkdir(exist_ok=True)

    # Processa tutti i file JSON
    files = sorted([f for f in os.listdir(INPUT_DIR) if f.endswith('.json')])

    print(f"Trovati {len(files)} file JSON\n")
    print("File" + " " * 12 + "| Status | Razze/Errore")
    print("-" * 60)

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
            print(f"{filename:15} | ✓      | {result} razze")
        else:
            failed_files.append((filename, result))
            error_short = str(result)[:35]
            print(f"{filename:15} | ✗      | {error_short}")

    print("-" * 60)
    print(f"\nRisultati:")
    print(f"  File riparati con successo: {total_success}/{len(files)}")
    print(f"  Razze totali importabili: {total_breeds}")

    if failed_files:
        print(f"\n  File ancora con errori: {len(failed_files)}")
        for fname, error in failed_files[:5]:  # Mostra primi 5
            print(f"    - {fname}: {error}")

    print(f"\nFile riparati salvati in: {OUTPUT_DIR}/")

if __name__ == "__main__":
    main()
