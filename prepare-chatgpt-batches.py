#!/usr/bin/env python3
"""
Script per preparare batch di razze da inviare a ChatGPT
Legge il CSV e crea file di input pronti per ChatGPT
"""

import csv
import json
import os
from pathlib import Path

# Configurazione
CSV_FILE = "razze-di-cani-Export-2025-November.csv"
OUTPUT_DIR = "chatgpt-batches"
BATCH_SIZE = 10  # Razze per batch
PROMPT_FILE = "CHATGPT_PROMPT_GENERAZIONE_RAZZE.md"

def read_csv():
    """Legge il CSV e restituisce lista di razze"""
    breeds = []

    with open(CSV_FILE, 'r', encoding='utf-8') as f:
        # CSV usa punto e virgola come separatore
        reader = csv.DictReader(f, delimiter=';')

        for row in reader:
            breeds.append({
                'id': row['ID'],
                'title': row['Title'],
                'slug': row['Slug'],
                'category': row['razze allevamenti'],
                'image_url': row['Image URL'],
                'image_filename': row['Image Filename']
            })

    return breeds

def create_batch_input(breeds, batch_num):
    """Crea il testo di input per un batch di razze"""

    input_text = f"# BATCH {batch_num} - Genera i JSON per le seguenti razze:\n\n"

    for i, breed in enumerate(breeds, 1):
        input_text += f"## RAZZA {i}: {breed['title']}\n\n"
        input_text += f"```\n"
        input_text += f"Razza: {breed['title']}\n"
        input_text += f"Slug: {breed['slug']}\n"
        input_text += f"Categoria: {breed['category']}\n"
        input_text += f"Immagine URL: {breed['image_url']}\n"
        input_text += f"Immagine File: {breed['image_filename']}\n"
        input_text += f"```\n\n"

    input_text += "---\n\n"
    input_text += "Genera un array JSON con tutti gli oggetti delle razze sopra elencate.\n"
    input_text += "Formato output:\n\n"
    input_text += "```json\n"
    input_text += "[\n"
    input_text += "  { /* razza 1 */ },\n"
    input_text += "  { /* razza 2 */ },\n"
    input_text += "  ...\n"
    input_text += "]\n"
    input_text += "```\n"

    return input_text

def main():
    """Funzione principale"""

    # Crea directory output
    Path(OUTPUT_DIR).mkdir(exist_ok=True)

    # Leggi razze dal CSV
    print(f"📖 Lettura CSV: {CSV_FILE}")
    breeds = read_csv()
    print(f"✓ Trovate {len(breeds)} razze")

    # Dividi in batch
    total_batches = (len(breeds) + BATCH_SIZE - 1) // BATCH_SIZE
    print(f"📦 Creazione di {total_batches} batch (max {BATCH_SIZE} razze per batch)")

    # Copia il prompt base
    with open(PROMPT_FILE, 'r', encoding='utf-8') as f:
        base_prompt = f.read()

    # Crea file per ogni batch
    for i in range(0, len(breeds), BATCH_SIZE):
        batch_num = i // BATCH_SIZE + 1
        batch_breeds = breeds[i:i + BATCH_SIZE]

        # Nome file batch
        batch_file = f"{OUTPUT_DIR}/batch_{batch_num:03d}.txt"

        # Crea contenuto completo
        full_content = f"{base_prompt}\n\n{'='*80}\n\n"
        full_content += create_batch_input(batch_breeds, batch_num)

        # Salva file
        with open(batch_file, 'w', encoding='utf-8') as f:
            f.write(full_content)

        print(f"  ✓ Batch {batch_num:03d}: {len(batch_breeds)} razze → {batch_file}")

    # Crea anche un file indice
    index_file = f"{OUTPUT_DIR}/INDEX.md"
    with open(index_file, 'w', encoding='utf-8') as f:
        f.write("# Indice Batch per ChatGPT\n\n")
        f.write(f"Totale razze: {len(breeds)}\n")
        f.write(f"Totale batch: {total_batches}\n")
        f.write(f"Razze per batch: {BATCH_SIZE}\n\n")
        f.write("## Batch Creati\n\n")

        for i in range(0, len(breeds), BATCH_SIZE):
            batch_num = i // BATCH_SIZE + 1
            batch_breeds = breeds[i:i + BATCH_SIZE]

            f.write(f"### Batch {batch_num:03d}\n")
            f.write(f"File: `batch_{batch_num:03d}.txt`\n")
            f.write(f"Razze ({len(batch_breeds)}):\n")
            for breed in batch_breeds:
                f.write(f"- {breed['title']} (`{breed['slug']}`)\n")
            f.write("\n")

    print(f"\n✅ Completato!")
    print(f"📁 File creati in: {OUTPUT_DIR}/")
    print(f"📋 Vedi indice: {index_file}")
    print(f"\n🔄 Workflow:")
    print(f"   1. Apri batch_001.txt")
    print(f"   2. Copia tutto il contenuto")
    print(f"   3. Incolla in ChatGPT")
    print(f"   4. Salva l'output JSON come batch_001_output.json")
    print(f"   5. Ripeti per tutti i batch")
    print(f"   6. Esegui lo script di importazione")

if __name__ == "__main__":
    main()
