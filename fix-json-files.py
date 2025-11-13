#!/usr/bin/env python3
"""
Script per riparare i file JSON con errori di sintassi:
- Rimuove newline letterali nelle stringhe
- Ripara problemi di escape comuni
"""

import json
import os
import re
from pathlib import Path

INPUT_DIR = 'razze-complete'
OUTPUT_DIR = 'razze-complete-fixed'

def fix_json_content(content):
    """
    Ripara il contenuto JSON rimuovendo newline letterali nelle stringhe
    """
    # Prima prova: rimuovi newline letterali all'interno delle stringhe
    # Cerca pattern tipo: "campo": "valore con\nnewline"
    # e sostituisci il newline con uno spazio

    fixed = content

    # Rimuovi i newline che sono chiaramente dentro stringhe JSON
    # Pattern: dopo : e prima della prossima virgola o }
    lines = content.split('\n')
    result = []
    in_string = False
    buffer = ""

    for line in lines:
        # Conta le virgolette non escapate nella linea
        quote_count = len(re.findall(r'(?<!\\)"', line))

        # Se abbiamo un numero dispari di virgolette, siamo dentro una stringa
        if quote_count % 2 == 1:
            in_string = not in_string

        if in_string and buffer:
            # Siamo nel mezzo di una stringa multi-linea, unisci con la precedente
            buffer += " " + line.strip()
        else:
            if buffer:
                result.append(buffer)
                buffer = ""
            if in_string:
                buffer = line
            else:
                result.append(line)

    if buffer:
        result.append(buffer)

    fixed = '\n'.join(result)

    return fixed

def process_file(input_path, output_path):
    """Processa un singolo file JSON"""
    try:
        # Leggi il contenuto raw
        with open(input_path, 'r', encoding='utf-8') as f:
            content = f.read()

        # Prima tenta di ripararlo
        fixed_content = fix_json_content(content)

        # Prova a parsarlo per verificare
        try:
            data = json.loads(fixed_content)
            # Se il parsing funziona, salva la versione prettified
            with open(output_path, 'w', encoding='utf-8') as f:
                json.dump(data, f, ensure_ascii=False, indent=2)
            return True, len(data)
        except json.JSONDecodeError as e:
            # Se ancora non funziona, prova un approccio più aggressivo
            # Salva comunque il tentativo
            with open(output_path, 'w', encoding='utf-8') as f:
                f.write(fixed_content)
            return False, str(e)

    except Exception as e:
        return False, str(e)

def main():
    # Crea directory di output
    Path(OUTPUT_DIR).mkdir(exist_ok=True)

    # Processa tutti i file JSON
    files = sorted([f for f in os.listdir(INPUT_DIR) if f.endswith('.json')])

    print(f"Trovati {len(files)} file JSON da riparare\n")
    print("File" + " " * 12 + "| Status | Razze/Errore")
    print("-" * 55)

    total_success = 0
    total_breeds = 0

    for filename in files:
        input_path = os.path.join(INPUT_DIR, filename)
        output_path = os.path.join(OUTPUT_DIR, filename)

        success, result = process_file(input_path, output_path)

        if success:
            total_success += 1
            total_breeds += result
            print(f"{filename:15} | ✓      | {result} razze")
        else:
            print(f"{filename:15} | ✗      | {str(result)[:30]}")

    print("-" * 55)
    print(f"\nRisultati:")
    print(f"  File riparati: {total_success}/{len(files)}")
    print(f"  Razze totali: {total_breeds}")
    print(f"\nFile salvati in: {OUTPUT_DIR}/")

if __name__ == "__main__":
    main()
