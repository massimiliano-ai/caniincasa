# Guida all'Installazione - CaninCasa.it

Guida completa per l'installazione e configurazione del sito WordPress CaninCasa.it.

## 📋 Indice

1. [Requisiti](#requisiti)
2. [Installazione WordPress](#installazione-wordpress)
3. [Configurazione Theme](#configurazione-theme)
4. [Plugin Essenziali](#plugin-essenziali)
5. [Configurazione Custom Fields (ACF)](#configurazione-custom-fields)
6. [Configurazione Iniziale](#configurazione-iniziale)
7. [Verifica Installazione](#verifica-installazione)
8. [Troubleshooting](#troubleshooting)

---

## Requisiti

### Server Requirements

- **PHP**: 8.1 o superiore
- **MySQL**: 8.0 o superiore (o MariaDB 10.5+)
- **Web Server**: Apache 2.4+ o Nginx 1.18+
- **HTTPS**: Certificato SSL valido
- **Spazio Disco**: Minimo 500MB (raccomandato 2GB+)
- **RAM**: Minimo 256MB (raccomandato 512MB+)

### Estensioni PHP Richieste

```
- mysqli
- json
- gd o Imagick
- curl
- mbstring
- xml
- zip
- iconv
```

### Verifica Requisiti

Crea un file `phpinfo.php` nella root del server:

```php
<?php phpinfo(); ?>
```

Accedi a `https://tuosito.it/phpinfo.php` e verifica che tutti i requisiti siano soddisfatti.

**IMPORTANTE**: Elimina il file `phpinfo.php` dopo la verifica per motivi di sicurezza.

---

## Installazione WordPress

### Opzione 1: Installazione Manuale

#### Step 1: Download WordPress

```bash
cd /var/www/html  # o la tua directory web
wget https://it.wordpress.org/latest-it_IT.zip
unzip latest-it_IT.zip
mv wordpress/* .
rm -rf wordpress latest-it_IT.zip
```

#### Step 2: Crea Database

```sql
-- Accedi a MySQL
mysql -u root -p

-- Crea database
CREATE DATABASE caniincasa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Crea utente (sostituisci 'password_sicura' con una password forte)
CREATE USER 'caniincasa_user'@'localhost' IDENTIFIED BY 'password_sicura';

-- Assegna privilegi
GRANT ALL PRIVILEGES ON caniincasa.* TO 'caniincasa_user'@'localhost';
FLUSH PRIVILEGES;

-- Esci
EXIT;
```

#### Step 3: Configura WordPress

```bash
# Copia il file di configurazione esempio
cp wp-config-sample.php wp-config.php

# Edita wp-config.php
nano wp-config.php
```

Modifica le seguenti righe:

```php
define( 'DB_NAME', 'caniincasa' );
define( 'DB_USER', 'caniincasa_user' );
define( 'DB_PASSWORD', 'password_sicura' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', 'utf8mb4_unicode_ci' );
```

Genera le chiavi di sicurezza visitando:
https://api.wordpress.org/secret-key/1.1/salt/

E sostituisci le righe corrispondenti in `wp-config.php`.

#### Step 4: Imposta Permessi

```bash
# Permessi directory
find . -type d -exec chmod 755 {} \;

# Permessi file
find . -type f -exec chmod 644 {} \;

# Permessi wp-config.php
chmod 600 wp-config.php

# Proprietario (sostituisci www-data con il tuo user web server)
chown -R www-data:www-data .
```

#### Step 5: Completa Installazione Web

1. Accedi a `https://www.caniincasa.it/wp-admin/install.php`
2. Compila il form:
   - **Titolo sito**: CaninCasa.it
   - **Username**: [scegli un username sicuro, NON "admin"]
   - **Password**: [genera una password forte]
   - **Email**: info@caniincasa.it
3. Clicca "Installa WordPress"

### Opzione 2: Installazione con WP-CLI

```bash
# Download WordPress
wp core download --locale=it_IT

# Crea wp-config.php
wp config create \
  --dbname=caniincasa \
  --dbuser=caniincasa_user \
  --dbpass=password_sicura \
  --locale=it_IT

# Installa WordPress
wp core install \
  --url=https://www.caniincasa.it \
  --title="CaninCasa.it" \
  --admin_user=admin_user \
  --admin_password=password_forte \
  --admin_email=info@caniincasa.it
```

---

## Configurazione Theme

### Step 1: Clona il Repository

```bash
cd wp-content/themes/
git clone [repository-url] .

# Oppure, se hai già il repository clonato:
# Copia solo la cartella theme-caniincasa in wp-content/themes/
```

### Step 2: Attiva il Theme

#### Via WP Admin:
1. Vai in `Aspetto > Temi`
2. Trova "CaninCasa Theme"
3. Clicca "Attiva"

#### Via WP-CLI:
```bash
wp theme activate theme-caniincasa
```

### Step 3: Verifica Custom Post Types

Dopo l'attivazione, vai in `Impostazioni > Permalink` e clicca "Salva modifiche" per rigenerare i permalink.

Verifica che nel menu admin siano presenti:
- Razze di Cani
- Allevamenti
- Veterinari
- Patologie
- FAQ
- Dogsitter
- Cucciolate
- Canili
- Centri Cinofili
- Pensioni
- Colori Mantello

---

## Plugin Essenziali

### Plugin Obbligatori

#### 1. Advanced Custom Fields PRO

**IMPORTANTE**: ACF PRO è un plugin premium. Devi acquistare una licenza.

```bash
# Upload manuale del file .zip scaricato
# Oppure via WP Admin: Plugin > Aggiungi nuovo > Carica Plugin
```

Attiva il plugin:
```bash
wp plugin activate advanced-custom-fields-pro
```

#### 2. Yoast SEO (o Rank Math)

```bash
wp plugin install wordpress-seo --activate
```

Configurazione base:
1. Vai in `SEO > Generale > Aspetto della ricerca`
2. Imposta template title e description
3. Abilita sitemap XML
4. Configura breadcrumbs

#### 3. WP Rocket (o LiteSpeed Cache)

Plugin premium per caching. Alternative gratuite:
```bash
wp plugin install w3-total-cache --activate
# oppure
wp plugin install litespeed-cache --activate
```

#### 4. Wordfence Security

```bash
wp plugin install wordfence --activate
```

Configurazione:
1. Completa il wizard di configurazione
2. Abilita firewall in "Learning Mode"
3. Imposta scansioni programmate

#### 5. WP Mail SMTP

```bash
wp plugin install wp-mail-smtp --activate
```

Configurazione:
1. Vai in `WP Mail SMTP > Settings`
2. Configura il mailer (Gmail, SendGrid, ecc.)
3. Testa l'invio email

#### 6. Contact Form 7 (o Fluent Forms)

```bash
wp plugin install contact-form-7 --activate
```

### Plugin Opzionali (Consigliati)

```bash
# Gestione redirect
wp plugin install redirection --activate

# Backup automatici
wp plugin install updraftplus --activate

# Ottimizzazione immagini
wp plugin install imagify --activate

# Lazy load immagini (se non già gestito dal tema)
wp plugin install a3-lazy-load --activate
```

---

## Configurazione Custom Fields

### Verifica ACF PRO Attivo

```bash
wp plugin list | grep advanced-custom-fields
```

### Importa Field Groups (Metodo 1: Via Codice)

I field groups sono già configurati nel file `inc/custom-fields.php` del theme.

Dopo aver installato ACF PRO, decommentare il codice in quel file.

### Importa Field Groups (Metodo 2: Via JSON)

1. Crea la directory per il sync ACF:
```bash
mkdir -p wp-content/themes/theme-caniincasa/acf-json
chmod 755 wp-content/themes/theme-caniincasa/acf-json
```

2. Importa i field groups forniti (file JSON separati)

### Configurazione Manuale Field Groups

Se preferisci configurare manualmente, segui questa struttura:

#### Field Group: Razze di Cani - Caratteristiche Fisiche

**Location**: Post Type = razze_di_cani

**Fields**:
- Altezza Minima Maschio (Number, min: 0, max: 200)
- Altezza Massima Maschio (Number, min: 0, max: 200)
- Altezza Minima Femmina (Number, min: 0, max: 200)
- Altezza Massima Femmina (Number, min: 0, max: 200)
- Peso Minimo Maschio (Number, min: 0, max: 100)
- Peso Massimo Maschio (Number, min: 0, max: 100)
- Peso Minimo Femmina (Number, min: 0, max: 100)
- Peso Massimo Femmina (Number, min: 0, max: 100)
- Aspettativa Vita Minima (Number, min: 1, max: 30)
- Aspettativa Vita Massima (Number, min: 1, max: 30)
- Gruppo Razza (Text)
- Paese Origine (Text)

#### Field Group: Razze di Cani - Caratteristiche Caratteriali

**Fields** (tutti Radio Button, valori 1-5):
- Livello di Energia
- Livello di Affettuosità
- Socialità
- Intelligenza
- Facilità di Addestramento
- Necessità di Toelettatura
- Perdita di Pelo
- Tendenza ad Abbaiare
- Compatibilità con i Bambini
- Compatibilità con Altri Animali Domestici
- Esigenze di Esercizio
- Predisposizioni per la Salute
- Tolleranza alla Solitudine
- Adattabilità Clima Freddo
- Adattabilità Clima Caldo
- Istinti di Caccia

#### Field Group: Allevamenti - Informazioni

**Location**: Post Type = allevamenti

**Fields**:
- Persona (Text) - Responsabile
- Localita (Text)
- Provincia (Text - 2 caratteri)
- Email (Email)
- Sito Web (URL)
- Telefono (Text)
- Cellulare (Text)
- Indirizzo (Text)
- CAP (Text)
- ID Affisso (Text)
- Descrizione Affisso (Text)

[Continua con gli altri CPT seguendo il pattern...]

---

## Configurazione Iniziale

### 1. Impostazioni Generali

```bash
# Via WP-CLI
wp option update blogname "CaninCasa.it"
wp option update blogdescription "La Guida Completa per Vivere con il Tuo Migliore Amico a Quattro Zampe"
wp option update timezone_string "Europe/Rome"
wp option update date_format "d/m/Y"
wp option update time_format "H:i"
wp option update start_of_week "1"  # Lunedì
```

### 2. Permalink

```bash
wp rewrite structure '/%postname%/' --hard
wp rewrite flush
```

### 3. Menu

Via WP Admin:
1. Vai in `Aspetto > Menu`
2. Crea menu "Primary Menu"
3. Aggiungi voci:
   - Home
   - Razze (link a /razze_di_cani/)
   - Allevamenti
   - Veterinari
   - Blog
   - Contatti
4. Assegna al tema nella posizione "Primary Menu"

### 4. Widget

Popola le aree widget:
- **Sidebar**: Ricerca, Categorie, Articoli recenti
- **Footer 1**: About
- **Footer 2**: Link utili
- **Footer 3**: Contatti

### 5. Pagine Essenziali

Crea le seguenti pagine:

```bash
wp post create --post_type=page --post_title='Contattaci' --post_status=publish
wp post create --post_type=page --post_title='Chi Siamo' --post_status=publish
wp post create --post_type=page --post_title='Privacy Policy' --post_status=publish
wp post create --post_type=page --post_title='Cookie Policy' --post_status=publish
```

### 6. Homepage Statica

```bash
# Crea homepage
wp post create --post_type=page --post_title='Home' --post_status=publish

# Imposta come homepage
wp option update show_on_front 'page'
wp option update page_on_front [ID-PAGE-HOME]
wp option update page_for_posts [ID-PAGE-BLOG]
```

---

## Verifica Installazione

### Checklist Post-Installazione

- [ ] WordPress installato e funzionante
- [ ] Theme attivato correttamente
- [ ] Tutti i Custom Post Types visibili in admin
- [ ] ACF PRO installato e attivo
- [ ] Field groups configurati per tutti i CPT
- [ ] Plugin essenziali installati e configurati
- [ ] Permalink salvati (struttura: `/%postname%/`)
- [ ] Menu creati e assegnati
- [ ] Homepage configurata
- [ ] SSL attivo (https://)
- [ ] Email funzionanti (test via WP Mail SMTP)

### Test Funzionalità

1. **Test Custom Post Types**:
   - Crea una razza di prova
   - Verifica che i custom fields siano visibili
   - Pubblica e visualizza sul frontend
   - Verifica che l'URL sia corretto

2. **Test Performance**:
   - Esegui test con Google PageSpeed Insights
   - Target: Score > 80

3. **Test Mobile**:
   - Verifica responsive design su vari dispositivi

4. **Test SEO**:
   - Verifica sitemap XML: `/sitemap_index.xml`
   - Verifica meta tags con Yoast SEO

---

## Troubleshooting

### Problema: Custom Post Types non visibili

**Soluzione**:
```bash
# Rigenera permalink
wp rewrite flush --hard

# Verifica che il theme sia attivo
wp theme list
```

### Problema: 404 su tutte le pagine CPT

**Soluzione**:
Vai in `Impostazioni > Permalink` e clicca "Salva modifiche" senza cambiare nulla.

### Problema: Custom fields non visualizzati

**Verifica**:
1. ACF PRO è attivo?
2. Field groups sono assegnati al post type corretto?
3. Prova a disabilitare altri plugin

### Problema: Errori PHP

**Verifica**:
```bash
# Abilita debug
# Aggiungi in wp-config.php:
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

# Controlla log
tail -f wp-content/debug.log
```

### Problema: Sito lento

**Ottimizzazioni**:
1. Abilita caching (WP Rocket o W3 Total Cache)
2. Ottimizza immagini
3. Riduci plugin
4. Verifica query database pesanti
5. Abilita CDN

### Problema: Email non inviate

**Verifica**:
1. WP Mail SMTP configurato correttamente
2. Test invio email da WP Mail SMTP
3. Controlla spam folder
4. Verifica credenziali SMTP

---

## Supporto

Per problemi o domande:
- **Email**: info@caniincasa.it
- **Documentazione**: Consulta README.md
- **WordPress Support**: https://wordpress.org/support/

---

## Prossimi Passi

Dopo l'installazione:
1. ✅ Importa contenuti esistenti (se migrazione)
2. ✅ Configura backup automatici
3. ✅ Imposta monitoraggio uptime
4. ✅ Configura Google Analytics
5. ✅ Configura Google Search Console
6. ✅ Test completo del sito
7. ✅ Go live!

---

**Ultimo aggiornamento**: 09 Novembre 2025
**Versione**: 1.0.0
