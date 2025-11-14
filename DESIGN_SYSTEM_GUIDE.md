# 🎨 Design System Guide - CaninCasa.it

Guida completa al nuovo design system unificato del tema CaninCasa.

**Versione**: 2.0
**Data**: 14 Novembre 2025
**Autore**: Claude AI

---

## 📊 Modifiche Apportate

### 1. CSS Variables Aggiunte

Aggiunte nuove variabili CSS per garantire consistenza:

```css
/* Text Colors - Aggiunte */
--text-primary: #2C3E50;
--text-secondary: #7F8C8D;

/* Background - Alias aggiunto */
--background-light: #F8F9FA;

/* Border Colors - Nuove */
--border-color: #E1E8ED;
--border-light: #F0F3F5;
--border-dark: #CBD5E0;
```

**File**: `style.css` (righe 48-64)

---

## 🧩 Componenti Condivisi

### Nuovo File: `css/components/shared.css`

Creato un nuovo file CSS centralizzato per tutti i componenti condivisi tra i template.

**Registrato in**: `functions.php` (riga 196-201)

#### Componenti Inclusi:

1. ✅ **Breadcrumbs Boxati**
2. ✅ **Archive Header Unificato**
3. ✅ **Page Header Unificato**
4. ✅ **Content Cards**
5. ✅ **Filter Sidebar**
6. ✅ **No Results Message**
7. ✅ **Design Responsive Mobile**

---

## 🍞 Breadcrumbs - Stile Boxato

### Come Funziona

I breadcrumbs ora hanno automaticamente uno stile boxato professionale.

**Funzione Aggiornata**: `caniincasa_breadcrumbs()`
**File**: `inc/template-functions.php` (righe 57-128)

### Struttura HTML

```html
<nav class="breadcrumbs">
    <div class="breadcrumbs-container">  <!-- Nuovo wrapper boxato -->
        <ol class="breadcrumb-list">
            <li class="breadcrumb-item">...</li>
        </ol>
    </div>
</nav>
```

### CSS Applicato

```css
.breadcrumbs-container {
    background: var(--bg-light);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-sm);
    padding: var(--spacing-md) var(--spacing-lg);
    margin-bottom: var(--spacing-2xl);
}
```

### Responsive

- **Desktop**: Mostra tutti i breadcrumbs
- **Tablet (< 768px)**: Font size ridotto
- **Mobile (< 480px)**: Mostra solo Home, [...], Current page

---

## 📰 Archive Header - Stile Unificato

### Nuove Funzioni Helper

#### `caniincasa_archive_header( $title, $description, $stats )`

Crea un header unificato con gradiente e pattern di background.

**File**: `inc/template-functions.php` (righe 454-492)

### Parametri

| Parametro | Tipo | Descrizione |
|-----------|------|-------------|
| `$title` | string | Titolo dell'archive (default: auto) |
| `$description` | string | Descrizione testuale |
| `$stats` | array | Array di statistiche da mostrare |

### Esempio d'Uso

```php
<?php
// In un template archive
global $wp_query;

$stats = array(
    array(
        'icon' => '🐕',
        'label' => 'razze',
        'value' => $wp_query->found_posts
    ),
    array(
        'icon' => '📍',
        'label' => 'province',
        'value' => 20
    )
);

caniincasa_archive_header(
    __( 'Razze di Cani', 'caniincasa' ),
    __( 'Scopri tutte le razze canine con schede complete', 'caniincasa' ),
    $stats
);
?>
```

### Design

- ✅ Gradiente primario (FF6B35 → E85A28)
- ✅ Pattern decorativo di background
- ✅ Text shadow per leggibilità
- ✅ Completamente responsive
- ✅ Statistiche opzionali con icone

---

## 📄 Page Header - Single Pages

### Funzione Helper

#### `caniincasa_page_header( $title, $meta )`

Header per pagine single con meta informazioni.

### Parametri

| Parametro | Tipo | Descrizione |
|-----------|------|-------------|
| `$title` | string | Titolo pagina (default: auto) |
| `$meta` | array | Array di meta items |

### Esempio d'Uso

```php
<?php
// In un template single
$meta = array(
    array(
        'icon' => '📍',
        'label' => get_post_meta( get_the_ID(), 'provincia_', true )
    ),
    array(
        'icon' => '🏠',
        'label' => get_post_meta( get_the_ID(), 'nome_affisso', true )
    )
);

caniincasa_page_header(
    get_the_title(),
    $meta
);
?>
```

### Design

- ✅ Background chiaro (bg-lighter)
- ✅ Bordo sottile
- ✅ Border radius lg
- ✅ Meta items con icone
- ✅ Layout flessibile responsive

---

## 🃏 Content Cards - Stile Unificato

### Classe: `.content-card`

Cards unificata per tutti i tipi di contenuto.

### Struttura HTML

```html
<div class="content-card">
    <img src="..." alt="..." class="content-card-image">
    <div class="content-card-body">
        <h3 class="content-card-title">
            <a href="...">Titolo</a>
        </h3>
        <div class="content-card-excerpt">
            Lorem ipsum...
        </div>
        <div class="content-card-meta">
            <span>Info 1</span>
            <span>Info 2</span>
        </div>
    </div>
    <div class="content-card-footer">
        <a href="..." class="btn">Scopri di più</a>
    </div>
</div>
```

### Caratteristiche

- ✅ Hover effect (lift + shadow)
- ✅ Aspect ratio ottimizzato (220px height)
- ✅ Badge colorato opzionale
- ✅ Footer con background differenziato
- ✅ Responsive design

### Varianti

```css
.content-card-badge       /* Badge colorato in alto */
.content-card-footer      /* Footer con azioni */
.content-card-meta        /* Meta informazioni */
```

---

## 🔍 Filter Sidebar - Stile Unificato

### Classe: `.archive-filters`

Sidebar filtri unificata con sticky behavior.

### Caratteristiche

- ✅ Background bianco con bordo
- ✅ Shadow leggera
- ✅ Sticky positioning (top: 80px + 2rem)
- ✅ Title con bordo inferiore primario
- ✅ Form controls stilizzati
- ✅ Checkbox groups ottimizzati

### Form Controls

```css
.filter-group .form-control       /* Input e select standardizzati */
.checkbox-group                   /* Gruppo checkbox verticale */
.checkbox-label                   /* Label con hover effect */
```

### Focus State

Gli input hanno un focus state con primary color e shadow:

```css
.form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
}
```

---

## 📱 Responsive Design

### Breakpoints

| Device | Breakpoint | Modifiche |
|--------|------------|-----------|
| Desktop | > 768px | Full layout |
| Tablet | ≤ 768px | Ridotti padding, font size ridotto |
| Mobile | ≤ 480px | Breadcrumbs ridotti, cards verticali |

### Mobile Optimizations

```css
@media (max-width: 768px) {
    /* Breadcrumbs più compatti */
    .breadcrumbs-container {
        padding: var(--spacing-sm) var(--spacing-md);
    }

    /* Archive header ridotto */
    .archive-title {
        font-size: var(--text-2xl);
    }

    /* Stats verticali */
    .archive-stats {
        flex-direction: column;
    }

    /* Filters non sticky */
    .filters-sticky {
        position: static;
    }
}

@media (max-width: 480px) {
    /* Breadcrumbs ultra-compatti */
    .breadcrumb-item:not(:last-child):not(:nth-last-child(2)) {
        display: none; /* Mostra solo Home ... Current */
    }
}
```

---

## 🚀 Migrazione Template Esistenti

### Passo 1: Archive Templates

Sostituisci il vecchio header con:

```php
<?php
// PRIMA
?>
<header class="archive-header">
    <h1 class="archive-title">Titolo</h1>
    <p class="archive-description">Descrizione</p>
</header>

<?php
// DOPO
global $wp_query;
$stats = array(
    array(
        'icon' => '🐕',
        'label' => 'risultati',
        'value' => $wp_query->found_posts
    )
);
caniincasa_archive_header(
    __( 'Titolo', 'caniincasa' ),
    __( 'Descrizione', 'caniincasa' ),
    $stats
);
?>
```

### Passo 2: Single Templates

Sostituisci header semplici con:

```php
<?php
// DOPO
$meta = array(
    array(
        'icon' => '📍',
        'label' => 'Localit\à'
    )
);
caniincasa_page_header( '', $meta );
?>
```

### Passo 3: Cards nei Loop

Usa la classe `.content-card` per tutte le card:

```php
<div class="grid grid-3">
    <?php while ( have_posts() ) : the_post(); ?>
        <div class="content-card">
            <!-- Contenuto card -->
        </div>
    <?php endwhile; ?>
</div>
```

---

## 📋 Checklist Applicazione Design System

### Per Ogni Template Archive

- [ ] Breadcrumbs presente: `caniincasa_breadcrumbs()`
- [ ] Header con funzione helper: `caniincasa_archive_header()`
- [ ] Stats opzionali aggiunte
- [ ] Cards usano classe `.content-card`
- [ ] Filter sidebar usa classe `.archive-filters`

### Per Ogni Template Single

- [ ] Breadcrumbs presente
- [ ] Header usa `caniincasa_page_header()` con meta
- [ ] Layout responsive testato
- [ ] Immagini con lazy loading

### CSS

- [ ] `shared.css` incluso nel tema
- [ ] Nessuna variabile CSS mancante
- [ ] Tutte le classi standardizzate

---

## 🎯 Template Già Aggiornati

### ✅ Completati

- `archive-allevamenti.php` - **ESEMPIO COMPLETO**

### 📝 Da Aggiornare

- `archive-razze_di_cani.php`
- `archive-annunci_cucciolate.php`
- `archive-annunci_dogsitter.php`
- `archive-canili.php`
- `archive-centri_cinofili.php`
- `archive-faq.php`
- `archive-patologie_canine.php`
- `archive-pensioni_per_cani.php`
- `archive-struttureveterinarie.php`

### Single Templates

- Tutti i template `single-*.php` possono beneficiare di `caniincasa_page_header()`

---

## 🔧 Troubleshooting

### Breadcrumbs non hanno il box

**Soluzione**: Verifica che `shared.css` sia caricato:

```php
// In functions.php deve esserci:
wp_enqueue_style( 'caniincasa-shared', ... );
```

### Variabili CSS non funzionano

**Soluzione**: Verifica che le variabili siano definite in `style.css` alle righe 34-117.

### Header archive senza gradiente

**Soluzione**: Verifica che stai usando `caniincasa_archive_header()` e non il vecchio HTML.

---

## 📚 Risorse

- **File CSS Principale**: `css/components/shared.css`
- **Funzioni Helper**: `inc/template-functions.php` (righe 454+)
- **Variabili CSS**: `style.css` (righe 34-117)
- **Esempio Template**: `archive-allevamenti.php`

---

## 🎨 Palette Colori

### Primari

- **Primary**: `#FF6B35` (Arancione vibrante)
- **Primary Dark**: `#E85A28`
- **Primary Light**: `#FF8459`

### Secondari

- **Secondary**: `#004E89` (Blu scuro)
- **Accent**: `#F7B801` (Giallo oro)

### Grigi

- **Text Primary**: `#2C3E50`
- **Text Secondary**: `#7F8C8D`
- **Border**: `#E1E8ED`
- **Background Light**: `#F8F9FA`

---

## ✨ Best Practices

1. **Usa sempre le variabili CSS** invece di valori hardcoded
2. **Applica le funzioni helper** per consistenza
3. **Testa su mobile** prima di committare
4. **Mantieni la struttura HTML** come da esempi
5. **Aggiungi stats negli archive** quando possibile

---

**Fine Guida** 🐕

Per domande o supporto, consulta il codice di esempio in `archive-allevamenti.php`.
