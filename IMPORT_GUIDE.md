# Guida all'Importazione delle 320 Razze

## ✅ File Pronti

Tutti i **32 file JSON** sono stati verificati e sono **100% validi**:
- 📂 Directory: `complete corrette/`
- 📦 File: b01.json - b32.json
- 🐕 Razze totali: **320**

## 🚀 Procedura di Importazione

### Prerequisiti
- ✅ Tema WordPress installato e attivo
- ✅ ACF PRO installato e attivo
- ✅ Campi ACF configurati (da `wp-content/themes/theme-caniincasa/inc/custom-fields.php`)
- ✅ Accesso SSH o FTP al server

### Passo 1: Carica i File sul Server

**Opzione A: Via SSH**
```bash
# Dalla tua macchina locale, carica la directory sul server
scp -r "complete corrette" utente@server:/percorso/wordpress/
scp import-breeds-from-chatgpt.php utente@server:/percorso/wordpress/
```

**Opzione B: Via FTP**
1. Connettiti al server FTP
2. Carica la cartella `complete corrette/` nella root di WordPress
3. Carica `import-breeds-from-chatgpt.php` nella root di WordPress

### Passo 2: Esegui l'Importazione

**Via SSH (consigliato):**
```bash
# Collegati al server
ssh utente@server

# Vai nella root di WordPress
cd /percorso/wordpress

# Esegui l'importazione
php import-breeds-from-chatgpt.php "complete corrette"/*.json
```

**Via WP-CLI (se disponibile):**
```bash
cd /percorso/wordpress
wp eval-file import-breeds-from-chatgpt.php
```

### Passo 3: Verifica l'Importazione

1. **WordPress Admin**
   - Vai su: `Razze di Cani` → `Tutte le razze`
   - Verifica che ci siano **320 razze**

2. **Controlla un Post di Test**
   - Apri una razza qualsiasi
   - Verifica che tutti i campi ACF siano popolati:
     - Sidebar: Nazione origine, Colorazioni, Temperamento breve
     - Contenuto: 6 sezioni WYSIWYG
     - Caratteristiche: tutti i valori numerici

3. **Frontend**
   - Visita una scheda razza (es: `/razze_di_cani/airedale-terrier/`)
   - Verifica layout 1/3 + 2/3
   - Verifica immagine in evidenza
   - Verifica caratteristiche con stelline

## ⏱️ Tempo Stimato

- **Upload file**: 2-5 minuti (dipende dalla connessione)
- **Importazione**: 10-20 minuti (320 razze + download immagini)
- **Verifica**: 5 minuti

**Totale: ~20-30 minuti**

## 📊 Cosa Fa lo Script

Lo script `import-breeds-from-chatgpt.php`:

1. ✅ Legge ogni file JSON
2. ✅ Per ogni razza:
   - Crea il post `razze_di_cani`
   - Imposta titolo, excerpt, slug
   - Assegna la tassonomia `razze_allevamenti`
   - Scarica l'immagine in evidenza da www.caniincasa.it
   - Popola tutti i 28 campi ACF
3. ✅ Mostra progresso in tempo reale
4. ✅ Gestisce errori e duplicati

## 🔍 Output Atteso

```
===========================================
📦 IMPORTAZIONE RAZZE DA JSON - ChatGPT
===========================================

Trovati 32 file JSON da importare

📄 Elaborazione file: complete corrette/b01.json
   ✓ Airedale terrier - Creato (ID: 123)
   ✓ Akita - Creato (ID: 124)
   ...
   Importate: 10/10 razze da questo file

📄 Elaborazione file: complete corrette/b02.json
   ...

===========================================
✅ IMPORTAZIONE COMPLETATA
===========================================

Razze importate: 320/320
Immagini scaricate: 320/320
Errori: 0
```

## ⚠️ Problemi Comuni

### Errore: "Maximum execution time"
```bash
# Aumenta il timeout in php.ini o esegui:
php -d max_execution_time=300 import-breeds-from-chatgpt.php "complete corrette"/*.json
```

### Errore: "Memory limit"
```bash
# Aumenta la memoria:
php -d memory_limit=512M import-breeds-from-chatgpt.php "complete corrette"/*.json
```

### Errore: "wp-load.php not found"
- Assicurati di essere nella root di WordPress
- Lo script cerca wp-load.php in: `.`, `..`, `../..`

## 📋 Checklist Post-Importazione

- [ ] Verificato che ci siano 320 razze in WordPress
- [ ] Controllato che le immagini siano state scaricate
- [ ] Testato almeno 3-5 schede razza sul frontend
- [ ] Verificato che il layout sia corretto (desktop e mobile)
- [ ] Controllato che le caratteristiche con le stelline funzionino
- [ ] Verificato i link agli allevatori (se presenti)

## 🎯 Prossimi Passi (Opzionali)

Dopo l'importazione puoi:

1. **Ottimizzare le immagini**
   - Plugin consigliato: ShortPixel, Imagify, EWWW
   - Rigenera le thumbnail: WP-CLI o plugin

2. **Configurare SEO**
   - Yoast SEO / Rank Math
   - Meta description personalizzate

3. **Performance**
   - Caching (WP Rocket, W3 Total Cache)
   - CDN per le immagini

---

**Tutto pronto per l'importazione! 🚀**

I file sono stati rigenerati con successo usando il prompt migliorato.
Nessun errore JSON, struttura perfetta al 100%.
