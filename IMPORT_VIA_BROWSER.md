# 🌐 Importazione Razze via Browser (Senza SSH)

## Panoramica

Questa guida ti permette di importare tutte le 320 razze **direttamente dal browser**, senza bisogno di accesso SSH.

## 📋 Prerequisiti

- ✅ Accesso FTP al server WordPress
- ✅ WordPress installato e funzionante
- ✅ ACF PRO installato
- ✅ Tema attivo con campi ACF configurati

## 🚀 Procedura (4 Passi)

### Passo 1: Carica i File via FTP

Connettiti al tuo server FTP e carica questi file/cartelle nella **root di WordPress** (stessa cartella di `wp-config.php`):

```
wordpress/
├── wp-config.php (già presente)
├── wp-load.php (già presente)
├── complete corrette/          ← CARICA QUESTA CARTELLA
│   ├── b01.json
│   ├── b02.json
│   └── ... (tutti i 32 file)
├── web-import-razze.php        ← CARICA QUESTO FILE
└── web-import-razze-ajax.php   ← CARICA QUESTO FILE
```

**File da caricare:**
1. `web-import-razze.php` (interfaccia web)
2. `web-import-razze-ajax.php` (gestore importazione)
3. Cartella `complete corrette/` con tutti i 32 file JSON

### Passo 2: Cambia la Password (Opzionale ma Consigliato)

Apri il file `web-import-razze.php` con un editor di testo e modifica la password alla riga 17:

```php
// PRIMA (password predefinita)
define('IMPORT_PASSWORD', 'importa2024');

// DOPO (tua password personalizzata)
define('IMPORT_PASSWORD', 'lamiapasswordsicura123');
```

### Passo 3: Esegui l'Importazione

1. **Apri il browser** e vai a:
   ```
   https://www.tuosito.it/web-import-razze.php
   ```

2. **Inserisci la password**:
   - Password predefinita: `importa2024`
   - Oppure quella che hai impostato al Passo 2

3. **Clicca "Avvia Importazione"**

4. **Attendi il completamento**:
   - Vedrai il progresso in tempo reale
   - Ogni razza importata apparirà nel log
   - L'importazione richiede circa 10-20 minuti

### Passo 4: Pulizia e Verifica

1. **Elimina i file temporanei** (IMPORTANTE per sicurezza):
   - `web-import-razze.php`
   - `web-import-razze-ajax.php`
   - Opzionale: cartella `complete corrette/` (puoi tenerla come backup)

2. **Verifica in WordPress**:
   - Vai su `Razze di Cani` → `Tutte le razze`
   - Dovresti vedere **320 razze**

3. **Testa il frontend**:
   - Visita una scheda razza (es: `/razze_di_cani/airedale-terrier/`)
   - Verifica layout, immagini, caratteristiche

## 🎨 Cosa Vedrai Durante l'Importazione

L'interfaccia web mostra:

- **📊 Dashboard con statistiche**
  - Razze totali: 320
  - File JSON: 32
  - Razze importate: aggiornato in tempo reale

- **📈 Barra di progresso**
  - Percentuale completamento
  - Aggiornamento in tempo reale

- **📝 Log in tempo reale**
  - ✓ Nome razza importata
  - ID post creato
  - Eventuali errori

## ⚠️ Risoluzione Problemi

### Errore: "Pagina bianca"
**Causa**: Errore PHP
**Soluzione**: Attiva il debug WordPress:
```php
// In wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
```

### Errore: "Maximum execution time exceeded"
**Causa**: Timeout PHP
**Soluzione**: Aumenta il timeout nel file `.htaccess`:
```apache
php_value max_execution_time 600
php_value memory_limit 512M
```

### Errore: "Cartella 'complete corrette' non trovata"
**Causa**: File non nella posizione corretta
**Soluzione**: Assicurati che la cartella sia nella **root di WordPress**, non in sottocartelle

### L'importazione si blocca al 50%
**Causa**: Problemi di connessione o timeout del browser
**Soluzione**:
- Ricarica la pagina e riavvia l'importazione
- Le razze già importate saranno saltate automaticamente

## 🔒 Note di Sicurezza

1. **Cambia sempre la password** prima di usare lo script
2. **Elimina i file** dopo l'importazione
3. **Non lasciare i file sul server** per evitare accessi non autorizzati
4. Lo script ha protezione con password ma è solo temporaneo

## ✅ Checklist Post-Importazione

- [ ] Eliminato `web-import-razze.php`
- [ ] Eliminato `web-import-razze-ajax.php`
- [ ] Verificato che ci siano 320 razze in WordPress
- [ ] Testato almeno 3 schede razza sul frontend
- [ ] Verificato che immagini e ACF siano popolati
- [ ] Verificato layout responsive (desktop e mobile)

## 💡 Vantaggi di Questo Metodo

✅ **Nessun accesso SSH richiesto**
✅ **Interfaccia visuale semplice**
✅ **Progresso in tempo reale**
✅ **Gestione automatica duplicati**
✅ **Riavviabile in caso di interruzione**
✅ **Log dettagliato di tutte le operazioni**

## 📞 Supporto

Se l'importazione fallisce:

1. Controlla il log nella schermata web
2. Verifica i log di WordPress: `wp-content/debug.log`
3. Verifica che ACF PRO sia attivo
4. Controlla che i campi ACF siano configurati correttamente

---

**Tempo totale stimato: 25-35 minuti**
- Upload file via FTP: 5-10 minuti
- Esecuzione importazione: 15-20 minuti
- Verifica e pulizia: 5 minuti
