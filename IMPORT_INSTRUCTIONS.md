# Istruzioni per Importare i Campi ACF delle Caratteristiche Razza

## File Creato

`acf-breed-characteristics.json` - Gruppo di campi ACF completo per il sistema di valutazione razze con 18 caratteristiche

## Come Importare

### Passo 1: Accedi alla Dashboard WordPress
Vai su: **Dashboard WordPress → Custom Fields → Tools**

### Passo 2: Importa il File JSON
1. Nella sezione "Import Field Groups", clicca su **"Choose File"**
2. Seleziona il file `acf-breed-characteristics.json`
3. Clicca su **"Import JSON"**

### Passo 3: Verifica l'Importazione
1. Vai su **Custom Fields → Field Groups**
2. Dovresti vedere il gruppo: **"Caratteristiche Razza (Sistema Zampette)"**
3. Il gruppo sarà attivo per il post type **"razze_di_cani"**

## Struttura dei Campi

Il gruppo contiene **18 caratteristiche** organizzate in **5 tab**:

### Tab 1: Temperamento
- Livello Energia
- Affettuosità
- Vocalità / Tendenza ad Abbaiare
- Socievolezza con Altri Cani

### Tab 2: Adattabilità
- Adattabilità Appartamento
- Tolleranza al Caldo
- Tolleranza al Freddo
- Tolleranza alla Solitudine

### Tab 3: Famiglia & Socialità
- Compatibilità con Bambini
- Tolleranza verso Estranei
- Compatibilità Altri Animali

### Tab 4: Addestramento & Cura
- Facilità Addestramento
- Intelligenza / Problem Solving
- Bisogno di Esercizio Fisico
- Facilità Toelettatura
- Perdita Pelo
- Robustezza Salute

### Tab 5: Esperienza & Altri
- Livello Esperienza Richiesto
- Costo Mantenimento
- Istinti di Caccia

## Tipo di Campo

Tutti i campi sono di tipo **Range Slider** con:
- **Min**: 1
- **Max**: 5
- **Step**: 0.5 (permette valori come 2.5, 3.5, ecc.)
- **Default**: 3

## Compatibilità con Dati Esistenti

I nomi dei campi sono stati mantenuti identici ai campi radio esistenti, quindi:
- ✅ I dati esistenti (valori 1-5) saranno automaticamente compatibili
- ✅ Non è necessaria migrazione manuale dei dati
- ✅ I valori radio (1, 2, 3, 4, 5) funzioneranno con i nuovi slider

## Visualizzazione Frontend

Il sistema di visualizzazione con **zampette 🐾** è già implementato in:
- Template: `single-razze_di_cani.php`
- Funzioni: `wp-content/themes/theme-caniincasa/inc/template-functions.php`
- CSS: `wp-content/themes/theme-caniincasa/css/components/breed-characteristics.css`

Le zampette si visualizzeranno automaticamente una volta importati i campi.

## Rimozione Vecchi Campi (Opzionale)

Dopo aver verificato che il nuovo sistema funziona correttamente:

1. Vai su **Custom Fields → Field Groups**
2. Trova i vecchi gruppi di campi con i campi radio
3. Puoi disattivarli o eliminarli (i dati rimarranno nel database)

⚠️ **IMPORTANTE**: Fai un backup del database prima di eliminare i vecchi field groups!

## Test

Dopo l'importazione:

1. Modifica una razza esistente
2. Verifica che i tab siano visibili nell'editor
3. Salva la razza
4. Visualizza la pagina frontend
5. Controlla che le zampette siano visualizzate correttamente

## Supporto

Se hai problemi con l'importazione:
- Verifica di avere **ACF PRO** installato e attivo
- Controlla la versione di ACF (consigliata: 6.0+)
- Verifica i permessi di scrittura del database
