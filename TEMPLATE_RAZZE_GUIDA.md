# 🐕 Guida Template Razze con Filtri

## Panoramica

È stato creato un **Page Template** che puoi assegnare a qualsiasi pagina WordPress per visualizzare tutte le razze con filtri di ricerca avanzati.

### ✨ Caratteristiche

- ✅ **Layout identico al sito live** - Replica fedelmente https://www.caniincasa.it/razze-di-cani/
- ✅ **Griglia responsive** - 3/2/1 colonne su desktop/tablet/mobile
- ✅ **Filtri AJAX in tempo reale** - Nessun ricaricamento pagina
- ✅ **7 tipi di filtri** - Ricerca, dimensione, energia, appartamento, bambini, esperienza, ordinamento
- ✅ **Vista griglia/lista** - Toggle tra due modalità di visualizzazione
- ✅ **Paginazione progressiva** - Load More button
- ✅ **Animazioni fluide** - Card animate all'apparizione
- ✅ **Mobile friendly** - Ottimizzato per tutti i dispositivi

---

## 📁 File Creati

### Template PHP
**`wp-content/themes/theme-caniincasa/page-templates/template-razze-archive.php`**
- Page template WordPress richiamabile da qualsiasi pagina
- Struttura HTML con sidebar filtri e griglia risultati
- Integrazione completa con sistema AJAX

### CSS
**`wp-content/themes/theme-caniincasa/css/page-razze-archive.css`**
- Stile completo basato sul sito live
- Colori: Header #FFCC70, Link #e65229, Card background #f2f2f0
- Griglia responsive con breakpoints: 1380px, 1024px, 600px
- Animazioni e transizioni smooth
- 600+ righe di CSS ottimizzato

### JavaScript
**`wp-content/themes/theme-caniincasa/js/page-razze-filters.js`**
- Gestione interattiva dei filtri
- Chiamate AJAX al backend
- Rendering dinamico delle card razze
- Debounce per ricerca testuale (500ms)
- Gestione loading states e paginazione
- 350+ righe di JavaScript

### Backend AJAX
**`wp-content/themes/theme-caniincasa/inc/razze-ajax-filters.php`**
- Handler AJAX già esistente (riutilizzato)
- Filtraggio per tutti i parametri
- Restituisce JSON con razze filtrate

---

## 🚀 Come Usare il Template

### Passo 1: Crea una Nuova Pagina

1. Vai su **WordPress Admin** → **Pagine** → **Aggiungi nuova**
2. Inserisci il titolo della pagina, es: "Razze di Cani"
3. (Opzionale) Aggiungi una descrizione introduttiva nel contenuto

### Passo 2: Assegna il Template

1. Nella sidebar destra, trova il box **Attributi della pagina**
2. Nel menu a tendina **Template**, seleziona: **"Archivio Razze con Filtri"**
3. Clicca **Pubblica**

### Passo 3: Configura Slug (Opzionale)

Per replicare l'URL del sito live (`/razze-di-cani/`):

1. Nella sidebar, clicca su **Permalink**
2. Imposta lo slug: `razze-di-cani`
3. Aggiorna la pagina

### Passo 4: Verifica

Visita la pagina creata. Dovresti vedere:
- Hero con titolo e descrizione
- Sidebar con filtri a sinistra
- Griglia con card razze a destra
- Filtri funzionanti in tempo reale

---

## 🎯 Filtri Disponibili

### 1. Ricerca Testuale
- Input per cercare per nome razza
- Debounce di 500ms per ottimizzare le chiamate AJAX
- Case-insensitive

### 2. Dimensione (Checkbox)
- ☐ Piccola
- ☐ Media
- ☐ Grande
- ☐ Gigante

### 3. Livello di Energia (Range 0-5)
- Slider da "Basso" a "Alto"
- Basato sul campo ACF `energia_e_livelli_di_attivita`

### 4. Adatto ad Appartamento (Range 0-5)
- Slider da "No" a "Ideale"
- Basato sul campo ACF `adattabilita_appartamento`

### 5. Compatibile con Bambini (Range 0-5)
- Slider da "No" a "Ottimo"
- Basato sul campo ACF `compatibilita_con_i_bambini`

### 6. Esperienza Richiesta (Range 0-5)
- Slider da "Principiante" a "Esperto"
- Basato sul campo ACF `livello_esperienza_richiesto`

### 7. Ordinamento
- Nome A-Z
- Nome Z-A
- Più Popolari (basato su visualizzazioni)

### Bottone Reset
Resetta tutti i filtri e mostra tutte le razze

---

## 🎨 Layout e Stile

### Card Razza

Ogni card include:
- **Immagine**: 400x320px (aspect ratio 16:9) con lazy loading
- **Titolo**: Font Baloo 2, 18px, peso 600
- **Background**: #f2f2f0 con padding 9px
- **Hover**: Lift effect con shadow
- **Meta** (opzionale): Icone energia e appartamento

### Griglia Responsive

```
Desktop (>1380px):  3 colonne
Tablet (1024-1380): 3 colonne
Tablet (600-1024):  2 colonne
Mobile (<600px):    1 colonna
```

### Colori Tema

| Elemento | Colore | Uso |
|----------|--------|-----|
| Header | #FFCC70 | Background header |
| Testo Header | #4d3319 | Titoli marrone |
| Card Background | #f2f2f0 | Sfondo card |
| Link/Hover | #e65229 | Link e hover arancione |
| Border Radius | 5px | Tutti gli elementi |

### Font

- **Titoli**: Baloo 2, 39px
- **Testo**: Open Sans, 17px
- **Card Title**: Baloo 2, 18px

---

## 🔧 Personalizzazione

### Modificare i Colori

Modifica le variabili CSS in `page-razze-archive.css`:

```css
:root {
    --razze-header-bg: #FFCC70;      /* Background header */
    --razze-header-text: #4d3319;    /* Testo header */
    --razze-card-bg: #f2f2f0;        /* Background card */
    --razze-link-hover: #e65229;     /* Link hover */
    --razze-border-radius: 5px;       /* Border radius */
}
```

### Modificare il Numero di Razze per Pagina

Modifica in `inc/razze-ajax-filters.php`, riga ~35:

```php
$per_page = 24; // Cambia questo valore
```

### Cambiare la Griglia

Modifica i breakpoints in `page-razze-archive.css`:

```css
.razze-grid {
    grid-template-columns: repeat(3, 1fr); /* Numero colonne */
    gap: 1.5rem; /* Spaziatura */
}
```

### Aggiungere Campi ACF alle Card

Modifica la funzione `createBreedCard()` in `page-razze-filters.js`:

```javascript
// Aggiungi dopo il titolo
if (breed.excerpt) {
    const excerpt = $('<p>', {
        class: 'razza-card-excerpt',
        text: breed.excerpt
    });
    content.append(excerpt);
}
```

---

## 📊 Come Funziona

### Flusso di Filtraggio

1. **Utente interagisce con un filtro** (es: muove slider energia)
2. **JavaScript** raccoglie tutti i valori filtri attivi
3. **Debounce** (500ms per la ricerca) evita chiamate AJAX eccessive
4. **AJAX request** inviata a `admin-ajax.php` con action `filter_razze`
5. **PHP backend** (razze-ajax-filters.php):
   - Costruisce WP_Query con parametri filtri
   - Filtra per meta fields ACF
   - Post-filtra per dimensione (meta query)
   - Ordina risultati
   - Restituisce JSON con razze matchate
6. **JavaScript riceve risposta**:
   - Svuota griglia se pagina 1
   - Aggiunge card razze con animazione stagger
   - Aggiorna contatore risultati
   - Mostra/nasconde "Load More" button

### Dati AJAX Passati

```javascript
{
    action: 'filter_razze',
    nonce: 'xxxxx',
    search: 'labrador',
    sizes: ['media', 'grande'],
    energy: 4.0,
    apartment: 3.5,
    kids: 4.5,
    experience: 2.0,
    sort_by: 'name-asc',
    paged: 1
}
```

### Risposta Backend

```json
{
    "success": true,
    "data": {
        "breeds": [
            {
                "id": 123,
                "title": "Labrador Retriever",
                "url": "https://...",
                "image": "https://...",
                "excerpt": "...",
                "meta": {
                    "energia": 4.5,
                    "appartamento": 3.0
                }
            }
        ],
        "total": 45,
        "has_more": true
    }
}
```

---

## 🐛 Troubleshooting

### I filtri non funzionano

**Verifica**:
1. Console browser per errori JavaScript
2. Scheda Network → XHR per vedere le chiamate AJAX
3. Verifica che `razzeFilterData` sia definito (View Page Source)

**Soluzione**:
```javascript
// In console browser, verifica:
console.log(razzeFilterData);
// Deve mostrare: { ajaxurl: '...', nonce: '...' }
```

### Le card non appaiono

**Verifica**:
1. Hai importato le razze? (Vedi IMPORT_GUIDE.md)
2. Le razze hanno `post_status = 'publish'`?
3. Risposta AJAX restituisce `breeds`?

**Debug**:
```php
// In inc/razze-ajax-filters.php, aggiungi:
error_log(print_r($query->posts, true));
```

### Stile non corretto

**Verifica**:
1. Il CSS è caricato? (Inspect → Network → CSS)
2. Il template è assegnato correttamente alla pagina?

**Forza refresh**:
- CTRL + F5 (hard refresh)
- Svuota cache plugin caching

### AJAX restituisce 0

**Problema**: Il nonce non è valido o l'action non è registrato

**Soluzione**:
```php
// Verifica in inc/razze-ajax-filters.php che ci siano:
add_action( 'wp_ajax_filter_razze', 'caniincasa_filter_razze' );
add_action( 'wp_ajax_nopriv_filter_razze', 'caniincasa_filter_razze' );
```

---

## 🎯 Differenze con Archive Template

Hai **due opzioni** per visualizzare le razze:

### 1. Archive Template (CPT)
**File**: `archive-razze_di_cani.php`
**URL automatico**: `/razze_di_cani/` (generato da WordPress)
**Uso**: Archivio nativo del Custom Post Type

### 2. Page Template (Questo)
**File**: `page-templates/template-razze-archive.php`
**URL personalizzabile**: Qualsiasi (es: `/razze-di-cani/`, `/cani/`, `/elenco-razze/`)
**Uso**: Pagina statica con template custom

**Consiglio**: Usa il **Page Template** se vuoi:
- URL personalizzato (es: `/razze-di-cani/` invece di `/razze_di_cani/`)
- Contenuto introduttivo editabile dalla pagina
- Più controllo sul layout e posizionamento

---

## 📋 Checklist Pre-Pubblicazione

Prima di pubblicare la pagina:

- [ ] Razze importate (almeno 10-20 per testare)
- [ ] Template assegnato alla pagina
- [ ] Slug impostato correttamente
- [ ] Testato almeno 3-4 filtri diversi
- [ ] Verificato su desktop, tablet, mobile
- [ ] Controllato che "Load More" funzioni
- [ ] Testato reset filtri
- [ ] Verificato link alle schede razze
- [ ] Controllato che le immagini si carichino
- [ ] Testato con 0 risultati (filtri impossibili)

---

## 🚀 Prossimi Passi (Opzionali)

Dopo aver testato il template, puoi:

1. **Aggiungere più filtri**
   - Filtro per paese di origine
   - Filtro per gruppi FCI
   - Range peso/altezza

2. **Migliorare UX**
   - Filtri mobile in drawer slide-in
   - Infinite scroll alternativo a Load More
   - Filtri salvati in URL (deep linking)

3. **Performance**
   - Caching risultati filtri
   - Lazy loading immagini progressive
   - Preload immagini visibili

4. **Features**
   - Comparatore razze (seleziona 2-3 e confronta)
   - Wishlist/Preferiti
   - Condivisione social filtri applicati

---

## 📝 Note Tecniche

### Compatibilità

- **WordPress**: 6.0+
- **PHP**: 7.4+
- **ACF**: PRO (per i campi razze)
- **jQuery**: Incluso in WordPress

### Performance

- **Chiamate AJAX**: Debounced (500ms search)
- **Paginazione**: 24 razze per batch
- **Lazy Loading**: Immagini con loading="lazy"
- **Animazioni**: CSS transitions (hardware accelerated)

### Sicurezza

- ✅ Nonce verification su ogni AJAX request
- ✅ Sanitization di tutti gli input utente
- ✅ Prepared statements per query database
- ✅ Escape output HTML

---

## 💡 Esempi d'Uso

### Scenario 1: Utente cerca razza da appartamento

1. Muove slider "Adatto ad Appartamento" a 4
2. Il JavaScript invia AJAX con `apartment: 4`
3. Backend filtra razze con `adattabilita_appartamento >= 4`
4. Mostra solo razze adatte (es: Bulldog Francese, Carlino)

### Scenario 2: Famiglia cerca cane per bambini

1. Spunta "Media"
2. Slider "Compatibile con Bambini" a 4
3. Slider "Esperienza" a basso (principiante)
4. Backend restituisce: Golden Retriever, Labrador, Beagle

### Scenario 3: Sportivo cerca compagno attivo

1. Slider "Energia" a 5
2. Ordina per "Più Popolari"
3. Backend restituisce: Border Collie, Australian Shepherd, Husky

---

**Template creato e pronto per l'uso! 🎉**

Per supporto o personalizzazioni, consulta la documentazione WordPress o contatta il team di sviluppo.
