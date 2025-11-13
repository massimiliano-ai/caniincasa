#!/usr/bin/env python3
"""
Ultra-simple JSON fixer - Solo fix mirati e pattern specifici
"""

import json
import os
import re
from pathlib import Path

INPUT_DIR = 'razze-complete'
OUTPUT_DIR = 'razze-fixed-simple'

def ultra_simple_fix(content):
    """
    Fix ultra-semplice con solo sostituzioni mirate
    """
    # 1. Virgolette tipografiche curve -> dritte
    fixed = content.replace('"', '"').replace('"', '"')
    fixed = fixed.replace(''', "'").replace(''', "'")

    # 2. Pattern specifico: ("parola") -> ('parola')
    # Cerca virgolette doppie dentro parentesi e sostituiscile con singole
    fixed = re.sub(r'\(\"([^"]+)\"\)', r"('\1')", fixed)

    # 3. Pattern: basso ("basset") -> basso ('basset')
    # Più generale: qualsiasi ("...") -> ('...')
    fixed = re.sub(r'(\w)\s*\(\"([^"]+)\"\)', r"\1 ('\2')", fixed)

    # 4. Fix "re dei" e simili con virgolette
    fixed = re.sub(r'\"([A-Z][^"]{2,15})\"(?!\s*[,:\]}])', r"'\1'", fixed)

    return fixed

def process_file(input_path, output_path):
    """Processa un file"""
    try:
        with open(input_path, 'r', encoding='utf-8') as f:
            content = f.read()

        fixed = ultra_simple_fix(content)

        try:
            data = json.loads(fixed)
            with open(output_path, 'w', encoding='utf-8') as f:
                json.dump(data, f, ensure_ascii=False, indent=2)
            return True, len(data)
        except json.JSONDecodeError as e:
            return False, f"L{e.lineno}:C{e.colno}"

    except Exception as e:
        return False, str(e)[:30]

def main():
    Path(OUTPUT_DIR).mkdir(exist_ok=True)
    files = sorted([f for f in os.listdir(INPUT_DIR) if f.endswith('.json')])

    print(f"🎯 Ultra-Simple JSON Fixer\n")
    print("File" + " " * 12 + "| Result")
    print("-" * 40)

    success_count = 0
    total_breeds = 0

    for filename in files:
        input_path = os.path.join(INPUT_DIR, filename)
        output_path = os.path.join(OUTPUT_DIR, filename)

        success, result = process_file(input_path, output_path)

        if success:
            success_count += 1
            total_breeds += result
            print(f"{filename:15} | ✓ {result:3} razze")
        else:
            print(f"{filename:15} | ✗ {result}")

    print("-" * 40)
    print(f"\n✅ Riparati: {success_count}/{len(files)}")
    print(f"📦 Razze: {total_breeds}/320")

if __name__ == "__main__":
    main()
