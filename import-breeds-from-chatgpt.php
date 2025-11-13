#!/usr/bin/env php
<?php
/**
 * Script di Importazione Razze da JSON generati da ChatGPT
 *
 * Importa razze canine complete con:
 * - Tutti i campi ACF
 * - Download e associazione immagini
 * - Tassonomie
 *
 * UTILIZZO:
 * php import-breeds-from-chatgpt.php batch_001_output.json
 * oppure per importare tutti i batch:
 * php import-breeds-from-chatgpt.php --all
 *
 * @package CaninCasa
 * @version 2.0.0
 */

// Carica WordPress
$wp_load_paths = [
    __DIR__ . '/wp-load.php',
    __DIR__ . '/../wp-load.php',
    __DIR__ . '/../../wp-load.php',
];

$wp_loaded = false;
foreach ($wp_load_paths as $path) {
    if (file_exists($path)) {
        require_once $path;
        $wp_loaded = true;
        break;
    }
}

if (!$wp_loaded) {
    die("❌ Errore: wp-load.php non trovato!\nEsegui lo script dalla root di WordPress.\n");
}

// Verifica ACF
if (!function_exists('update_field')) {
    die("❌ Errore: ACF non è installato o attivo!\n");
}

// Configurazione
define('BATCH_DIR', __DIR__ . '/chatgpt-batches');
define('DOWNLOADS_DIR', __DIR__ . '/temp-images');
define('DRY_RUN', false); // Imposta a true per test senza importare

// Statistiche
$stats = [
    'total' => 0,
    'imported' => 0,
    'skipped' => 0,
    'errors' => 0,
    'images_downloaded' => 0,
    'images_failed' => 0,
];

/**
 * Scarica un'immagine da URL e la importa nella Media Library
 */
function download_and_attach_image($image_url, $post_id, $image_filename) {
    global $stats;

    if (empty($image_url) || empty($image_filename)) {
        echo "  ⚠️  Nessuna immagine specificata\n";
        return false;
    }

    // Verifica se l'immagine esiste già
    $existing_attachment = get_posts([
        'post_type' => 'attachment',
        'meta_query' => [
            [
                'key' => '_wp_attached_file',
                'value' => $image_filename,
                'compare' => 'LIKE'
            ]
        ],
        'posts_per_page' => 1,
    ]);

    if (!empty($existing_attachment)) {
        echo "  ♻️  Immagine già esistente (ID: {$existing_attachment[0]->ID})\n";
        set_post_thumbnail($post_id, $existing_attachment[0]->ID);
        return $existing_attachment[0]->ID;
    }

    // Download dell'immagine
    echo "  📥 Download immagine: " . basename($image_url) . "...";

    $tmp_file = download_url($image_url);

    if (is_wp_error($tmp_file)) {
        echo " ❌ FALLITO\n";
        echo "     Errore: " . $tmp_file->get_error_message() . "\n";
        $stats['images_failed']++;
        return false;
    }

    // Prepara il file per l'upload
    $file_array = [
        'name' => $image_filename,
        'tmp_name' => $tmp_file
    ];

    // Importa nella Media Library
    $attachment_id = media_handle_sideload($file_array, $post_id);

    if (is_wp_error($attachment_id)) {
        @unlink($tmp_file);
        echo " ❌ FALLITO\n";
        echo "     Errore: " . $attachment_id->get_error_message() . "\n";
        $stats['images_failed']++;
        return false;
    }

    // Imposta come featured image
    set_post_thumbnail($post_id, $attachment_id);

    echo " ✓\n";
    echo "  🖼️  Immagine associata (ID: {$attachment_id})\n";
    $stats['images_downloaded']++;

    return $attachment_id;
}

/**
 * Importa una singola razza
 */
function import_breed($breed_data) {
    global $stats;

    $stats['total']++;

    $breed_title = $breed_data['post_title'];
    $breed_slug = $breed_data['slug'];

    echo "\n" . str_repeat('=', 70) . "\n";
    echo "🐕 RAZZA {$stats['total']}: {$breed_title}\n";
    echo str_repeat('=', 70) . "\n";

    // Verifica se esiste già
    $existing = get_page_by_path($breed_slug, OBJECT, 'razze_di_cani');

    if ($existing) {
        echo "⚠️  Razza già esistente (ID: {$existing->ID})\n";
        echo "   Vuoi sovrascriverla? [y/N]: ";

        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        fclose($handle);

        if (trim(strtolower($line)) !== 'y') {
            echo "⏭️  Saltata\n";
            $stats['skipped']++;
            return false;
        }

        $post_id = $existing->ID;
        echo "🔄 Aggiornamento...\n";
    } else {
        echo "➕ Creazione nuovo post...\n";
        $post_id = null;
    }

    if (DRY_RUN) {
        echo "🧪 [DRY RUN] - Nessuna modifica effettuata\n";
        $stats['imported']++;
        return true;
    }

    // Prepara dati post
    $post_data = [
        'post_title' => $breed_data['post_title'],
        'post_excerpt' => $breed_data['post_excerpt'],
        'post_type' => $breed_data['post_type'],
        'post_status' => $breed_data['post_status'],
        'post_name' => $breed_slug,
    ];

    if ($post_id) {
        $post_data['ID'] = $post_id;
    }

    // Inserisci/aggiorna post
    $post_id = wp_insert_post($post_data, true);

    if (is_wp_error($post_id)) {
        echo "❌ Errore creazione post: " . $post_id->get_error_message() . "\n";
        $stats['errors']++;
        return false;
    }

    echo "✓ Post creato/aggiornato (ID: {$post_id})\n";

    // Imposta tassonomie
    if (isset($breed_data['taxonomies']['razze_allevamenti']) && !empty($breed_data['taxonomies']['razze_allevamenti'])) {
        $terms = $breed_data['taxonomies']['razze_allevamenti'];
        wp_set_object_terms($post_id, $terms, 'razze_allevamenti', false);
        echo "✓ Tassonomia impostata: " . implode(', ', $terms) . "\n";
    }

    // Importa immagine
    if (isset($breed_data['featured_image'])) {
        download_and_attach_image(
            $breed_data['featured_image']['url'],
            $post_id,
            $breed_data['featured_image']['filename']
        );
    }

    // Importa campi ACF
    if (isset($breed_data['acf']) && is_array($breed_data['acf'])) {
        echo "📝 Importazione campi ACF...\n";

        $acf_count = 0;
        foreach ($breed_data['acf'] as $field_name => $field_value) {
            $result = update_field($field_name, $field_value, $post_id);
            if ($result) {
                $acf_count++;
            }
        }

        echo "✓ {$acf_count}/" . count($breed_data['acf']) . " campi ACF importati\n";
    }

    echo "✅ COMPLETATA: {$breed_title}\n";
    $stats['imported']++;

    return true;
}

/**
 * Importa un file JSON batch
 */
function import_batch_file($json_file) {
    echo "\n" . str_repeat('#', 70) . "\n";
    echo "📦 BATCH: " . basename($json_file) . "\n";
    echo str_repeat('#', 70) . "\n";

    if (!file_exists($json_file)) {
        echo "❌ File non trovato: {$json_file}\n";
        return false;
    }

    // Leggi JSON
    $json_content = file_get_contents($json_file);
    $breeds = json_decode($json_content, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo "❌ Errore JSON: " . json_last_error_msg() . "\n";
        return false;
    }

    if (!is_array($breeds)) {
        echo "❌ Il JSON non contiene un array di razze\n";
        return false;
    }

    echo "📋 Trovate " . count($breeds) . " razze nel batch\n";

    // Importa ogni razza
    foreach ($breeds as $breed) {
        import_breed($breed);
    }

    return true;
}

/**
 * Stampa statistiche finali
 */
function print_stats() {
    global $stats;

    echo "\n" . str_repeat('=', 70) . "\n";
    echo "📊 STATISTICHE IMPORTAZIONE\n";
    echo str_repeat('=', 70) . "\n";
    echo "Razze processate:      {$stats['total']}\n";
    echo "✓ Importate:           {$stats['imported']}\n";
    echo "⏭️  Saltate:            {$stats['skipped']}\n";
    echo "❌ Errori:             {$stats['errors']}\n";
    echo "🖼️  Immagini scaricate: {$stats['images_downloaded']}\n";
    echo "⚠️  Immagini fallite:   {$stats['images_failed']}\n";
    echo str_repeat('=', 70) . "\n";

    if ($stats['imported'] > 0) {
        echo "\n✅ Importazione completata con successo!\n";
        echo "🔗 Vai a: " . admin_url('edit.php?post_type=razze_di_cani') . "\n";
    }
}

/**
 * Main
 */
function main($args) {
    global $stats;

    echo "🐾 CaninCasa - Importatore Razze da ChatGPT v2.0\n";
    echo str_repeat('=', 70) . "\n\n";

    if (count($args) < 2) {
        echo "❌ Errore: Specifica il file JSON da importare\n\n";
        echo "Utilizzo:\n";
        echo "  php import-breeds-from-chatgpt.php batch_001_output.json\n";
        echo "  php import-breeds-from-chatgpt.php --all\n\n";
        exit(1);
    }

    $input = $args[1];

    // Modalità --all: importa tutti i batch
    if ($input === '--all') {
        $batch_files = glob(BATCH_DIR . '/batch_*_output.json');

        if (empty($batch_files)) {
            echo "❌ Nessun file batch_*_output.json trovato in " . BATCH_DIR . "\n";
            exit(1);
        }

        echo "📦 Trovati " . count($batch_files) . " file batch\n";
        echo "Vuoi importarli tutti? [y/N]: ";

        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        fclose($handle);

        if (trim(strtolower($line)) !== 'y') {
            echo "❌ Importazione annullata\n";
            exit(0);
        }

        sort($batch_files);
        foreach ($batch_files as $batch_file) {
            import_batch_file($batch_file);
        }
    } else {
        // Importa singolo file
        import_batch_file($input);
    }

    print_stats();
}

// Esegui
main($argv);
