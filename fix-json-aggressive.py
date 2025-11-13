#!/usr/bin/env python3
"""
Script aggressivo per riparare i file JSON
Rimuove tutti i caratteri di controllo non validi
"""

import json
import os
import re
from pathlib import Path

INPUT_DIR = 'razze-complete'
OUTPUT_DIR = 'razze-complete-fixed'

def aggressive_fix(content):
    """
    Rimuove tutti i caratteri di controllo non validi da JSON
    Mantiene solo newline che sono fuori dalle stringhe
    """
    # Prima sostituisci tutti i caratteri di controllo con uno spazio
    # tranne newline e tab (li gestiamo dopo)
    fixed = content

    # Sostituisci caratteri di controllo Unicode pericolosi
    fixed = re.sub(r'[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]', ' ', fixed)

    # Ora gestiamo i newline nelle stringhe
    # Pattern: trova le stringhe JSON e sostituisci i newline al loro interno
    def fix_string_content(match):
        string_content = match.group(1)
        # Sostituisci newline e tab con spazi nelle stringhe
        string_content = string_content.replace('\n', ' ')
        string_content = string_content.replace('\r', ' ')
        string_content = string_content.replace('\t', ' ')
        # Rimuovi spazi multipli
        string_content = re.sub(r'\s+', ' ', string_content)
        return '"' + string_content + '"'

    # Pattern per trovare stringhe JSON (attenzione agli escape)
    # Questo pattern cerca: "qualsiasi cosa che non sia " oppure \" fino alla chiusura"
    fixed = re.sub(r'"((?:[^"\\]|\\.)*)"`', fix_string_content, fixed)

    # Approccio alternativo più semplice: sostituisci tutti i newline/tab con spazi
    # e poi sistema la formattazione
    fixed = content.replace('\r\n', ' ')
    fixed = fixed.replace('\n', ' ')
    fixed = fixed.replace('\t', ' ')

    # Rimuovi spazi multipli
    fixed = re.sub(r' +', ' ', fixed)

    # Prova a parsare
    try:
        data = json.loads(fixed)
        return data, True
    except:
        return fixed, False

def process_file(input_path, output_path):
    """Processa un singolo file JSON"""
    try:
        # Leggi il contenuto raw
        with open(input_path, 'r', encoding='utf-8', errors='ignore') as f:
            content = f.read()

        data, is_parsed = aggressive_fix(content)

        if is_parsed:
            # Salva la versione prettified
            with open(output_path, 'w', encoding='utf-8') as f:
                json.dump(data, f, ensure_ascii=False, indent=2)
            return True, len(data)
        else:
            # Salva la versione pulita anche se non parsabile
            with open(output_path, 'w', encoding='utf-8') as f:
                if isinstance(data, str):
                    f.write(data)
                else:
                    json.dump(data, f, ensure_ascii=False, indent=2)
            return False, "Could not parse"

    except Exception as e:
        return False, str(e)

def main():
    # Crea directory di output
    Path(OUTPUT_DIR).mkdir(exist_ok=True)

    # Processa tutti i file JSON
    files = sorted([f for f in os.listdir(INPUT_DIR) if f.endswith('.json')])

    print(f"Trovati {len(files)} file JSON\n")
    print("File" + " " * 12 + "| Status | Razze")
    print("-" * 45)

    total_success = 0
    total_breeds = 0

    for filename in files:
        input_path = os.path.join(INPUT_DIR, filename)
        output_path = os.path.join(OUTPUT_DIR, filename)

        success, result = process_file(input_path, output_path)

        if success:
            total_success += 1
            total_breeds += result
            print(f"{filename:15} | ✓      | {result}")
        else:
            print(f"{filename:15} | ✗      | {result}")

    print("-" * 45)
    print(f"\nFile riparati: {total_success}/{len(files)}")
    print(f"Razze totali: {total_breeds}")

if __name__ == "__main__":
    main()
