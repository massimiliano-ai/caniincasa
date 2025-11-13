# CaninCasa.it - WordPress Rebuild

🐾 **La Guida Completa per Vivere con il Tuo Migliore Amico a Quattro Zampe!**

## 📋 Descrizione Progetto

Ricreazione completa del sito www.caniincasa.it su WordPress, eliminando WPBakery Page Builder e riducendo drasticamente i plugin utilizzati, mantenendo il 100% delle URL esistenti per preservare la SEO.

## 🎯 Obiettivi Principali

- ✅ **Preservazione SEO**: Mantenere tutte le URL esistenti identiche
- ⚡ **Performance**: Sito veloce, sotto 2 secondi di caricamento
- 🎯 **Snellezza**: Massimo 5-7 plugin essenziali
- 🔄 **Automazione futura**: Struttura pronta per integrazione n8n
- 📱 **Responsive**: Design mobile-first
- ♿ **Accessibilità**: WCAG 2.1 AA compliant
- 🎨 **Personalizzabile**: Theme Customizer completo

## 📊 Stato Progetto

**Versione**: 2.0
**Data Creazione**: 08 Novembre 2025
**Ultimo Aggiornamento**: 13 Novembre 2025
**Status**: ✅ Development Complete

### Statistiche

- **📄 File Template**: 35+
- **💅 Righe CSS**: 8,500+
- **⚙️ Righe PHP**: 4,500+
- **🎨 Componenti CSS**: 6
- **📦 Custom Post Types**: 11
- **🏷️ Taxonomies**: 5
- **🎛️ Customizer Options**: 35+

## 🛠️ Stack Tecnologico

- **CMS**: WordPress 6.4+
- **Theme**: Custom theme leggero "theme-caniincasa"
- **PHP**: 8.1+
- **Database**: MySQL 8.0+
- **Editor**: Gutenberg nativo
- **Custom Fields**: Advanced Custom Fields (ACF) PRO
- **CSS**: Custom CSS con CSS Variables
- **JavaScript**: jQuery + Vanilla JS

## 📁 Struttura Progetto

```
cani-in-casa/
├── wp-content/
│   └── themes/
│       └── theme-caniincasa/         # Theme custom (tracked)
│           ├── functions.php         # Core functions
│           ├── style.css             # Main stylesheet
│           ├── header.php
│           ├── footer.php
│           ├── front-page.php        # Homepage
│           ├── page.php              # Default page template
│           ├── single.php            # Blog single
│           ├── archive.php           # Blog archive
│           ├── search.php
│           ├── 404.php
│           ├── comments.php
│           ├── searchform.php
│           │
│           ├── inc/                  # PHP includes
│           │   ├── custom-post-types.php   # 11 CPT
│           │   ├── taxonomies.php          # 5 taxonomies
│           │   ├── custom-fields.php       # ACF setup
│           │   ├── template-functions.php  # Helper functions
│           │   ├── ajax-handlers.php       # AJAX endpoints
│           │   ├── enqueue-scripts.php     # Assets loading
│           │   └── customizer.php          # Theme Customizer
│           │
│           ├── page-templates/       # Custom page templates
│           │   ├── full-width.php
│           │   ├── contatti.php
│           │   └── chi-siamo.php
│           │
│           ├── template-parts/       # Reusable parts
│           │   └── content-razza-card.php
│           │
│           ├── css/
│           │   ├── main.css          # Core styles
│           │   └── components/
│           │       ├── cards.css     # Card components
│           │       ├── forms.css     # Form styles
│           │       ├── rating.css    # Rating system
│           │       ├── homepage.css  # Homepage sections
│           │       ├── blog.css      # Blog & archives
│           │       └── pages.css     # Page templates
│           │
│           ├── js/
│           │   ├── main.js           # Core JavaScript
│           │   ├── search-filter.js  # Filter functionality
│           │   ├── rating-display.js # Rating system
│           │   └── customizer.js     # Live preview
│           │
│           └── docs/
│               ├── INSTALLATION.md
│               └── PROJECT_STATUS.md
│
├── .gitignore
└── README.md
```

## 🏗️ Custom Post Types (11)

| CPT | URL Pattern | Descrizione |
|-----|-------------|-------------|
| **razze_di_cani** | `/razze_di_cani/{slug}/` | Database razze canine |
| **allevamenti** | `/allevamenti/{slug}/` | Allevamenti certificati |
| **struttureveterinarie** | `/struttureveterinarie/{slug}/` | Veterinari e cliniche |
| **patologie_canine** | `/patologie_canine/{slug}/` | Malattie e patologie |
| **faq** | `/faq/{slug}/` | Domande frequenti |
| **annunci_dogsitter** | `/annunci_dogsitter/{slug}/` | Dog sitter disponibili |
| **annunci_cucciolate** | `/annunci_cucciolate/{slug}/` | Annunci cucciolate |
| **canili** | `/canili/{slug}/` | Canili e rifugi |
| **centri_cinofili** | `/centri_cinofili/{slug}/` | Centri addestramento |
| **pensioni_per_cani** | `/pensioni_per_cani/{slug}/` | Pensioni per cani |
| **colore** | `/colore/{slug}/` | Colori mantello |

## 🏷️ Custom Taxonomies (5)

1. **razze_allevamenti** - Collega allevamenti e razze
2. **tipologia_di_cani** - Classificazione razze
3. **categoria_faq** - Categorie FAQ
4. **servizi_veterinari** - Servizi cliniche
5. **provincia** - Localizzazione geografica (108 province italiane)

## 📄 Template Files

### Single Templates (CPT)
- `single-razze_di_cani.php`
- `single-allevamenti.php`
- `single-struttureveterinarie.php`
- `single-patologie_canine.php`
- `single-faq.php`
- `single-annunci_dogsitter.php`
- `single-annunci_cucciolate.php`
- `single-canili.php`
- `single-centri_cinofili.php`
- `single-pensioni_per_cani.php`

### Archive Templates (CPT)
- `archive-razze_di_cani.php` - Con filtri taglia, energia, adattabilità
- `archive-allevamenti.php` - Con filtri provincia, razza, certificazioni
- `archive-struttureveterinarie.php` - Con filtri servizi, orari
- `archive-patologie_canine.php` - Con filtri gravità, categoria
- `archive-faq.php` - Con filtri categoria, argomento
- `archive-annunci_dogsitter.php` - Con filtri zona, disponibilità, tariffe
- `archive-annunci_cucciolate.php` - Con filtri razza, prezzo, disponibilità
- `archive-canili.php` - Con filtri provincia, servizi
- `archive-centri_cinofili.php` - Con filtri corsi, certificazioni
- `archive-pensioni_per_cani.php` - Con filtri servizi, prezzi

### Page Templates
- `page.php` - Default page template
- `page-templates/full-width.php` - Full width layout
- `page-templates/contatti.php` - Contact page con form
- `page-templates/chi-siamo.php` - About page con stats

### Blog Templates
- `single.php` - Single post con author bio, related posts
- `archive.php` - Blog archive
- `search.php` - Search results
- `404.php` - Error page

### Utility Templates
- `front-page.php` - Homepage personalizzabile
- `comments.php` - Comment system
- `searchform.php` - Search form

## 🎨 Theme Customizer

Il tema include un sistema completo di personalizzazione accessibile da **Aspetto > Personalizza**:

### Sezioni Customizer (8)

1. **Colori Tema**
   - Colore Primario (default: #FF6B35)
   - Colore Secondario (#004E89)
   - Colore Accent (#F7B801)
   - Colore Testo, Sfondo, Link

2. **Tipografia**
   - Font Titoli (Google Fonts integrati)
   - Font Testo (Google Fonts integrati)
   - Dimensione Font Base (12-24px)
   - Fonts: Roboto, Open Sans, Lato, Montserrat, Poppins, ecc.

3. **Header**
   - Header Sticky on/off
   - Colore Sfondo/Testo
   - Altezza Logo (30-150px)
   - Padding (10-50px)

4. **Hero Homepage**
   - Immagine Sfondo (upload)
   - Colore Overlay + Opacità
   - Titolo, Sottotitolo
   - Testo Pulsante + URL

5. **Sezioni Homepage**
   - Titoli sezioni Features/Blog
   - Colore Sfondo CTA

6. **Footer**
   - Colori Sfondo/Testo
   - Testo Copyright (HTML supportato)

7. **Layout**
   - Larghezza Container (960-1920px)
   - Border Radius globale (0-30px)

8. **Pagine Archivio**
   - Immagine Header (upload)
   - Colore Overlay

**Caratteristiche:**
- ✅ Live Preview in tempo reale
- ✅ Google Fonts auto-loading
- ✅ CSS dinamico
- ✅ Tutti i valori sanitizzati

## 💅 CSS Architecture

### CSS Variables (Design System)
```css
:root {
  --primary: #FF6B35;
  --secondary: #004E89;
  --accent: #F7B801;
  --spacing-sm: 0.5rem;
  --spacing-md: 1rem;
  --spacing-lg: 2rem;
  --radius-md: 8px;
  /* ... 40+ variabili */
}
```

### Component Files
- **main.css** (800+ righe) - Header, footer, navigation, grids
- **cards.css** (600+ righe) - Card components per tutti i CPT
- **forms.css** (500+ righe) - Form controls, validazione
- **rating.css** (300+ righe) - Sistema rating con stelle
- **homepage.css** (400+ righe) - Hero, features, blog sections
- **blog.css** (1,500+ righe) - Blog, archive, search, 404
- **pages.css** (400+ righe) - Page templates

## ⚡ Performance Features

- Lazy loading immagini
- Async/defer JavaScript
- CSS minification ready
- Preload critical assets
- Conditional script loading
- Database query optimization
- Fragment caching ready

## 🔐 Security Features

- Input sanitization
- Output escaping
- Nonce verification
- Prepared statements
- CSRF protection
- XSS prevention
- SQL injection prevention

## 🌐 SEO Features

- Schema.org markup
- Open Graph tags
- Twitter Cards
- Breadcrumbs
- Sitemap ready
- Meta tags ottimizzati
- URL structure preservata

## ♿ Accessibility

- ARIA labels
- Semantic HTML5
- Keyboard navigation
- Screen reader friendly
- Color contrast AA
- Focus indicators
- Skip links

## 🔌 Plugin Essenziali (Max 7)

1. **Advanced Custom Fields PRO** - Custom fields
2. **Yoast SEO / Rank Math** - SEO optimization
3. **WP Rocket / LiteSpeed Cache** - Caching
4. **Wordfence / iThemes Security** - Security
5. **WP Mail SMTP** - Email delivery
6. **Contact Form 7** - Forms (opzionale)
7. **Redirection** - Redirect management (opzionale)

## 🚀 Installazione

### Requisiti
- PHP 8.1+
- MySQL 8.0+
- WordPress 6.4+
- Apache/Nginx con mod_rewrite
- 256MB RAM minimo

### Quick Start

```bash
# 1. Clona repository
git clone <repository-url> cani-in-casa
cd cani-in-casa

# 2. Scarica WordPress Core
wp core download --locale=it_IT

# 3. Configura WordPress
wp config create --dbname=caniincasa --dbuser=root --dbpass=password
wp core install --url=http://localhost --title="CaninCasa" --admin_user=admin

# 4. Attiva theme
wp theme activate theme-caniincasa

# 5. Installa plugin
wp plugin install advanced-custom-fields-pro --activate
wp plugin install wordpress-seo --activate
```

### Setup Manuale

Vedi [docs/INSTALLATION.md](docs/INSTALLATION.md) per istruzioni dettagliate.

## 📚 Documentazione

- [📖 Installation Guide](docs/INSTALLATION.md) - Setup completo
- [📊 Project Status](docs/PROJECT_STATUS.md) - Stato sviluppo
- [🎨 Customizer Guide](docs/CUSTOMIZER.md) - Uso personalizzazione

## 🧪 Testing

```bash
# Validazione HTML
npm run validate

# Linting PHP
composer lint

# Linting JavaScript
npm run lint:js

# Linting CSS
npm run lint:css
```

## 🎯 Target Metrics

- **PageSpeed Score**: 90+ (desktop/mobile)
- **First Contentful Paint**: < 1.5s
- **Time to Interactive**: < 3s
- **Cumulative Layout Shift**: < 0.1
- **Total Blocking Time**: < 300ms

## 🔄 Workflow Git

```bash
# Branch principale
main

# Branch sviluppo
claude/caniincasa-wordpress-rebuild-*

# Commit conventions
feat: Nuova funzionalità
fix: Bug fix
docs: Documentazione
style: Formattazione
refactor: Refactoring
perf: Performance
test: Testing
```

## 📦 Deployment

### Staging
```bash
git push staging main
```

### Production
```bash
git push production main
# Esegui deploy script
./deploy.sh production
```

## 🤝 Contribuire

Progetto privato - Per modifiche contattare il team.

## 📧 Contatti

- **Website**: www.caniincasa.it
- **Email**: info@caniincasa.it
- **Developer**: Claude (Anthropic AI)
- **Project Manager**: Max - Creattivo Communication

## 🐕 Importazione Razze di Esempio

Il progetto include file di esempio per importare 3 razze complete con tutti i campi ACF del sistema di valutazione con zampette.

### File Disponibili

📄 **sample-breeds-import.csv** - Formato CSV per WP All Import
📄 **sample-breeds-import.json** - Formato JSON per importazione programmatica
📄 **import-sample-breeds.php** - Script PHP automatico pronto all'uso
📄 **SAMPLE_BREEDS_GUIDE.md** - Guida completa all'importazione

### Razze Incluse

1. **Labrador Retriever** - Cane da famiglia attivo e affettuoso
2. **Chihuahua** - Cane da compagnia per appartamento
3. **Pastore Tedesco** - Cane da lavoro intelligente e protettivo

Ogni razza include:
- ✅ Contenuto completo in HTML (origini, aspetto, carattere, salute, addestramento)
- ✅ Tutti i 18 campi ACF con valutazioni realistiche (1-5)
- ✅ Estratto ottimizzato per SEO
- ✅ Slug pre-configurati

### Metodi di Importazione

1. **WP All Import** - Usa il file CSV (raccomandato per bulk import)
2. **Script PHP** - Carica `import-sample-breeds.php` nella root e visita l'URL
3. **Importazione Manuale** - Copia i dati dal JSON

👉 Per istruzioni dettagliate: [SAMPLE_BREEDS_GUIDE.md](SAMPLE_BREEDS_GUIDE.md)

---

## 📄 License

**Proprietario** - Tutti i diritti riservati
© 2024-2025 CaninCasa.it

---

## 🎉 Features Highlights

✨ **Customizer Completo** - 35+ opzioni personalizzabili
🎨 **Design System** - CSS Variables consistente
📱 **Mobile-First** - Responsive su tutti i device
⚡ **Performance** - Ottimizzazioni integrate
🔍 **SEO Ready** - Schema markup e meta tags
♿ **Accessible** - WCAG 2.1 AA compliant
🎯 **Filter System** - Ricerca avanzata per tutti i CPT
💬 **Review System** - Rating con stelle
📧 **Contact Forms** - Template pronti
🏠 **Page Templates** - Contatti, Chi Siamo, Full Width

**Built with ❤️ and 🐕**
