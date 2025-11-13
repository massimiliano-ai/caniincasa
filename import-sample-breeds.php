<?php
/**
 * Script di Importazione Razze di Esempio
 *
 * Importa 3 razze campione con tutti i campi ACF compilati
 *
 * ISTRUZIONI:
 * 1. Caricare questo file nella root di WordPress
 * 2. Navigare a: https://tuosito.it/import-sample-breeds.php
 * 3. Lo script importerà le 3 razze dal file JSON
 * 4. ELIMINARE questo file dopo l'uso per sicurezza!
 *
 * @package CaninCasa
 * @version 1.0.0
 */

// Carica WordPress
require_once( 'wp-load.php' );

// Sicurezza: permetti solo agli amministratori
if ( ! current_user_can( 'manage_options' ) ) {
    wp_die( 'Accesso negato. Solo gli amministratori possono eseguire questo script.' );
}

// Verifica ACF
if ( ! function_exists( 'update_field' ) ) {
    wp_die( 'Errore: Advanced Custom Fields PRO non è installato o attivo!' );
}

// Header HTML
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Importazione Razze di Esempio - CaninCasa</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            border-bottom: 3px solid #0073aa;
            padding-bottom: 10px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-left: 4px solid #28a745;
            margin: 10px 0;
            border-radius: 4px;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-left: 4px solid #dc3545;
            margin: 10px 0;
            border-radius: 4px;
        }
        .warning {
            background: #fff3cd;
            color: #856404;
            padding: 15px;
            border-left: 4px solid #ffc107;
            margin: 10px 0;
            border-radius: 4px;
        }
        .info {
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-left: 4px solid #17a2b8;
            margin: 10px 0;
            border-radius: 4px;
        }
        .breed-item {
            padding: 10px;
            margin: 5px 0;
            background: #f8f9fa;
            border-left: 3px solid #0073aa;
        }
        .field-list {
            font-size: 0.9em;
            color: #666;
            margin-left: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #0073aa;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .btn:hover {
            background: #005177;
        }
        pre {
            background: #f4f4f4;
            padding: 10px;
            border-radius: 4px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🐾 Importazione Razze di Esempio</h1>

        <div class="info">
            <strong>Script di Importazione Automatica</strong><br>
            Questo script importerà 3 razze campione nel database:<br>
            • Labrador Retriever<br>
            • Chihuahua<br>
            • Pastore Tedesco
        </div>

<?php

// Percorso del file JSON
$json_path = __DIR__ . '/sample-breeds-import.json';

// Verifica esistenza file
if ( ! file_exists( $json_path ) ) {
    echo '<div class="error"><strong>Errore:</strong> File JSON non trovato in: ' . esc_html( $json_path ) . '</div>';
    echo '<p>Assicurati che il file <code>sample-breeds-import.json</code> sia nella root di WordPress.</p>';
    echo '</div></body></html>';
    exit;
}

// Leggi e decodifica JSON
$json_content = file_get_contents( $json_path );
$breeds = json_decode( $json_content, true );

if ( json_last_error() !== JSON_ERROR_NONE ) {
    echo '<div class="error"><strong>Errore JSON:</strong> ' . json_last_error_msg() . '</div>';
    echo '</div></body></html>';
    exit;
}

echo '<h2>Inizio Importazione...</h2>';

$imported = 0;
$skipped = 0;
$errors = 0;

foreach ( $breeds as $breed ) {

    $breed_title = $breed['post_title'];

    echo '<div class="breed-item">';
    echo '<strong>' . esc_html( $breed_title ) . '</strong><br>';

    // Verifica se esiste già
    $existing = get_page_by_title( $breed_title, OBJECT, 'razze_di_cani' );

    if ( $existing ) {
        echo '<span style="color: #856404;">⚠️ Già esistente (ID: ' . $existing->ID . ') - Saltata</span>';
        echo '</div>';
        $skipped++;
        continue;
    }

    // Prepara i dati del post
    $post_data = array(
        'post_title'   => $breed['post_title'],
        'post_content' => $breed['post_content'],
        'post_excerpt' => $breed['post_excerpt'],
        'post_type'    => $breed['post_type'],
        'post_status'  => $breed['post_status'],
        'post_name'    => isset( $breed['meta']['slug'] ) ? $breed['meta']['slug'] : sanitize_title( $breed['post_title'] ),
    );

    // Inserisci il post
    $post_id = wp_insert_post( $post_data, true );

    if ( is_wp_error( $post_id ) ) {
        echo '<span style="color: #721c24;">❌ Errore: ' . $post_id->get_error_message() . '</span>';
        echo '</div>';
        $errors++;
        continue;
    }

    echo '<span style="color: #155724;">✓ Post creato (ID: ' . $post_id . ')</span><br>';

    // Importa i campi ACF
    if ( isset( $breed['acf'] ) && is_array( $breed['acf'] ) ) {
        $fields_count = 0;
        echo '<div class="field-list">Campi ACF: ';

        foreach ( $breed['acf'] as $field_name => $field_value ) {
            $updated = update_field( $field_name, $field_value, $post_id );
            if ( $updated ) {
                $fields_count++;
            }
        }

        echo $fields_count . '/' . count( $breed['acf'] ) . ' importati</div>';
    }

    echo '</div>';
    $imported++;
}

// Riepilogo
echo '<hr>';
echo '<h2>Riepilogo Importazione</h2>';

if ( $imported > 0 ) {
    echo '<div class="success">';
    echo '<strong>✓ Importazione completata con successo!</strong><br>';
    echo 'Razze importate: ' . $imported . '<br>';
    if ( $skipped > 0 ) {
        echo 'Razze saltate (già esistenti): ' . $skipped . '<br>';
    }
    if ( $errors > 0 ) {
        echo 'Errori: ' . $errors . '<br>';
    }
    echo '</div>';
} else {
    echo '<div class="warning">';
    echo '<strong>⚠️ Nessuna razza importata</strong><br>';
    echo 'Tutte le razze potrebbero già esistere nel database.';
    echo '</div>';
}

// Link alle razze
echo '<h3>Visualizza le Razze Importate</h3>';
echo '<ul>';

foreach ( $breeds as $breed ) {
    $post = get_page_by_title( $breed['post_title'], OBJECT, 'razze_di_cani' );
    if ( $post ) {
        $url = get_permalink( $post->ID );
        echo '<li><a href="' . esc_url( $url ) . '" target="_blank">' . esc_html( $breed['post_title'] ) . '</a></li>';
    }
}

echo '</ul>';

// Avviso sicurezza
echo '<hr>';
echo '<div class="error">';
echo '<strong>⚠️ IMPORTANTE - SICUREZZA</strong><br>';
echo 'Questo script può essere eseguito solo una volta.<br>';
echo '<strong>ELIMINA IMMEDIATAMENTE questo file dal server per sicurezza!</strong><br><br>';
echo 'Esegui dal terminale:<br>';
echo '<pre>rm ' . esc_html( __FILE__ ) . '</pre>';
echo 'oppure elimina il file via FTP/File Manager.';
echo '</div>';

// Link dashboard
echo '<a href="' . admin_url( 'edit.php?post_type=razze_di_cani' ) . '" class="btn">Vai alla Dashboard Razze</a>';

?>

    </div>
</body>
</html>
