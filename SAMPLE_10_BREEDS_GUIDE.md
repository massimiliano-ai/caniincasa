# Guida alle 10 Razze di Esempio - Sistema Completo v2.0

## 📋 Contenuto del Pacchetto

Questo pacchetto include **10 razze canine complete** con tutti i nuovi campi ACF del sistema v2.0:

### File Inclusi

- **`sample-breeds-10.json`** - File JSON unico con tutte le 10 razze (formato completo)
- **`sample-breeds-10-part1.json`** - Prime 6 razze (opzionale, per import parziale)
- **`sample-breeds-10-part2.json`** - Ultime 4 razze (opzionale, per import parziale)

---

## 🐕 Le 10 Razze Incluse

### 1. **Golden Retriever** 🥇
- **Profilo:** Cane da famiglia perfetto, dolce e intelligente
- **Caratteristiche:** Energia 4/5, Affettuosità 5/5, Addestramento 5/5
- **Ideale per:** Famiglie attive, cane da terapia
- **Slug:** `golden-retriever`

### 2. **Beagle** 🐰
- **Profilo:** Segugio allegro e testardo
- **Caratteristiche:** Energia 4/5, Vocalità 4.5/5, Istinto caccia 5/5
- **Ideale per:** Famiglie attive, amanti delle passeggiate
- **Slug:** `beagle`

### 3. **Bulldog Francese** 🏙️
- **Profilo:** Compagno perfetto per appartamento
- **Caratteristiche:** Energia 2/5, Adattabilità appartamento 5/5, Affettuosità 5/5
- **Ideale per:** Vita in città, anziani, single
- **Slug:** `bulldog-francese`

### 4. **Border Collie** 🧠
- **Profilo:** Il cane più intelligente al mondo
- **Caratteristiche:** Intelligenza 5/5, Energia 5/5, Addestramento 5/5
- **Ideale per:** Sportivi, appassionati agility, proprietari esperti
- **Slug:** `border-collie`

### 5. **Yorkshire Terrier** 👑
- **Profilo:** Toy coraggioso e affettuoso
- **Caratteristiche:** Adattabilità appartamento 5/5, Vocalità 4.5/5, Taglia toy
- **Ideale per:** Appartamenti, anziani, trasportabile
- **Slug:** `yorkshire-terrier`

### 6. **Rottweiler** 🛡️
- **Profilo:** Guardiano potente e leale
- **Caratteristiche:** Protezione 5/5, Intelligenza 4.5/5, Esperienza 4.5/5
- **Ideale per:** Proprietari esperti, guardia, protezione
- **Slug:** `rottweiler`

### 7. **Dalmata** 🎬
- **Profilo:** Atletico e distintivo
- **Caratteristiche:** Energia 5/5, Esercizio 5/5, Perdita pelo 2/5 (costante!)
- **Ideale per:** Corridori, ciclisti, molto attivi
- **Slug:** `dalmata`

### 8. **Shiba Inu** 🦊
- **Profilo:** Cane giapponese indipendente
- **Caratteristiche:** Indipendenza 5/5, Istinto caccia 5/5, Esperienza 4/5
- **Ideale per:** Proprietari esperti, chi apprezza indipendenza
- **Slug:** `shiba-inu`

### 9. **Cocker Spaniel Inglese** 🎾
- **Profilo:** Allegro cacciatore da famiglia
- **Caratteristiche:** Affettuosità 5/5, Compatibilità bambini 5/5, Energia 4/5
- **Ideale per:** Famiglie attive, attività outdoor
- **Slug:** `cocker-spaniel-inglese`

### 10. **Siberian Husky** ❄️
- **Profilo:** Cane da slitta nordico
- **Caratteristiche:** Energia 5/5, Freddo 5/5, Caldo 1/5, Esperienza 4.5/5
- **Ideale per:** Climi freddi, sportivi estremi
- **Slug:** `siberian-husky`

---

## 📊 Struttura Dati Completa

Ogni razza include:

### Campi Base WordPress
- `post_title` - Nome della razza
- `post_excerpt` - Estratto breve (50-60 parole)
- `post_type` - "razze_di_cani"
- `post_status` - "publish"
- `meta.slug` - Permalink SEO-friendly

### Campi ACF Sidebar (3 campi)
- `nazione_origine` - Paese di origine
- `colorazioni` - Colorazioni ammesse
- `temperamento_breve` - 3-5 parole chiave

### Campi ACF Contenuto WYSIWYG (6 campi)
- `descrizione_generale` - Introduzione (2-3 paragrafi HTML)
- `origini_storia` - Storia completa (2+ paragrafi HTML)
- `aspetto_fisico` - Descrizione fisica dettagliata (HTML)
- `carattere_temperamento` - Carattere approfondito (HTML)
- `salute_cura` - Salute, aspettativa vita, toelettatura (HTML)
- `attivita_addestramento` - Esigenze attività e training (HTML)
- `ideale_per` - Per chi è adatto / non adatto (HTML)

### Caratteristiche con Zampette (18 campi range 1-5)

**Temperamento:**
- energia_e_livelli_di_attivita
- affettuosita
- vocalita_e_predisposizione_ad_abbaiare
- socievolezza_cani

**Adattabilità:**
- adattabilita_appartamento
- adattabilita_clima_caldo
- adattabilita_clima_freddo
- tolleranza_alla_solitudine

**Famiglia:**
- compatibilita_con_i_bambini
- tolleranza_estranei
- compatibilita_con_altri_animali_domestici

**Addestramento & Cura:**
- facilita_di_addestramento
- intelligenza
- esigenze_di_esercizio
- facilita_toelettatura
- cura_e_perdita_pelo_
- predisposizioni_per_la_salute

**Esperienza:**
- livello_esperienza_richiesto
- costo_mantenimento
- istinti_di_caccia

---

## 📥 Metodi di Importazione

### Opzione 1: Script PHP Automatico

Usa lo script già incluso nel progetto:

```bash
# 1. Carica i file nella root WordPress
cp sample-breeds-10.json /path/to/wordpress/
cp import-sample-breeds.php /path/to/wordpress/

# 2. Modifica lo script per usare il nuovo file
# Cambia 'sample-breeds-import.json' con 'sample-breeds-10.json'

# 3. Visita l'URL
https://tuosito.it/import-sample-breeds.php

# 4. Elimina lo script dopo l'uso!
```

### Opzione 2: WP-CLI

Se hai WP-CLI installato:

```php
<?php
// import-10-breeds.php
require_once( 'wp-load.php' );

$json = file_get_contents( 'sample-breeds-10.json' );
$breeds = json_decode( $json, true );

foreach ( $breeds as $breed ) {
    // Verifica se esiste
    $existing = get_page_by_title( $breed['post_title'], OBJECT, 'razze_di_cani' );
    if ( $existing ) {
        echo "❌ Già esistente: {$breed['post_title']}\n";
        continue;
    }

    // Crea post
    $post_id = wp_insert_post( array(
        'post_title'   => $breed['post_title'],
        'post_excerpt' => $breed['post_excerpt'],
        'post_type'    => $breed['post_type'],
        'post_status'  => $breed['post_status'],
        'post_name'    => $breed['meta']['slug'],
    ) );

    if ( is_wp_error( $post_id ) ) {
        echo "❌ Errore: {$post_id->get_error_message()}\n";
        continue;
    }

    // Importa campi ACF
    foreach ( $breed['acf'] as $field => $value ) {
        update_field( $field, $value, $post_id );
    }

    echo "✓ Importata: {$breed['post_title']} (ID: {$post_id})\n";
}

echo "\n✅ Importazione completata!\n";
```

Esegui:
```bash
php import-10-breeds.php
```

### Opzione 3: Importazione Manuale

Per singole razze o test:

1. **Apri il file JSON**
2. **Copia i dati di una razza**
3. **Dashboard → Razze di Cani → Aggiungi Nuova**
4. **Inserisci titolo ed estratto**
5. **Compila i campi sidebar** (nazione, colorazioni, temperamento)
6. **Compila i campi contenuto** (6 tab WYSIWYG)
7. **Imposta le caratteristiche** (18 slider)
8. **Imposta slug** manualmente
9. **Pubblica**

---

## 🎯 Diversità del Dataset

Queste 10 razze sono state scelte per rappresentare:

### Per Taglia
- **Toy:** Yorkshire Terrier (< 5kg)
- **Piccola:** Beagle, Bulldog Francese, Shiba Inu (5-15kg)
- **Media:** Cocker Spaniel, Border Collie, Siberian Husky (15-25kg)
- **Grande:** Golden Retriever, Dalmata, Rottweiler (25-60kg)

### Per Livello Energia
- **Bassa:** Bulldog Francese (2/5), Yorkshire Terrier (3/5)
- **Media:** Shiba Inu (3.5/5), Cocker Spaniel (4/5)
- **Alta:** Beagle, Golden Retriever, Rottweiler (4/5)
- **Molto Alta:** Border Collie, Dalmata, Husky (5/5)

### Per Esperienza Richiesta
- **Principianti:** Golden Retriever (1.5/5), Bulldog Francese (2/5)
- **Intermedi:** Beagle (2.5/5), Yorkshire (2.5/5), Cocker (2/5)
- **Esperti:** Border Collie (4/5), Shiba Inu (4/5), Rottweiler (4.5/5), Husky (4.5/5)

### Per Adattabilità Appartamento
- **Perfetti:** Bulldog Francese, Yorkshire Terrier (5/5)
- **Buoni:** Shiba Inu (4/5), Cocker (3.5/5)
- **Moderati:** Golden, Beagle (3-3.5/5)
- **Difficili:** Border Collie (2/5), Dalmata (2/5), Husky (1.5/5)

### Per Funzione Originale
- **Compagnia:** Bulldog Francese, Yorkshire Terrier
- **Caccia:** Beagle, Cocker Spaniel
- **Pastore:** Border Collie
- **Riporto:** Golden Retriever
- **Guardia:** Rottweiler
- **Slitta:** Siberian Husky
- **Carrozza:** Dalmata
- **Primitivo:** Shiba Inu

---

## ✅ Checklist Post-Importazione

Dopo aver importato le razze, verifica:

- [ ] Tutte le 10 razze sono visibili in **Dashboard → Razze di Cani**
- [ ] I **permalink** sono corretti (es: `/razze_di_cani/golden-retriever/`)
- [ ] I **3 campi sidebar** sono compilati (nazione, colorazioni, temperamento)
- [ ] Le **6 sezioni WYSIWYG** hanno contenuto formattato
- [ ] Le **18 caratteristiche** mostrano valori corretti (1-5)
- [ ] Il **frontend** mostra il layout 1/3 + 2/3 correttamente
- [ ] Le **zampette** appaiono nel box caratteristiche
- [ ] Su **mobile** la sidebar appare dopo il contenuto
- [ ] Le **immagini** sono impostabili (non incluse nel JSON)
- [ ] Il **CSS** è caricato correttamente

---

## 🖼️ Aggiunta Immagini

Le immagini NON sono incluse nel JSON (troppo pesanti). Per aggiungerle:

### Metodo 1: Manuale
1. Trova immagini royalty-free su:
   - Unsplash (unsplash.com)
   - Pexels (pexels.com)
   - Pixabay (pixabay.com)
2. Scarica in alta qualità (min 1200x800px)
3. Carica in **Media Library**
4. Imposta come **Featured Image** per ogni razza

### Metodo 2: Bulk con Plugin
- Usa **Auto Featured Image** plugin
- Scarica set di immagini e carica via FTP
- Associa automaticamente per nome file

### Metodo 3: API Unsplash
```php
// Esempio per ottenere immagini da Unsplash API
$breed_names = ['golden retriever', 'beagle', 'french bulldog', ...];

foreach ( $breed_names as $breed ) {
    $url = "https://api.unsplash.com/search/photos?query={$breed}&client_id=YOUR_KEY";
    // Download e set come featured image
}
```

---

## 📈 Statistiche Dataset

**Totale Razze:** 10
**Totale Parole:** ~14,000
**Totale Caratteri:** ~95,000
**Media Parole/Razza:** 1,400
**Campi ACF per Razza:** 27 (3 sidebar + 6 WYSIWYG + 18 caratteristiche)

**Distribuzione Livello Energia:**
- 5/5: 3 razze (Border Collie, Dalmata, Husky)
- 4-4.5/5: 4 razze (Golden, Beagle, Rottweiler, Cocker)
- 3-3.5/5: 2 razze (Yorkshire, Shiba)
- 2/5: 1 razza (Bulldog Francese)

---

## 🚀 Prossimi Passi

Dopo l'importazione di queste 10 razze:

1. **Testa il Sistema**
   - Verifica layout su desktop/mobile
   - Controlla responsive design
   - Testa navigazione tra razze

2. **Aggiungi Immagini**
   - Featured images per tutte le razze
   - Ottimizza dimensioni per web

3. **Espandi Dataset**
   - Usa queste come template per altre razze
   - Mantieni la stessa struttura
   - Considera AI per generare contenuti (con revisione umana)

4. **Implementa Funzionalità**
   - Filtri per caratteristiche
   - Comparatore razze
   - Dog Finder quiz

---

## 💡 Tips per Creazione Contenuti

Se vuoi aggiungere più razze usando queste come template:

### Struttura Contenuto
- **Descrizione Generale:** 2-3 paragrafi introduttivi
- **Origini e Storia:** 2-3 paragrafi storici
- **Aspetto Fisico:** Dettagli su taglia, peso, mantello, colori
- **Carattere:** 2-3 paragrafi su temperamento e comportamento
- **Salute:** Aspettativa vita + problemi comuni + toelettatura
- **Attività:** Esigenze esercizio + addestramento + sport
- **Ideale Per:** Chi dovrebbe prenderlo / chi NO

### Caratteristiche
Usa questi riferimenti per valutare:

**Energia:**
- 1-2: Calmo, sedentario (es: Bulldog)
- 3: Moderato (es: Shiba)
- 4: Attivo (es: Golden)
- 5: Iperattivo (es: Husky, Border)

**Affettuosità:**
- 1-2: Indipendente, distaccato
- 3: Moderatamente affettuoso
- 4-5: Molto affettuoso, "velcro dog"

**Esperienza:**
- 1-2: Principianti
- 3: Intermedio
- 4-5: Solo esperti

### Fonti Affidabili
- FCI (fci.be) - Standard ufficiali
- AKC (akc.org) - Informazioni razze
- ENCI (enci.it) - Standard italiani
- Allevatori certificati
- Veterinari specializzati

---

## 🆘 Supporto

### Problemi Comuni

**"Le zampette non si vedono"**
- Verifica che il CSS sia caricato
- Controlla i valori nei campi ACF
- Svuota cache browser/plugin

**"Il layout non è 1/3 + 2/3"**
- Controlla che `single-razza.css` sia caricato
- Verifica responsive breakpoints
- Testa senza altri plugin attivi

**"Contenuto HTML non formattato"**
- I campi WYSIWYG salvano HTML
- `wp_kses_post()` filtra HTML pericoloso
- Usa editor Visual per formattazione

---

**Creato:** 2025-01-13
**Versione:** 2.0.0
**Autore:** Claude AI Assistant
**Licenza:** Uso interno progetto caniincasa.it
