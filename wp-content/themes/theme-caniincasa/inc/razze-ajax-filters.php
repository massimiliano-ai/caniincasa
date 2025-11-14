<?php
/**
 * AJAX Handlers for Razze Filters
 *
 * @package CaninCasa
 * @since 2.0.0
 */

// Register AJAX handlers
add_action( 'wp_ajax_filter_razze', 'caniincasa_filter_razze' );
add_action( 'wp_ajax_nopriv_filter_razze', 'caniincasa_filter_razze' );

/**
 * AJAX Handler per filtrare le razze
 */
function caniincasa_filter_razze() {
    // Verifica nonce
    check_ajax_referer( 'razze_filter_nonce', 'nonce' );

    // Parametri filtri
    $search = isset( $_POST['search'] ) ? sanitize_text_field( $_POST['search'] ) : '';
    $sizes = isset( $_POST['sizes'] ) ? array_map( 'sanitize_text_field', $_POST['sizes'] ) : array();
    $energy = isset( $_POST['energy'] ) ? floatval( $_POST['energy'] ) : 0;
    $apartment = isset( $_POST['apartment'] ) ? floatval( $_POST['apartment'] ) : 0;
    $kids = isset( $_POST['kids'] ) ? floatval( $_POST['kids'] ) : 0;
    $experience = isset( $_POST['experience'] ) ? floatval( $_POST['experience'] ) : 0;
    $sort_by = isset( $_POST['sort_by'] ) ? sanitize_text_field( $_POST['sort_by'] ) : 'name-asc';
    $paged = isset( $_POST['paged'] ) ? intval( $_POST['paged'] ) : 1;
    $per_page = 24;

    // Query args base
    $args = array(
        'post_type' => 'razze_di_cani',
        'post_status' => 'publish',
        'posts_per_page' => $per_page,
        'paged' => $paged,
    );

    // Filtro ricerca testuale
    if ( !empty( $search ) ) {
        $args['s'] = $search;
    }

    // Meta query per caratteristiche
    $meta_query = array( 'relation' => 'AND' );

    // Filtro energia
    if ( $energy > 0 ) {
        $meta_query[] = array(
            'key' => 'energia_e_livelli_di_attivita',
            'value' => $energy,
            'compare' => '>=',
            'type' => 'DECIMAL',
        );
    }

    // Filtro appartamento
    if ( $apartment > 0 ) {
        $meta_query[] = array(
            'key' => 'adattabilita_appartamento',
            'value' => $apartment,
            'compare' => '>=',
            'type' => 'DECIMAL',
        );
    }

    // Filtro bambini
    if ( $kids > 0 ) {
        $meta_query[] = array(
            'key' => 'compatibilita_con_i_bambini',
            'value' => $kids,
            'compare' => '>=',
            'type' => 'DECIMAL',
        );
    }

    // Filtro esperienza
    if ( $experience > 0 ) {
        $meta_query[] = array(
            'key' => 'livello_esperienza_richiesto',
            'value' => $experience,
            'compare' => '<=',
            'type' => 'DECIMAL',
        );
    }

    if ( count( $meta_query ) > 1 ) {
        $args['meta_query'] = $meta_query;
    }

    // Ordinamento
    switch ( $sort_by ) {
        case 'name-asc':
            $args['orderby'] = 'title';
            $args['order'] = 'ASC';
            break;
        case 'name-desc':
            $args['orderby'] = 'title';
            $args['order'] = 'DESC';
            break;
        case 'popular':
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = 'views_count'; // Assumendo che tracci le visualizzazioni
            $args['order'] = 'DESC';
            break;
    }

    // Esegui query
    $query = new WP_Query( $args );

    // Post-filtraggio per dimensione (se non possiamo farlo via ACF direttamente)
    $results = array();

    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $post_id = get_the_ID();

            // Filtro dimensione (se specificato)
            if ( !empty( $sizes ) ) {
                $breed_size = caniincasa_get_breed_size( $post_id );
                if ( !in_array( $breed_size, $sizes ) ) {
                    continue; // Salta questa razza
                }
            }

            // Costruisci dati razza
            $results[] = caniincasa_get_breed_card_data( $post_id );
        }
    }

    wp_reset_postdata();

    // Risposta JSON
    wp_send_json_success( array(
        'breeds' => $results,
        'total' => count( $results ),
        'found_posts' => $query->found_posts,
        'max_pages' => $query->max_num_pages,
        'current_page' => $paged,
    ) );
}

/**
 * Determina la dimensione della razza in base al peso/taglia
 */
function caniincasa_get_breed_size( $post_id ) {
    // Qui puoi usare logica basata su campi ACF
    // Per ora uso un esempio semplificato
    $aspetto = get_field( 'aspetto_fisico', $post_id );

    if ( empty( $aspetto ) ) {
        return 'media'; // Default
    }

    // Cerca indicazioni di peso nel testo
    $aspetto_lower = strtolower( $aspetto );

    if ( strpos( $aspetto_lower, '< 10' ) !== false || strpos( $aspetto_lower, 'fino a 10' ) !== false ) {
        return 'piccola';
    } elseif ( strpos( $aspetto_lower, '10-25' ) !== false || strpos( $aspetto_lower, '25 kg' ) !== false ) {
        return 'media';
    } elseif ( strpos( $aspetto_lower, '25-45' ) !== false || strpos( $aspetto_lower, '45 kg' ) !== false ) {
        return 'grande';
    } elseif ( strpos( $aspetto_lower, '> 45' ) !== false || strpos( $aspetto_lower, 'oltre 45' ) !== false ) {
        return 'gigante';
    }

    return 'media';
}

/**
 * Ottieni dati formattati per la card della razza
 */
function caniincasa_get_breed_card_data( $post_id ) {
    $thumbnail_id = get_post_thumbnail_id( $post_id );
    $image_url = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'medium_large' ) : '';

    return array(
        'id' => $post_id,
        'title' => get_the_title( $post_id ),
        'link' => get_permalink( $post_id ),
        'excerpt' => get_the_excerpt( $post_id ),
        'image' => $image_url,
        'energy' => get_field( 'energia_e_livelli_di_attivita', $post_id ) ?: 0,
        'apartment' => get_field( 'adattabilita_appartamento', $post_id ) ?: 0,
        'kids' => get_field( 'compatibilita_con_i_bambini', $post_id ) ?: 0,
        'temperament' => get_field( 'temperamento_breve', $post_id ) ?: '',
        'origin' => get_field( 'nazione_origine', $post_id ) ?: '',
    );
}
