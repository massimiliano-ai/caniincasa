<?php
/**
 * Custom Post Types: Annunci Privati e Adozioni
 * Gestione annunci utenti
 *
 * @package CaninCasa
 * @since 2.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Annunci Privati Custom Post Type
 */
function caniincasa_register_cpt_annunci_privati() {
    $labels = array(
        'name'                  => _x( 'Annunci Privati', 'Post Type General Name', 'caniincasa' ),
        'singular_name'         => _x( 'Annuncio Privato', 'Post Type Singular Name', 'caniincasa' ),
        'menu_name'             => __( 'Annunci Privati', 'caniincasa' ),
        'name_admin_bar'        => __( 'Annuncio Privato', 'caniincasa' ),
        'archives'              => __( 'Archivio Annunci Privati', 'caniincasa' ),
        'all_items'             => __( 'Tutti gli Annunci', 'caniincasa' ),
        'add_new_item'          => __( 'Aggiungi Nuovo Annuncio', 'caniincasa' ),
        'add_new'               => __( 'Aggiungi Nuovo', 'caniincasa' ),
        'new_item'              => __( 'Nuovo Annuncio', 'caniincasa' ),
        'edit_item'             => __( 'Modifica Annuncio', 'caniincasa' ),
        'update_item'           => __( 'Aggiorna Annuncio', 'caniincasa' ),
        'view_item'             => __( 'Visualizza Annuncio', 'caniincasa' ),
        'search_items'          => __( 'Cerca Annuncio', 'caniincasa' ),
        'not_found'             => __( 'Nessun annuncio trovato', 'caniincasa' ),
        'not_found_in_trash'    => __( 'Nessun annuncio nel cestino', 'caniincasa' ),
    );

    $args = array(
        'label'                 => __( 'Annuncio Privato', 'caniincasa' ),
        'description'           => __( 'Annunci privati di vendita/cessione cani', 'caniincasa' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author', 'revisions' ),
        'taxonomies'            => array( 'provincia' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 26,
        'menu_icon'             => 'dashicons-megaphone',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'annunci-privati',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rewrite'               => array(
            'slug'       => 'annunci-privati',
            'with_front' => false,
        ),
    );

    register_post_type( 'annunci_privati', $args );
}
add_action( 'init', 'caniincasa_register_cpt_annunci_privati', 0 );

/**
 * Register Annunci Adozioni Custom Post Type
 */
function caniincasa_register_cpt_annunci_adozioni() {
    $labels = array(
        'name'                  => _x( 'Cani in Adozione', 'Post Type General Name', 'caniincasa' ),
        'singular_name'         => _x( 'Cane in Adozione', 'Post Type Singular Name', 'caniincasa' ),
        'menu_name'             => __( 'Adozioni', 'caniincasa' ),
        'name_admin_bar'        => __( 'Adozione', 'caniincasa' ),
        'archives'              => __( 'Archivio Adozioni', 'caniincasa' ),
        'all_items'             => __( 'Tutte le Adozioni', 'caniincasa' ),
        'add_new_item'          => __( 'Aggiungi Nuova Adozione', 'caniincasa' ),
        'add_new'               => __( 'Aggiungi Nuova', 'caniincasa' ),
        'new_item'              => __( 'Nuova Adozione', 'caniincasa' ),
        'edit_item'             => __( 'Modifica Adozione', 'caniincasa' ),
        'update_item'           => __( 'Aggiorna Adozione', 'caniincasa' ),
        'view_item'             => __( 'Visualizza Adozione', 'caniincasa' ),
        'search_items'          => __( 'Cerca Adozione', 'caniincasa' ),
        'not_found'             => __( 'Nessuna adozione trovata', 'caniincasa' ),
        'not_found_in_trash'    => __( 'Nessuna adozione nel cestino', 'caniincasa' ),
    );

    $args = array(
        'label'                 => __( 'Adozione', 'caniincasa' ),
        'description'           => __( 'Cani disponibili per adozione', 'caniincasa' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'author', 'revisions' ),
        'taxonomies'            => array( 'provincia' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 27,
        'menu_icon'             => 'dashicons-heart',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => 'adozioni',
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_rest'          => true,
        'rewrite'               => array(
            'slug'       => 'adozioni',
            'with_front' => false,
        ),
    );

    register_post_type( 'annunci_adozioni', $args );
}
add_action( 'init', 'caniincasa_register_cpt_annunci_adozioni', 0 );

/**
 * Add custom columns to annunci_privati admin list
 */
function caniincasa_annunci_privati_custom_columns( $columns ) {
    $new_columns = array();

    foreach ( $columns as $key => $value ) {
        $new_columns[$key] = $value;

        if ( $key === 'title' ) {
            $new_columns['razza'] = __( 'Razza', 'caniincasa' );
            $new_columns['tipo_annuncio'] = __( 'Tipo', 'caniincasa' );
            $new_columns['prezzo'] = __( 'Prezzo', 'caniincasa' );
            $new_columns['provincia'] = __( 'Provincia', 'caniincasa' );
        }
    }

    return $new_columns;
}
add_filter( 'manage_annunci_privati_posts_columns', 'caniincasa_annunci_privati_custom_columns' );

/**
 * Populate custom columns for annunci_privati
 */
function caniincasa_annunci_privati_custom_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'razza':
            $razza = get_field( 'razza', $post_id );
            echo $razza ? esc_html( $razza ) : '—';
            break;

        case 'tipo_annuncio':
            $tipo = get_field( 'tipo_annuncio', $post_id );
            if ( $tipo === 'vendita' ) {
                echo '💰 Vendita';
            } elseif ( $tipo === 'cessione' ) {
                echo '🤝 Cessione';
            } else {
                echo '—';
            }
            break;

        case 'prezzo':
            $prezzo = get_field( 'prezzo', $post_id );
            if ( $prezzo ) {
                echo '€ ' . number_format( $prezzo, 0, ',', '.' );
            } else {
                echo 'N.D.';
            }
            break;

        case 'provincia':
            $province = wp_get_post_terms( $post_id, 'provincia' );
            if ( ! empty( $province ) && ! is_wp_error( $province ) ) {
                echo esc_html( $province[0]->name );
            }
            break;
    }
}
add_action( 'manage_annunci_privati_posts_custom_column', 'caniincasa_annunci_privati_custom_column_content', 10, 2 );

/**
 * Add custom columns to annunci_adozioni admin list
 */
function caniincasa_annunci_adozioni_custom_columns( $columns ) {
    $new_columns = array();

    foreach ( $columns as $key => $value ) {
        $new_columns[$key] = $value;

        if ( $key === 'title' ) {
            $new_columns['nome_cane'] = __( 'Nome Cane', 'caniincasa' );
            $new_columns['eta'] = __( 'Età', 'caniincasa' );
            $new_columns['taglia'] = __( 'Taglia', 'caniincasa' );
            $new_columns['provincia'] = __( 'Provincia', 'caniincasa' );
        }
    }

    return $new_columns;
}
add_filter( 'manage_annunci_adozioni_posts_columns', 'caniincasa_annunci_adozioni_custom_columns' );

/**
 * Populate custom columns for annunci_adozioni
 */
function caniincasa_annunci_adozioni_custom_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'nome_cane':
            $nome = get_field( 'nome_cane', $post_id );
            echo $nome ? esc_html( $nome ) : '—';
            break;

        case 'eta':
            $eta_anni = get_field( 'eta_anni', $post_id );
            $eta_mesi = get_field( 'eta_mesi', $post_id );
            if ( $eta_anni || $eta_mesi ) {
                $parts = array();
                if ( $eta_anni ) $parts[] = $eta_anni . ' anni';
                if ( $eta_mesi ) $parts[] = $eta_mesi . ' mesi';
                echo implode( ', ', $parts );
            } else {
                echo '—';
            }
            break;

        case 'taglia':
            $taglia = get_field( 'taglia', $post_id );
            echo $taglia ? esc_html( ucfirst( $taglia ) ) : '—';
            break;

        case 'provincia':
            $province = wp_get_post_terms( $post_id, 'provincia' );
            if ( ! empty( $province ) && ! is_wp_error( $province ) ) {
                echo esc_html( $province[0]->name );
            }
            break;
    }
}
add_action( 'manage_annunci_adozioni_posts_custom_column', 'caniincasa_annunci_adozioni_custom_column_content', 10, 2 );

/**
 * Add pending count dashboard widgets
 */
function caniincasa_add_pending_annunci_meta_boxes() {
    if ( current_user_can( 'approve_annunci' ) || current_user_can( 'moderate_content' ) ) {
        add_meta_box(
            'caniincasa_pending_annunci',
            __( 'Annunci in Attesa', 'caniincasa' ),
            'caniincasa_render_pending_annunci_meta_box',
            'dashboard',
            'side',
            'high'
        );
    }
}
add_action( 'wp_dashboard_setup', 'caniincasa_add_pending_annunci_meta_boxes' );

/**
 * Render pending annunci meta box
 */
function caniincasa_render_pending_annunci_meta_box() {
    $pending_privati = wp_count_posts( 'annunci_privati' )->pending;
    $pending_adozioni = wp_count_posts( 'annunci_adozioni' )->pending;
    $total = $pending_privati + $pending_adozioni;

    echo '<div style="padding: 10px;">';
    if ( $total > 0 ) {
        echo '<p style="font-size: 16px; margin: 0 0 10px 0;">';
        echo '<strong style="color: #e65229; font-size: 24px;">' . $total . '</strong> ';
        echo _n( 'annuncio in attesa', 'annunci in attesa', $total, 'caniincasa' );
        echo '</p>';

        if ( $pending_privati > 0 ) {
            echo '<p style="margin: 5px 0;"><strong>' . $pending_privati . '</strong> Annunci Privati</p>';
        }
        if ( $pending_adozioni > 0 ) {
            echo '<p style="margin: 5px 0;"><strong>' . $pending_adozioni . '</strong> Adozioni</p>';
        }

        echo '<div style="margin-top: 10px;">';
        if ( $pending_privati > 0 ) {
            echo '<a href="' . admin_url( 'edit.php?post_type=annunci_privati&post_status=pending' ) . '" class="button" style="margin-right: 5px;">Modera Privati</a>';
        }
        if ( $pending_adozioni > 0 ) {
            echo '<a href="' . admin_url( 'edit.php?post_type=annunci_adozioni&post_status=pending' ) . '" class="button">Modera Adozioni</a>';
        }
        echo '</div>';
    } else {
        echo '<p>' . __( 'Nessun annuncio in attesa di moderazione.', 'caniincasa' ) . '</p>';
        echo '<p style="color: green;">✓ Tutto approvato!</p>';
    }
    echo '</div>';
}
