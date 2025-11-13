<?php
/**
 * AJAX Handler per Importazione Web - VERSIONE MIGLIORATA
 * Cerca i JSON in più posizioni possibili
 */

// Carica WordPress
require_once __DIR__ . '/wp-load.php';

// Disabilita output buffering per streaming in tempo reale
if (function_exists('apache_setenv')) {
    apache_setenv('no-gzip', '1');
}
ini_set('zlib.output_compression', 0);
ini_set('implicit_flush', 1);
ob_implicit_flush(1);

// Headers per streaming
header('Content-Type: application/json');
header('Cache-Control: no-cache');
header('X-Accel-Buffering: no'); // Nginx

// Aumenta limiti di esecuzione
set_time_limit(600); // 10 minuti
ini_set('memory_limit', '512M');

/**
 * Invia messaggio JSON al client
 */
function send_message($type, $data) {
    echo json_encode(array_merge(['type' => $type], $data)) . "\n";
    if (ob_get_level() > 0) {
        ob_flush();
    }
    flush();
}

/**
 * Download e associa immagine
 */
function download_and_attach_image($image_url, $post_id, $image_filename) {
    // Verifica se immagine già esiste
    $existing = get_posts([
        'post_type' => 'attachment',
        'meta_query' => [[
            'key' => '_wp_attached_file',
            'value' => $image_filename,
            'compare' => 'LIKE'
        ]],
        'posts_per_page' => 1
    ]);

    if (!empty($existing)) {
        set_post_thumbnail($post_id, $existing[0]->ID);
        return $existing[0]->ID;
    }

    // Download immagine
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');

    $tmp_file = download_url($image_url, 30);

    if (is_wp_error($tmp_file)) {
        return false;
    }

    $file_array = [
        'name' => $image_filename,
        'tmp_name' => $tmp_file
    ];

    $attachment_id = media_handle_sideload($file_array, $post_id);

    if (is_wp_error($attachment_id)) {
        @unlink($tmp_file);
        return false;
    }

    set_post_thumbnail($post_id, $attachment_id);
    return $attachment_id;
}

/**
 * Importa una singola razza
 */
function import_breed($breed_data) {
    // Verifica se esiste già
    $existing = get_page_by_path($breed_data['slug'], OBJECT, 'razze_di_cani');

    if ($existing) {
        return [
            'success' => true,
            'post_id' => $existing->ID,
            'message' => 'Già esistente, saltato'
        ];
    }

    // Crea il post
    $post_data = [
        'post_title' => $breed_data['post_title'],
        'post_excerpt' => $breed_data['post_excerpt'],
        'post_type' => 'razze_di_cani',
        'post_status' => 'publish',
        'post_name' => $breed_data['slug'],
    ];

    $post_id = wp_insert_post($post_data);

    if (is_wp_error($post_id)) {
        return [
            'success' => false,
            'message' => 'Errore creazione post: ' . $post_id->get_error_message()
        ];
    }

    // Tassonomie
    if (!empty($breed_data['taxonomies']['razze_allevamenti'])) {
        wp_set_object_terms(
            $post_id,
            $breed_data['taxonomies']['razze_allevamenti'],
            'razze_allevamenti'
        );
    }

    // Immagine in evidenza
    if (!empty($breed_data['featured_image'])) {
        download_and_attach_image(
            $breed_data['featured_image']['url'],
            $post_id,
            $breed_data['featured_image']['filename']
        );
    }

    // Campi ACF
    if (!empty($breed_data['acf'])) {
        foreach ($breed_data['acf'] as $field_name => $field_value) {
            update_field($field_name, $field_value, $post_id);
        }
    }

    return [
        'success' => true,
        'post_id' => $post_id,
        'message' => 'Importato con successo'
    ];
}

// Inizia importazione
$start_time = microtime(true);

send_message('info', ['message' => '🔍 Ricerca file JSON...']);

// CERCA LA CARTELLA JSON IN PIÙ POSIZIONI
$possible_dirs = [
    __DIR__ . '/complete corrette',           // Stessa directory (con spazio)
    __DIR__ . '/complete-corrette',           // Stessa directory (con trattino)
    __DIR__ . '/razze-json',                  // Nome alternativo
    __DIR__ . '/json',                        // Nome semplice
    ABSPATH . 'complete corrette',            // Root WordPress (con spazio)
    ABSPATH . 'complete-corrette',            // Root WordPress (con trattino)
    ABSPATH . 'razze-json',                   // Root WordPress alternativo
    ABSPATH . 'json',                         // Root WordPress semplice
];

$json_dir = null;
$json_files = [];

foreach ($possible_dirs as $dir) {
    send_message('info', ['message' => "Cerco in: $dir"]);

    if (is_dir($dir)) {
        $files = glob($dir . '/*.json');
        if (!empty($files)) {
            $json_dir = $dir;
            $json_files = $files;
            send_message('info', ['message' => "✓ Trovata cartella: $dir"]);
            break;
        }
    }
}

// Se ancora non trovati, prova ricerca ricorsiva
if (empty($json_files)) {
    send_message('info', ['message' => '🔎 Ricerca ricorsiva in corso...']);

    // Cerca ricorsivamente dalla root di WordPress
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(ABSPATH, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'json') {
            $filepath = $file->getPathname();
            // Controlla se il nome file inizia con 'b' e finisce con '.json'
            if (preg_match('/b\d+\.json$/', basename($filepath))) {
                $json_files[] = $filepath;
                if (!$json_dir) {
                    $json_dir = dirname($filepath);
                    send_message('info', ['message' => "✓ File JSON trovati in: $json_dir"]);
                }
            }
        }

        // Limita ricerca per non impiegare troppo tempo
        if (count($json_files) >= 32) {
            break;
        }
    }
}

if (empty($json_files)) {
    send_message('error', ['message' => '❌ ERRORE: Nessun file JSON trovato!']);
    send_message('error', ['message' => 'Posizioni cercate:']);
    foreach ($possible_dirs as $dir) {
        send_message('error', ['message' => "  - $dir"]);
    }
    send_message('error', ['message' => '']);
    send_message('error', ['message' => 'SOLUZIONE: Carica la cartella "complete corrette" nella root di WordPress']);
    send_message('error', ['message' => 'Oppure rinominala in "razze-json" (senza spazi)']);
    exit;
}

send_message('info', ['message' => sprintf('📂 Trovati %d file JSON', count($json_files))]);
send_message('info', ['message' => '🚀 Avvio importazione...']);
send_message('info', ['message' => '']);

$total_imported = 0;
$total_breeds = 0;
$errors = 0;

// Processa ogni file
foreach ($json_files as $json_file) {
    $filename = basename($json_file);
    send_message('info', ['message' => "📄 Elaborazione: $filename"]);

    $json_content = file_get_contents($json_file);
    $breeds = json_decode($json_content, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        send_message('error', ['message' => "Errore parsing $filename: " . json_last_error_msg()]);
        continue;
    }

    foreach ($breeds as $breed_data) {
        $total_breeds++;

        $result = import_breed($breed_data);

        if ($result['success']) {
            $total_imported++;
            send_message('progress', [
                'current' => $total_imported,
                'total' => 320,
                'breed' => $breed_data['post_title'],
                'message' => $result['message'] . ' (ID: ' . $result['post_id'] . ')'
            ]);
        } else {
            $errors++;
            send_message('error', [
                'breed' => $breed_data['post_title'],
                'message' => $result['message']
            ]);
        }

        // Piccola pausa per non sovraccaricare
        usleep(100000); // 0.1 secondi
    }
}

$end_time = microtime(true);
$elapsed = round($end_time - $start_time, 2);

send_message('complete', [
    'imported' => $total_imported,
    'total' => $total_breeds,
    'errors' => $errors,
    'time' => $elapsed . ' secondi'
]);
