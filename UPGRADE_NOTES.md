# Note di Aggiornamento - Sistema Scheda Razza v2.0

## 🎉 Novità Implementate

### ✅ Nuovo Layout 1/3 + 2/3

Il layout della scheda razza è stato completamente ridisegnato:

**Desktop:**
- **Colonna Principale (2/3 - Sinistra):**
  - Titolo razza
  - Descrizione generale
  - Sezioni contenuto (Origini, Aspetto, Carattere, Salute, Addestramento, Ideale Per)
  - Box caratteristiche con zampette 🐾

- **Sidebar (1/3 - Destra):**
  - Immagine in evidenza
  - Box informazioni razza (Nazione, Colorazioni, Temperamento)
  - Box caratteristiche fisiche
  - Allevamenti collegati

**Mobile:**
- Layout invertito: prima contenuto, poi sidebar

### ✅ Nuovi Campi ACF

#### 1. Gruppo "Informazioni Razza (Sidebar)"
Posizione: Sidebar WordPress (colonna destra nell'editor)

- **`nazione_origine`** (Text)
  - Esempio: "Italia", "Germania", "Stati Uniti"

- **`colorazioni`** (Textarea)
  - Esempio: "Nero, Marrone, Bianco, Fulvo"
  - Una per riga o separate da virgole

- **`temperamento_breve`** (Text - max 100 caratteri)
  - Esempio: "Affettuoso, Energico, Protettivo"

#### 2. Gruppo "Contenuto Razza - Sezioni"
Posizione: Corpo principale editor (tabs a sinistra)

Tutti i campi sono WYSIWYG per inserire contenuto formattato:

- **`descrizione_generale`** - Breve introduzione (2-3 paragrafi)
- **`origini_storia`** - Storia e origini della razza
- **`aspetto_fisico`** - Descrizione fisica (taglia, peso, mantello)
- **`carattere_temperamento`** - Carattere e temperamento
- **`salute_cura`** - Informazioni su salute e cure
- **`attivita_addestramento`** - Attività fisica e addestramento
- **`ideale_per`** - Per chi è adatta questa razza

#### 3. Gruppo "Caratteristiche Razza (Sistema Zampette)"
Tutti i 18 campi range slider da 1 a 5 (step 0.5):

**Tab Temperamento:**
- energia_e_livelli_di_attivita
- affettuosita
- vocalita_e_predisposizione_ad_abbaiare
- socievolezza_cani

**Tab Adattabilità:**
- adattabilita_appartamento
- adattabilita_clima_caldo
- adattabilita_clima_freddo
- tolleranza_alla_solitudine

**Tab Famiglia & Socialità:**
- compatibilita_con_i_bambini
- tolleranza_estranei
- compatibilita_con_altri_animali_domestici

**Tab Addestramento & Cura:**
- facilita_di_addestramento
- intelligenza
- esigenze_di_esercizio
- facilita_toelettatura
- cura_e_perdita_pelo_
- predisposizioni_per_la_salute

**Tab Esperienza & Altri:**
- livello_esperienza_richiesto
- costo_mantenimento
- istinti_di_caccia

### ✅ CSS Migliorato

Il nuovo file `css/single-razza.css` include:

- **Layout Grid Responsive:** 2/3 + 1/3 su desktop, stack su mobile
- **Sidebar Sticky:** La sidebar rimane visibile durante lo scroll
- **Zampette Multi-colonna:** Le caratteristiche sono disposte in 2-3 colonne
- **Design Migliorato:**
  - Box con bordi colorati e gradient
  - Hover effects animati
  - Icone emoji per ogni sezione
  - Paw icons più grandi e visibili
- **Accessibility:** Focus states e ARIA labels
- **Dark Mode:** Supporto automatico per schema scuro
- **Print Styles:** Layout ottimizzato per stampa

### ✅ Template Aggiornato

Il file `single-razze_di_cani.php` è stato completamente riscritto:

- Nuovo layout grid con ordine invertito su mobile
- Lettura dinamica delle sezioni ACF
- Icone emoji per ogni sezione
- Box informazioni con styling differenziato
- Backward compatibility con vecchi campi

---

## 📥 Come Importare i Nuovi Campi ACF

### Opzione 1: Import JSON Completo (RACCOMANDATO)

1. Vai su **Dashboard WordPress → Custom Fields → Tools**
2. Nella sezione "Import Field Groups", clicca **"Choose File"**
3. Seleziona il file: **`acf-breed-complete.json`**
4. Clicca **"Import JSON"**
5. Verifica che siano stati importati 3 gruppi di campi:
   - Informazioni Razza (Sidebar)
   - Contenuto Razza - Sezioni
   - Caratteristiche Razza (Sistema Zampette)

### Opzione 2: Registrazione PHP (Già Attiva)

I campi sono già registrati programmaticamente in:
- `wp-content/themes/theme-caniincasa/inc/custom-fields.php`

Basta attivare il tema e saranno disponibili automaticamente.

---

## 🔄 Migrazione Dati Esistenti

### Se hai già razze con il campo `post_content` popolato:

Il template è **backward compatible**. Le sezioni nel `post_content` continueranno a funzionare, ma dovresti migrare i contenuti nei nuovi campi ACF per sfruttare il nuovo layout.

#### Script di Migrazione Semi-Automatico

Puoi usare questo snippet per estrarre le sezioni dal `post_content` e popolare i campi ACF:

```php
<?php
// Migrazione contenuto razze esistenti
// Esegui una sola volta via wp-cli o script temporaneo

$args = array(
    'post_type'      => 'razze_di_cani',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
);

$breeds = get_posts( $args );

foreach ( $breeds as $breed ) {
    $content = $breed->post_content;

    // Estrai sezioni con regex
    preg_match( '/<h2>Origini e Storia<\/h2>(.*?)<h2>/s', $content, $origini );
    preg_match( '/<h2>Aspetto Fisico<\/h2>(.*?)<h2>/s', $content, $aspetto );
    preg_match( '/<h2>Carattere e Temperamento<\/h2>(.*?)<h2>/s', $content, $carattere );
    preg_match( '/<h2>Salute e Cura<\/h2>(.*?)<h2>/s', $content, $salute );
    preg_match( '/<h2>Attività e Addestramento<\/h2>(.*?)<h2>/s', $content, $attivita );
    preg_match( '/<h2>Ideale Per<\/h2>(.*?)$/s', $content, $ideale );

    // Popola campi ACF
    if ( ! empty( $origini[1] ) ) {
        update_field( 'origini_storia', trim( $origini[1] ), $breed->ID );
    }
    if ( ! empty( $aspetto[1] ) ) {
        update_field( 'aspetto_fisico', trim( $aspetto[1] ), $breed->ID );
    }
    if ( ! empty( $carattere[1] ) ) {
        update_field( 'carattere_temperamento', trim( $carattere[1] ), $breed->ID );
    }
    if ( ! empty( $salute[1] ) ) {
        update_field( 'salute_cura', trim( $salute[1] ), $breed->ID );
    }
    if ( ! empty( $attivita[1] ) ) {
        update_field( 'attivita_addestramento', trim( $attivita[1] ), $breed->ID );
    }
    if ( ! empty( $ideale[1] ) ) {
        update_field( 'ideale_per', trim( $ideale[1] ), $breed->ID );
    }

    echo "✓ Migrata: " . $breed->post_title . "\n";
}
```

**⚠️ IMPORTANTE:** Testa prima su un ambiente di sviluppo!

---

## 🎨 Personalizzazione CSS

Se vuoi personalizzare i colori o lo stile:

Modifica il file: `wp-content/themes/theme-caniincasa/css/single-razza.css`

### Variabili CSS Principali:

```css
--primary: #D35400;              /* Colore primario (arancione) */
--primary-light: #E67E22;        /* Arancione chiaro */
--primary-dark: #A04000;         /* Arancione scuro */
--color-text: #333;              /* Testo principale */
--color-text-light: #666;        /* Testo secondario */
--color-border: #e0e0e0;         /* Bordi */
```

### Modificare Numero di Colonne Zampette:

```css
@media (min-width: 768px) {
    .characteristic-list {
        grid-template-columns: repeat(2, 1fr); /* Cambia 2 con 3 o 4 */
    }
}
```

---

## 🐞 Troubleshooting

### Le zampette non appaiono
- Verifica che il file `css/single-razza.css` sia caricato (Ctrl+U e cerca "single-razza")
- Controlla che i campi ACF abbiano valori numerici
- Svuota cache browser e plugin di caching

### I nuovi campi non appaiono nell'editor
- Vai su **Custom Fields → Field Groups**
- Verifica che i 3 gruppi siano attivi
- Controlla la location rule (deve essere `post_type == razze_di_cani`)

### Il layout non è 1/3 + 2/3
- Verifica che il CSS sia caricato correttamente
- Controlla la classe `.razza-layout` con DevTools
- Prova a svuotare la cache CSS

### Su mobile la sidebar appare prima
- Verifica la proprietà `order` in CSS
- Il template usa `order: 1` per content e `order: 2` per sidebar
- Su mobile l'ordine dovrebbe essere corretto automaticamente

---

## 📝 Checklist Post-Aggiornamento

- [ ] Importato `acf-breed-complete.json` in ACF
- [ ] Verificato che i 3 gruppi di campi siano attivi
- [ ] Testato il layout su una razza esistente
- [ ] Popolato i nuovi campi sidebar (nazione, colorazioni, temperamento)
- [ ] Migrato contenuto da `post_content` ai campi WYSIWYG
- [ ] Verificato visualizzazione zampette
- [ ] Testato responsive su mobile/tablet
- [ ] Svuotato cache (browser + plugin)

---

## 🚀 Prossimi Passi

### Funzionalità Future Consigliate:

1. **Dog Finder Quiz**
   - Form con 10-12 domande
   - Algoritmo matching basato su caratteristiche
   - Suggerimento 3-4 razze ideali

2. **Filtri Avanzati Archivio**
   - Filtro per caratteristiche (slider)
   - Filtro per taglia/peso
   - Filtro per temperamento

3. **Comparatore Razze**
   - Confronto side-by-side di 2-3 razze
   - Visualizzazione differenze caratteristiche
   - Export PDF comparazione

4. **Import Bulk da AI**
   - Script per generare contenuti con GPT-4
   - Populate automatico 476 razze
   - Revisione manuale contenuti

---

## 📞 Supporto

Per problemi o domande:
- Consulta la documentazione ACF: https://www.advancedcustomfields.com/resources/
- Controlla il file: `SAMPLE_BREEDS_GUIDE.md` per esempi
- Verifica i log di WordPress: `wp-content/debug.log`

---

**Versione:** 2.0.0
**Data Rilascio:** 2025-01-13
**Compatibilità:** WordPress 6.4+, ACF PRO 6.0+, PHP 8.1+
