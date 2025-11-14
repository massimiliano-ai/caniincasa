# 🐕 Guida Archivio Razze con Filtri AJAX

## Panoramica

È stata creata una **nuova pagina archivio razze** moderna con sistema di filtri AJAX che permette agli utenti di trovare facilmente la razza perfetta per loro.

### ✨ Caratteristiche Principali

- ✅ **Filtri AJAX in tempo reale** - Nessun ricaricamento pagina
- ✅ **Ricerca testuale** - Cerca per nome razza
- ✅ **Filtro dimensione** - Piccola, Media, Grande, Gigante
- ✅ **Range sliders** - Per energia, appartamento, bambini, esperienza
- ✅ **Ordinamento dinamico** - A-Z, Z-A, Più popolari
- ✅ **Design responsive** - Perfetto su desktop, tablet e mobile
- ✅ **Caricamento progressivo** - Load more button per prestazioni ottimali
- ✅ **Animazioni fluide** - Card animate all'apparizione

---

## 📁 File Creati

### 1. Template PHP
**`wp-content/themes/theme-caniincasa/archive-razze_di_cani.php`**
- Template principale della pagina archivio
- Struttura HTML con filtri sidebar e griglia risultati
- Passa dati PHP a JavaScript (AJAX URL, nonce)

### 2. Gestore AJAX
**`wp-content/themes/theme-caniincasa/inc/razze-ajax-filters.php`**
- Funzione `caniincasa_filter_razze()` - Gestisce le richieste AJAX
- Filtraggio per ricerca testuale, caratteristiche ACF, dimensione
- Restituisce JSON con razze filtrate
- Supporto paginazione e ordinamento

### 3. JavaScript
**`wp-content/themes/theme-caniincasa/js/razze-filters.js`**
- Gestione interattiva dei filtri
- Chiamate AJAX al backend
- Rendering dinamico delle card razze
- Debounce per ricerca testuale
- Gestione loading states

### 4. CSS
**`wp-content/themes/theme-caniincasa/css/archive-razze.css`**
- Styling completo pagina archivio
- Sidebar filtri sticky
- Griglia responsive breed cards
- Animazioni e transizioni
- Mobile-first design

### 5. Backup del vecchio template
**`archive-razze_di_cani-old.php`**
- Backup del template precedente (se vuoi ripristinarlo)

---

## 🎯 Filtri Disponibili

### 1. Ricerca Testuale
- Input per cercare per nome razza
- Debounce di 500ms per ridurre chiamate AJAX
- Case-insensitive

### 2. Dimensione (Checkbox multipli)
- ☐ Piccola (fino 10kg)
- ☐ Media (10-25kg)
- ☐ Grande (25-45kg)
- ☐ Gigante (oltre 45kg)

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

---

## 🎨 Design & UX

### Card Razza Include:
- **Immagine in evidenza** con hover effect
- **Titolo razza** linkabile
- **Temperamento breve** (se disponibile)
- **Paese di origine** con icona
- **Mini statistiche** con zampette:
  - Livello energia
  - Adattabilità appartamento

### Responsive Behavior:
- **Desktop (>992px)**: Filtri sidebar fissi a sinistra, griglia 3-4 colonne
- **Tablet (768-992px)**: Griglia 2-3 colonne, filtri sidebar
- **Mobile (<768px)**: Griglia 1 colonna, filtri in modal slide-in

### Stati Interfaccia:
- **Loading**: Spinner animato durante caricamento
- **No Results**: Messaggio amichevole con bottone reset
- **Load More**: Button per caricare altre razze (24 per batch)

---

## 🔧 Come Funziona

### Flusso Filtraggio

1. **Utente modifica filtro** (es: spunta "Piccola" o muove slider)
2. **JavaScript** raccoglie tutti i valori filtri attivi
3. **AJAX request** inviata a `admin-ajax.php`
4. **PHP backend** (razze-ajax-filters.php):
   - Costruisce WP_Query con parametri filtri
   - Filtra per meta fields ACF
   - Post-filtra per dimensione se necessario
   - Restituisce JSON con razze matchate
5. **JavaScript** riceve risposta:
   - Svuota griglia se pagina 1
   - Aggiunge card razze con animazione
   - Aggiorna contatore risultati
   - Mostra/nasconde "Load More"

### Sicurezza

- ✅ **Nonce verification** su ogni richiesta AJAX
- ✅ **Sanitization** di tutti gli input utente
- ✅ **Capability checks** (anche per utenti non loggati)
- ✅ **Escape output** nelle card HTML

---

## 📝 Campi ACF Utilizzati

Il sistema si basa sui seguenti campi ACF (già configurati):

```
energia_e_livelli_di_attivita     (type: number, 0-5)
adattabilita_appartamento         (type: number, 0-5)
compatibilita_con_i_bambini       (type: number, 0-5)
livello_esperienza_richiesto      (type: number, 0-5)
temperamento_breve                (type: text)
nazione_origine                   (type: text)
aspetto_fisico                    (type: wysiwyg) - usato per determinare dimensione
```

---

## 🚀 Attivazione

### I file sono già integrati! Devi solo:

1. **Verificare che i file siano sul server**:
   ```bash
   wp-content/themes/theme-caniincasa/
   ├── archive-razze_di_cani.php
   ├── inc/razze-ajax-filters.php
   ├── js/razze-filters.js
   └── css/archive-razze.css
   ```

2. **Svuota la cache** (se usi plugin di caching):
   - WP Rocket, W3 Total Cache, ecc.
   - Svuota cache browser (Ctrl+Shift+R)

3. **Visita la pagina**:
   ```
   https://www.tuosito.it/razze-di-cani/
   ```

4. **Prova i filtri!** 🎉

---

## ⚙️ Personalizzazione

### Modificare numero razze per pagina

In `archive-razze_di_cani.php`, riga dove viene definito:
```javascript
postsPerPage: 24  // Cambia questo numero
```

E in `razze-ajax-filters.php`:
```php
$per_page = 24;  // Cambia questo numero
```

### Aggiungere nuovi filtri

1. Aggiungi HTML filtro in `archive-razze_di_cani.php`
2. Raccogli valore in `collectFilters()` (razze-filters.js)
3. Aggiungi logica filtro in `caniincasa_filter_razze()` (razze-ajax-filters.php)

### Modificare stile card

Modifica `createBreedCard()` in `razze-filters.js` e stili in `archive-razze.css`

---

## 🐛 Troubleshooting

### Filtri non funzionano
- Verifica console browser per errori JavaScript
- Controlla che jQuery sia caricato
- Verifica che `razzeArchive` object sia definito

### Nessun risultato trovato
- Verifica che le razze abbiano i campi ACF compilati
- Controlla che il post type sia `razze_di_cani`
- Verifica che i post siano pubblicati (`post_status=publish`)

### Card senza immagini
- Verifica che le razze abbiano immagine in evidenza
- Placeholder mostrato automaticamente se manca immagine

### Performance lenta
- Riduci `$per_page` a 12 o 16
- Aggiungi caching lato server
- Ottimizza immagini (usa WebP, lazy loading già attivo)

---

## 📱 Test Consigliati

- [ ] Desktop (Chrome, Firefox, Safari)
- [ ] Tablet (iPad, Android tablet)
- [ ] Mobile (iPhone, Android phone)
- [ ] Filtro ricerca testuale
- [ ] Tutti i checkbox dimensione
- [ ] Tutti gli slider range
- [ ] Ordinamento A-Z, Z-A
- [ ] Load more button
- [ ] Reset filtri button
- [ ] Modal filtri su mobile

---

## 🎯 Prossimi Miglioramenti Possibili

1. **URL Parameters**: Salvare filtri in URL per condivisione
2. **Filtri avanzati**: Tipo di pelo, gruppo FCI, livello toelettatura
3. **Comparison**: Confronta 2-3 razze side-by-side
4. **Favorites**: Salva razze preferite (con localStorage o account)
5. **Analytics**: Traccia filtri più usati
6. **Infinite Scroll**: Alternativa a "Load More"

---

## 📚 Risorse

- **Documentazione ACF**: https://www.advancedcustomfields.com/resources/
- **WP_Query Reference**: https://developer.wordpress.org/reference/classes/wp_query/
- **AJAX in WordPress**: https://developer.wordpress.org/plugins/javascript/ajax/

---

**Sviluppato con ❤️ per Cani in Casa**
*Versione 2.0.0 - Archivio Razze con Filtri AJAX*
