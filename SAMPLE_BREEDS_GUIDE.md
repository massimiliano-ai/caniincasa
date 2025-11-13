# Guida all'Importazione delle Razze di Esempio

Questo repository include file di esempio per l'importazione di 3 razze canine complete con tutti i campi ACF del sistema di valutazione con zampette.

## File Inclusi

- **`sample-breeds-import.csv`** - Formato CSV per importazione con WP All Import
- **`sample-breeds-import.json`** - Formato JSON per importazione programmatica o via REST API
- Questo file guida

## Razze Incluse

Le 3 razze di esempio sono state scelte per rappresentare tipologie molto diverse:

### 1. Labrador Retriever
**Profilo**: Cane da famiglia attivo e affettuoso
- ✅ Alto livello di energia (4.5/5)
- ✅ Estremamente affettuoso (5/5)
- ✅ Perfetto con bambini (5/5)
- ✅ Facilissimo da addestrare (5/5)
- ⚠️ Non ideale per appartamenti piccoli (3.5/5)
- ⚠️ Non ama stare da solo (2.5/5)

### 2. Chihuahua
**Profilo**: Cane da compagnia per appartamento
- ✅ Perfetto per appartamento (5/5)
- ✅ Bassa necessità di esercizio (2.5/5)
- ✅ Facile toelettatura (4.5/5)
- ✅ Ideale per principianti (1/5)
- ⚠️ Diffidente con estranei (2.5/5)
- ⚠️ Tende ad abbaiare (4/5)

### 3. Pastore Tedesco
**Profilo**: Cane da lavoro intelligente e protettivo
- ✅ Altissima intelligenza (5/5)
- ✅ Eccellente addestrabilità (5/5)
- ✅ Alto bisogno di esercizio (5/5)
- ✅ Buono con i bambini (4/5)
- ⚠️ Richiede esperienza (3.5/5)
- ⚠️ Non adatto ad appartamenti (2.5/5)

---

## Metodo 1: Importazione CSV con WP All Import

### Requisiti
- Plugin **WP All Import** (gratuito o PRO)
- Plugin **WP All Import - ACF Add-On** (per importare campi ACF)

### Procedura

1. **Installa i Plugin**
   ```
   Dashboard → Plugin → Aggiungi Nuovo
   Cerca: "WP All Import"
   Installa e Attiva
   ```

2. **Avvia Nuova Importazione**
   ```
   Dashboard → All Import → New Import
   Carica il file: sample-breeds-import.csv
   ```

3. **Configura l'Importazione**
   - **Step 1 - Choose File**: Seleziona il file CSV caricato
   - **Step 2 - Review Import File**: Verifica che le colonne siano rilevate correttamente
   - **Step 3 - Choose Post Type**: Seleziona **"Razze di Cani"** (razze_di_cani)
   - **Step 4 - Drag & Drop**:
     - Mappa `post_title` → Titolo
     - Mappa `post_content` → Contenuto
     - Mappa `post_excerpt` → Estratto
     - Mappa tutti i campi ACF (energia_e_livelli_di_attivita, affettuosita, ecc.)

4. **Impostazioni Importazione**
   - **Unique Identifier**: Usa `post_title` per evitare duplicati
   - **If record exists**: Skip (salta) o Update (aggiorna)

5. **Conferma e Importa**
   - Clicca "Confirm & Run Import"
   - Attendi il completamento

### Note CSV
- I campi ACF devono corrispondere esattamente ai nomi dei campi
- I valori numerici usano il punto come separatore decimale (es. 4.5)
- Il contenuto HTML è incluso nel campo `post_content`

---

## Metodo 2: Importazione JSON Programmatica

### Opzione A: Script PHP Custom

Crea uno script PHP temporaneo in `wp-content/themes/theme-caniincasa/import-breeds.php`:

```php
<?php
/**
 * Script di importazione razze di esempio
 * Usare una sola volta, poi eliminare
 */

// Carica WordPress
require_once( '../../../wp-load.php' );

// Verifica ACF
if ( ! function_exists( 'update_field' ) ) {
    die( 'ACF non è installato!' );
}

// Leggi il file JSON
$json_file = file_get_contents( __DIR__ . '/../../../../sample-breeds-import.json' );
$breeds = json_decode( $json_file, true );

foreach ( $breeds as $breed ) {
    // Verifica se la razza esiste già
    $existing = get_page_by_title( $breed['post_title'], OBJECT, 'razze_di_cani' );

    if ( $existing ) {
        echo "Razza già esistente: " . $breed['post_title'] . "\n";
        continue;
    }

    // Crea il post
    $post_data = array(
        'post_title'   => $breed['post_title'],
        'post_content' => $breed['post_content'],
        'post_excerpt' => $breed['post_excerpt'],
        'post_type'    => $breed['post_type'],
        'post_status'  => $breed['post_status'],
        'post_name'    => $breed['meta']['slug'],
    );

    $post_id = wp_insert_post( $post_data );

    if ( is_wp_error( $post_id ) ) {
        echo "Errore: " . $post_id->get_error_message() . "\n";
        continue;
    }

    // Aggiungi i campi ACF
    foreach ( $breed['acf'] as $field_name => $field_value ) {
        update_field( $field_name, $field_value, $post_id );
    }

    echo "✓ Importata: " . $breed['post_title'] . " (ID: {$post_id})\n";
}

echo "\nImportazione completata!\n";
```

**Esecuzione dello script**:
```bash
cd wp-content/themes/theme-caniincasa
php import-breeds.php
```

**⚠️ IMPORTANTE**: Elimina lo script dopo l'uso per sicurezza!

### Opzione B: WP-CLI

Se hai WP-CLI installato:

```bash
# Naviga nella directory WordPress
cd /path/to/wordpress

# Importa ogni razza dal JSON
wp post create \
  --post_type=razze_di_cani \
  --post_title="Labrador Retriever" \
  --post_status=publish \
  --post_content="<contenuto>" \
  --meta_input='{"energia_e_livelli_di_attivita":4.5,...}'
```

---

## Metodo 3: Importazione Manuale (Copy-Paste)

Se preferisci un approccio manuale:

1. **Crea Nuovo Post**
   ```
   Dashboard → Razze di Cani → Aggiungi Nuova
   ```

2. **Inserisci i Dati Base**
   - Copia il titolo dal JSON/CSV
   - Incolla il contenuto HTML nell'editor
   - Aggiungi l'estratto

3. **Compila i Campi ACF**
   - Scorri verso il basso ai field groups
   - Usa gli slider per impostare i valori delle 18 caratteristiche
   - I valori sono indicati nel JSON (campo `acf`)

4. **Pubblica**
   - Imposta lo slug manualmente se necessario
   - Clicca "Pubblica"

---

## Struttura dei Campi ACF

Ogni razza include 18 caratteristiche valutate da 1 a 5 (con incrementi di 0.5):

### Temperamento & Comportamento
- `energia_e_livelli_di_attivita` - Livello di energia del cane
- `affettuosita` - Quanto è affettuoso
- `vocalita_e_predisposizione_ad_abbaiare` - Tendenza ad abbaiare
- `socievolezza_cani` - Socialità con altri cani

### Adattabilità
- `adattabilita_appartamento` - Adattabilità alla vita in appartamento
- `adattabilita_clima_caldo` - Tolleranza al caldo
- `adattabilita_clima_freddo` - Tolleranza al freddo
- `tolleranza_alla_solitudine` - Capacità di stare da solo

### Famiglia & Socialità
- `compatibilita_con_i_bambini` - Adatto a famiglie con bambini
- `tolleranza_estranei` - Comportamento con estranei
- `compatibilita_con_altri_animali_domestici` - Convivenza con altri animali

### Addestramento & Cura
- `facilita_di_addestramento` - Facilità di addestramento
- `intelligenza` - Intelligenza e problem solving
- `esigenze_di_esercizio` - Bisogno di attività fisica
- `facilita_toelettatura` - Facilità di cura del pelo
- `cura_e_perdita_pelo_` - Perdita di pelo
- `predisposizioni_per_la_salute` - Robustezza generale

### Esperienza & Altri
- `livello_esperienza_richiesto` - Livello esperienza padrone (1=principianti, 5=esperti)
- `costo_mantenimento` - Costo medio di mantenimento
- `istinti_di_caccia` - Istinto predatorio

---

## Visualizzazione Frontend

Una volta importate, le razze saranno visibili:

- **Singola Razza**: `https://tuosito.it/razze_di_cani/labrador-retriever/`
- **Sistema Zampette**: Le valutazioni appariranno con 🐾 (piene) e 🐾 (vuote/opache)
- **5 Tab Organizzati**: Temperamento, Adattabilità, Famiglia, Addestramento, Esperienza

---

## Verifica dell'Importazione

Dopo l'importazione, verifica:

1. ✅ Le razze sono visibili in `Dashboard → Razze di Cani`
2. ✅ Tutti i 18 campi ACF sono compilati
3. ✅ La pagina frontend mostra le zampette correttamente
4. ✅ I contenuti HTML sono formattati correttamente
5. ✅ Gli slug/permalink sono corretti

---

## Troubleshooting

### Le zampette non appaiono
- Verifica che il file CSS sia caricato: `breed-characteristics.css`
- Controlla che i campi ACF abbiano valori numerici (non stringhe)
- Svuota la cache del browser/plugin

### Campi ACF non importati
- Verifica che il field group sia attivo
- Controlla che i nomi dei campi corrispondano esattamente
- Assicurati che ACF PRO sia installato

### Contenuto HTML non formattato
- Controlla che l'editor WordPress sia in modalità "Visual"
- Verifica che i tag HTML siano permessi nelle impostazioni

### Errori durante importazione CSV
- Verifica la codifica del file (UTF-8)
- Controlla che non ci siano virgolette non chiuse
- Assicurati che WP All Import ACF Add-On sia attivo

---

## Estensione del Dataset

Per aggiungere più razze:

1. **Duplica una voce esistente** nel CSV/JSON
2. **Modifica i valori** secondo la nuova razza
3. **Ricerca informazioni accurate** sui siti ufficiali di cinofilia
4. **Valuta le caratteristiche** con oggettività (1-5)

### Fonti Raccomandate per Dati
- FCI (Fédération Cynologique Internationale)
- AKC (American Kennel Club)
- ENCI (Ente Nazionale Cinofilia Italiana)
- Allevatori certificati e standard di razza

---

## Automatizzazione Futura

Considera l'implementazione di:

1. **Importazione Bulk**: Script per importare centinaia di razze da API esterne
2. **AI-Assisted Data**: Usa GPT-4 per generare descrizioni e valutazioni
3. **Sync con Database Esterni**: Mantieni sincronizzato con database FCI/ENCI
4. **Sistema di Revisione**: Permetti agli utenti registrati di suggerire modifiche

---

## Supporto

Per problemi con l'importazione:
- Controlla i log di WordPress: `wp-content/debug.log`
- Verifica la documentazione di WP All Import
- Consulta la documentazione ACF per i campi personalizzati

---

**Data Creazione**: 2025-01-13
**Versione**: 1.0.0
**Autore**: Claude (AI Assistant)
**Licenza**: Uso interno per progetto caniincasa.it
