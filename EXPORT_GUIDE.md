# 📦 CaninCasa.it - Guida Esportazione Progetto

## 📋 Informazioni Progetto

**Nome Progetto**: CaninCasa.it - WordPress Rebuild
**Versione**: 2.0
**Data Ultimo Update**: 13 Novembre 2025
**Status**: ✅ Development Complete

---

## 🎯 Checklist Pre-Esportazione

### ✅ File da Includere
- [x] `wp-content/themes/theme-caniincasa/` - **Tema custom completo**
- [x] `.gitignore` - Configurazione Git
- [x] `README.md` - Documentazione principale
- [x] `docs/INSTALLATION.md` - Guida installazione
- [x] `docs/PROJECT_STATUS.md` - Stato progetto

### ⚠️ File da Escludere (già in .gitignore)
- [ ] `wp-admin/` - WordPress core
- [ ] `wp-includes/` - WordPress core
- [ ] `wp-content/uploads/` - Media (opzionale)
- [ ] `wp-content/plugins/` - Plugin (installabili dopo)
- [ ] `wp-config.php` - Configurazione locale
- [ ] `.htaccess` - Server config locale
- [ ] Database dumps con dati sensibili

---

## 📊 Inventario Completo File Tema

### 📁 Struttura Tema (35+ file)

```
theme-caniincasa/
├── functions.php                    # 240 righe - Core functions
├── style.css                        # Theme header + base styles
├── header.php                       # Header template
├── footer.php                       # Footer template
├── front-page.php                   # Homepage
├── page.php                         # Default page
├── single.php                       # Blog single
├── archive.php                      # Blog archive
├── search.php                       # Search results
├── 404.php                          # Error page
├── sidebar.php                      # Sidebar
├── comments.php                     # Comment system
├── searchform.php                   # Search form
│
├── single-razze_di_cani.php         # Single razza
├── single-allevamenti.php
├── single-struttureveterinarie.php
├── single-patologie_canine.php
├── single-faq.php
├── single-annunci_dogsitter.php
├── single-annunci_cucciolate.php
├── single-canili.php
├── single-centri_cinofili.php
├── single-pensioni_per_cani.php
│
├── archive-razze_di_cani.php        # Archive con filtri
├── archive-allevamenti.php
├── archive-struttureveterinarie.php
├── archive-patologie_canine.php
├── archive-faq.php
├── archive-annunci_dogsitter.php
├── archive-annunci_cucciolate.php
├── archive-canili.php
├── archive-centri_cinofili.php
├── archive-pensioni_per_cani.php
│
├── page-templates/
│   ├── full-width.php               # Full width layout
│   ├── contatti.php                 # Contact page
│   └── chi-siamo.php                # About page
│
├── template-parts/
│   └── content-razza-card.php       # Reusable card
│
├── inc/
│   ├── custom-post-types.php        # 600+ righe - 11 CPT
│   ├── taxonomies.php               # 350+ righe - 5 taxonomies
│   ├── custom-fields.php            # ACF setup (placeholder)
│   ├── template-functions.php       # 450+ righe - Helper functions
│   ├── ajax-handlers.php            # 400+ righe - AJAX endpoints
│   ├── enqueue-scripts.php          # 150+ righe - Assets loading
│   └── customizer.php               # 500+ righe - Theme Customizer
│
├── css/
│   ├── main.css                     # 800+ righe - Core styles
│   └── components/
│       ├── cards.css                # 600+ righe - Card components
│       ├── forms.css                # 500+ righe - Form styles
│       ├── rating.css               # 300+ righe - Rating system
│       ├── homepage.css             # 400+ righe - Homepage
│       ├── blog.css                 # 1,500+ righe - Blog/Archives
│       └── pages.css                # 400+ righe - Page templates
│
├── js/
│   ├── main.js                      # 300+ righe - Core JS
│   ├── search-filter.js             # 200+ righe - Filter system
│   ├── rating-display.js            # 150+ righe - Rating display
│   └── customizer.js                # 200+ righe - Live preview
│
├── docs/
│   ├── INSTALLATION.md              # 500+ righe - Setup guide
│   └── PROJECT_STATUS.md            # Project status
│
└── screenshot.png                   # Theme screenshot (da creare)
```

---

## 📈 Statistiche Progetto

### Codice
- **Totale File**: 50+
- **Righe PHP**: ~4,500
- **Righe CSS**: ~8,500
- **Righe JavaScript**: ~850
- **Righe Documentazione**: ~1,000

### Funzionalità
- **Custom Post Types**: 11
- **Custom Taxonomies**: 5
- **Single Templates**: 11
- **Archive Templates**: 10
- **Page Templates**: 4
- **Component CSS**: 6
- **JavaScript Modules**: 4
- **Customizer Options**: 35+
- **Helper Functions**: 20+

---

## 🔧 Configurazione Post-Esportazione

### 1. Setup WordPress Core

```bash
# Dopo il clone del repository
cd cani-in-casa

# Scarica WordPress IT
wp core download --locale=it_IT

# Oppure manualmente da
# https://it.wordpress.org/download/
```

### 2. Database Setup

```sql
CREATE DATABASE caniincasa
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

### 3. WordPress Installation

```bash
# Via WP-CLI
wp config create \
  --dbname=caniincasa \
  --dbuser=root \
  --dbpass=your_password \
  --locale=it_IT

wp core install \
  --url=https://yourdomain.com \
  --title="CaninCasa.it" \
  --admin_user=admin \
  --admin_email=info@caniincasa.it
```

### 4. Attiva Tema

```bash
wp theme activate theme-caniincasa
```

### 5. Installa Plugin Essenziali

```bash
# ACF PRO (licenza richiesta)
# Carica manualmente da https://www.advancedcustomfields.com

# SEO
wp plugin install wordpress-seo --activate

# Cache
wp plugin install wp-rocket --activate

# Security
wp plugin install wordfence --activate

# Forms
wp plugin install contact-form-7 --activate

# SMTP
wp plugin install wp-mail-smtp --activate
```

### 6. Configura Permalink

```bash
wp rewrite structure '/%postname%/' --hard
wp rewrite flush
```

### 7. Crea Menu

WordPress Admin → Aspetto → Menu
- Crea "Menu Principale" → Assegna a "Primary"
- Crea "Menu Footer" → Assegna a "Footer"

### 8. Configura Widget (Opzionale)

Aspetto → Widget
- Sidebar
- Footer 1, 2, 3

---

## 🎨 Customizer - Valori Default

### Colori
- **Primario**: #FF6B35 (Arancione)
- **Secondario**: #004E89 (Blu scuro)
- **Accent**: #F7B801 (Giallo)

### Tipografia
- **Font Titoli**: System UI
- **Font Testo**: System UI
- **Dimensione Base**: 16px

### Header
- **Sticky**: Abilitato
- **Altezza Logo**: 60px
- **Padding**: 20px

### Hero Homepage
- **Titolo**: "Benvenuto su CaninCasa.it"
- **Sottotitolo**: "Tutto quello che devi sapere sui cani"
- **Pulsante**: "Scopri di più"

### Footer
- **Copyright**: "© 2024 CaninCasa.it - Tutti i diritti riservati"

---

## 📦 Plugin Consigliati (Ordine Installazione)

1. **Advanced Custom Fields PRO** (RICHIESTO)
   - Licenza: Necessaria
   - Versione: 6.0+
   - https://www.advancedcustomfields.com

2. **Yoast SEO** o **Rank Math**
   - SEO optimization
   - Free version sufficiente

3. **WP Rocket** o **LiteSpeed Cache**
   - Performance e caching
   - Configurazione automatica consigliata

4. **Wordfence Security** o **iThemes Security**
   - Firewall e security scan
   - Abilita 2FA per admin

5. **WP Mail SMTP**
   - Email delivery affidabile
   - Configura con SendGrid/Mailgun

6. **Contact Form 7** (Opzionale)
   - Template contatti già predisposto
   - Sostituisci ID form nel template

7. **Redirection** (Opzionale)
   - Solo se servono redirect custom

---

## ⚙️ ACF - Campi Custom da Configurare

### Razze di Cani
- taglia (select): toy, piccola, media, grande, gigante
- altezza_cm (number)
- peso_kg (number)
- aspettativa_vita_anni (number)
- livello_energia (select)
- adatto_famiglie (true/false)
- adatto_bambini (true/false)
- paese_origine (text)

### Allevamenti
- citta (text)
- telefono (text)
- email (email)
- sito_web (url)
- certificato_enci (true/false)
- certificato_fci (true/false)
- cuccioli_disponibili (true/false)

### Strutture Veterinarie
- indirizzo (text)
- citta (text)
- telefono (text)
- email (email)
- pronto_soccorso (true/false)
- orario_apertura (time)
- orario_chiusura (time)

### Patologie Canine
- gravita (select): lieve, moderata, grave, critica
- sintomi_principali (textarea)
- categoria_patologia (text)

### FAQ
- argomento (select)

### Annunci Dogsitter
- citta (text)
- telefono (text)
- email (email)
- tariffa_oraria (number)
- anni_esperienza (number)
- certificato (true/false)
- disponibile_weekend (true/false)

### Annunci Cucciolate
- data_nascita (date)
- numero_cuccioli_disponibili (number)
- prezzo (number)
- pedigree_disponibile (true/false)

### Canili
- indirizzo (text)
- citta (text)
- telefono (text)
- numero_cani_ospitati (number)
- cani_disponibili_adozione (true/false)

### Centri Cinofili
- citta (text)
- telefono (text)
- certificato_enci (true/false)
- lezioni_individuali (true/false)

### Pensioni per Cani
- citta (text)
- tariffa_giornaliera (number)
- capacita_massima (number)
- area_esterna (true/false)

---

## 🔄 Comandi Git per Esportazione

### Sul Repository Originale

```bash
# Assicurati che tutto sia committato
git status
git add .
git commit -m "Final commit before export"
git push origin main
```

### Sul Nuovo Account GitHub

```bash
# Crea nuovo repository su GitHub
# Nome: cani-in-casa

# Clone da repository originale
git clone https://github.com/ORIGINAL_ACCOUNT/cani-in-casa.git
cd cani-in-casa

# Rimuovi remote originale
git remote remove origin

# Aggiungi nuovo remote
git remote add origin https://github.com/NEW_ACCOUNT/cani-in-casa.git

# Push su nuovo repository
git push -u origin main
```

### Alternativa: Direct Fork/Transfer

Su GitHub.com:
1. Vai a repository originale
2. Settings → Transfer Ownership
3. Inserisci nome nuovo account
4. Conferma trasferimento

---

## 🔐 Sicurezza Post-Esportazione

### File Sensibili da Verificare

```bash
# Verifica che questi NON siano nel repository
git ls-files | grep -E '(wp-config\.php|\.htaccess|\.env)'

# Se presenti, rimuovi:
git rm --cached wp-config.php
git commit -m "Remove sensitive files"
```

### .gitignore Verificato ✅

```
# WordPress core
/wp-admin/
/wp-includes/
/wp-*.php (except wp-content)

# Config
wp-config.php
.htaccess
.env

# Media (opzionale)
/wp-content/uploads/

# Plugin
/wp-content/plugins/

# Cache & Logs
*.log
/.cache/
```

---

## 📝 Checklist Post-Installazione

### Configurazione WordPress
- [ ] Permalink impostati su `/%postname%/`
- [ ] Timezone impostato (Europe/Rome)
- [ ] Lingua italiana attiva
- [ ] Commenti configurati
- [ ] Media settings configurati

### Tema
- [ ] Logo caricato (Aspetto → Personalizza → Identità Sito)
- [ ] Customizer configurato con colori brand
- [ ] Menu creati e assegnati
- [ ] Widget footer configurati (opzionale)

### Plugin
- [ ] ACF PRO attivo
- [ ] Campi custom configurati
- [ ] SEO plugin configurato
- [ ] Cache plugin attivo
- [ ] Security plugin configurato
- [ ] SMTP configurato e testato

### Contenuto
- [ ] Pagina "Chi Siamo" creata (Template: Chi Siamo)
- [ ] Pagina "Contatti" creata (Template: Contatti)
- [ ] Menu principale popolato
- [ ] Footer menu configurato

### SEO
- [ ] Sitemap generata
- [ ] Google Search Console configurato
- [ ] Analytics installato
- [ ] Meta tags verificati

### Performance
- [ ] Cache attiva
- [ ] Lazy loading abilitato
- [ ] Immagini ottimizzate
- [ ] PageSpeed test eseguito (target 90+)

### Security
- [ ] SSL/HTTPS attivo
- [ ] Firewall configurato
- [ ] Backup automatici attivi
- [ ] 2FA abilitato per admin
- [ ] File permissions verificati (644/755)

---

## 🚀 Ottimizzazioni Raccomandate

### Performance
```bash
# Abilita compressione GZIP
# Nel .htaccess

# Abilita browser caching
# Via plugin o .htaccess

# Minify CSS/JS
# Via plugin cache (WP Rocket, ecc.)
```

### Database
```bash
# Ottimizza tabelle
wp db optimize

# Cleanup
wp transient delete --all
wp cache flush
```

### Immagini
- Usa plugin come Imagify o ShortPixel
- Formato WebP per immagini moderne
- Lazy loading nativo WordPress

---

## 📞 Supporto

### Documentazione
- README.md - Panoramica progetto
- docs/INSTALLATION.md - Setup dettagliato
- docs/PROJECT_STATUS.md - Stato funzionalità

### Contatti
- **Email**: info@caniincasa.it
- **Developer**: Claude AI Assistant
- **PM**: Max - Creattivo Communication

---

## 📄 License

**Proprietario** - Tutti i diritti riservati
© 2024-2025 CaninCasa.it

---

## ✅ Riepilogo Finale

**Cosa Include l'Esportazione:**
✅ Theme custom completo (50+ file)
✅ Documentazione completa
✅ CSS strutturato con design system
✅ JavaScript modulare
✅ Template per tutti i CPT
✅ Page templates pronti
✅ Theme Customizer completo
✅ Guide installazione

**Cosa NON Include:**
❌ WordPress Core (da scaricare)
❌ Plugin (da installare)
❌ Database e contenuti
❌ File di configurazione locali
❌ Media uploads

**Tempo Stimato Setup Completo:** 2-4 ore

---

**Pronto per l'esportazione! 🚀**

Data: 13 Novembre 2025
Versione Documento: 1.0
