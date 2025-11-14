<?php
/**
 * Template Functions
 * Helper functions for templates
 *
 * @package CaninCasa
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get Rating Stars HTML
 *
 * @param int $rating Rating value (1-5)
 * @param bool $show_value Show numeric value
 * @return string HTML output
 */
function caniincasa_get_rating_stars( $rating = 0, $show_value = true ) {
    $rating = absint( $rating );
    $rating = min( max( $rating, 0 ), 5 ); // Ensure rating is between 0 and 5

    $output = '<div class="rating-stars">';

    for ( $i = 1; $i <= 5; $i++ ) {
        $class = $i <= $rating ? 'star filled' : 'star';
        $output .= '<span class="' . esc_attr( $class ) . '">★</span>';
    }

    if ( $show_value ) {
        $output .= ' <span class="rating-value">' . esc_html( $rating ) . '/5</span>';
    }

    $output .= '</div>';

    return $output;
}

/**
 * Display Rating Stars
 *
 * @param int $rating Rating value (1-5)
 * @param bool $show_value Show numeric value
 */
function caniincasa_rating_stars( $rating = 0, $show_value = true ) {
    echo caniincasa_get_rating_stars( $rating, $show_value );
}

/**
 * Get Breadcrumbs HTML
 *
 * @return string HTML output
 */
function caniincasa_get_breadcrumbs() {
    if ( is_front_page() ) {
        return '';
    }

    $output = '<nav class="breadcrumbs" aria-label="' . esc_attr__( 'Breadcrumb', 'caniincasa' ) . '">';
    $output .= '<div class="breadcrumbs-container">';
    $output .= '<ol class="breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">';

    // Home
    $output .= '<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
    $output .= '<a href="' . esc_url( home_url( '/' ) ) . '" itemprop="item">';
    $output .= '<span itemprop="name">' . esc_html__( 'Home', 'caniincasa' ) . '</span>';
    $output .= '</a>';
    $output .= '<meta itemprop="position" content="1" />';
    $output .= '</li>';

    $position = 2;

    if ( is_single() || is_page() ) {
        $post_type = get_post_type();

        // Add post type archive
        if ( $post_type !== 'post' && $post_type !== 'page' ) {
            $post_type_object = get_post_type_object( $post_type );
            if ( $post_type_object ) {
                $output .= '<li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
                $output .= '<span itemprop="name">' . esc_html( $post_type_object->labels->name ) . '</span>';
                $output .= '<meta itemprop="position" content="' . esc_attr( $position ) . '" />';
                $output .= '</li>';
                $position++;
            }
        }

        // Add current page/post
        $output .= '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<span itemprop="name">' . esc_html( get_the_title() ) . '</span>';
        $output .= '<meta itemprop="position" content="' . esc_attr( $position ) . '" />';
        $output .= '</li>';

    } elseif ( is_category() || is_tax() || is_tag() ) {
        $term = get_queried_object();
        $output .= '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<span itemprop="name">' . esc_html( $term->name ) . '</span>';
        $output .= '<meta itemprop="position" content="' . esc_attr( $position ) . '" />';
        $output .= '</li>';

    } elseif ( is_archive() ) {
        $output .= '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<span itemprop="name">' . esc_html( get_the_archive_title() ) . '</span>';
        $output .= '<meta itemprop="position" content="' . esc_attr( $position ) . '" />';
        $output .= '</li>';

    } elseif ( is_search() ) {
        $output .= '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<span itemprop="name">' . esc_html__( 'Risultati ricerca per:', 'caniincasa' ) . ' ' . esc_html( get_search_query() ) . '</span>';
        $output .= '<meta itemprop="position" content="' . esc_attr( $position ) . '" />';
        $output .= '</li>';

    } elseif ( is_404() ) {
        $output .= '<li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">';
        $output .= '<span itemprop="name">' . esc_html__( 'Pagina non trovata', 'caniincasa' ) . '</span>';
        $output .= '<meta itemprop="position" content="' . esc_attr( $position ) . '" />';
        $output .= '</li>';
    }

    $output .= '</ol>';
    $output .= '</div>'; // .breadcrumbs-container
    $output .= '</nav>';

    return $output;
}

/**
 * Display Breadcrumbs
 */
function caniincasa_breadcrumbs() {
    echo caniincasa_get_breadcrumbs();
}

/**
 * Get Contact Info Box HTML
 *
 * @param int $post_id Post ID
 * @return string HTML output
 */
function caniincasa_get_contact_box( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $email = get_post_meta( $post_id, 'email', true );
    $telefono = get_post_meta( $post_id, 'telefono', true );
    $telefono_principale = get_post_meta( $post_id, 'telefono_principale', true );
    $cellulare = get_post_meta( $post_id, 'cellulare', true );
    $sito_web = get_post_meta( $post_id, 'sito_web', true );
    $indirizzo = get_post_meta( $post_id, 'indirizzo', true );
    $citta = get_post_meta( $post_id, 'citta', true );
    $provincia = get_post_meta( $post_id, 'provincia', true );

    $phone = $telefono_principale ? $telefono_principale : $telefono;
    $phone = $phone ? $phone : $cellulare;

    $output = '<div class="contact-box">';
    $output .= '<h3>' . esc_html__( 'Informazioni Contatto', 'caniincasa' ) . '</h3>';
    $output .= '<ul class="contact-list">';

    if ( $phone ) {
        $output .= '<li class="contact-phone">';
        $output .= '<i class="icon-phone">📞</i> ';
        $output .= '<a href="' . esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a>';
        $output .= '</li>';
    }

    if ( $email ) {
        $output .= '<li class="contact-email">';
        $output .= '<i class="icon-email">✉️</i> ';
        $output .= '<a href="' . esc_url( 'mailto:' . $email ) . '">' . esc_html( $email ) . '</a>';
        $output .= '</li>';
    }

    if ( $sito_web ) {
        $output .= '<li class="contact-web">';
        $output .= '<i class="icon-web">🌐</i> ';
        $output .= '<a href="' . esc_url( $sito_web ) . '" target="_blank" rel="noopener">' . esc_html__( 'Visita il sito', 'caniincasa' ) . '</a>';
        $output .= '</li>';
    }

    if ( $indirizzo && $citta ) {
        $full_address = $indirizzo . ', ' . $citta;
        if ( $provincia ) {
            $full_address .= ' (' . $provincia . ')';
        }
        $output .= '<li class="contact-location">';
        $output .= '<i class="icon-location">📍</i> ';
        $output .= esc_html( $full_address );
        $output .= '</li>';
    }

    $output .= '</ul>';
    $output .= '</div>';

    return $output;
}

/**
 * Display Contact Box
 *
 * @param int $post_id Post ID
 */
function caniincasa_contact_box( $post_id = null ) {
    echo caniincasa_get_contact_box( $post_id );
}

/**
 * Get Related Posts
 *
 * @param int $post_id Post ID
 * @param int $count Number of posts to retrieve
 * @return WP_Query|false
 */
function caniincasa_get_related_posts( $post_id = null, $count = 3 ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }

    $post_type = get_post_type( $post_id );
    $taxonomies = get_object_taxonomies( $post_type, 'names' );

    $args = array(
        'post_type'      => $post_type,
        'posts_per_page' => $count,
        'post__not_in'   => array( $post_id ),
        'orderby'        => 'rand',
    );

    // Try to get related posts by taxonomy
    if ( ! empty( $taxonomies ) ) {
        $terms = wp_get_post_terms( $post_id, $taxonomies, array( 'fields' => 'ids' ) );

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => $taxonomies[0],
                    'field'    => 'term_id',
                    'terms'    => $terms,
                ),
            );
        }
    }

    $query = new WP_Query( $args );

    return $query->have_posts() ? $query : false;
}

/**
 * Sanitize Textarea Field
 *
 * @param string $input Input value
 * @return string Sanitized value
 */
function caniincasa_sanitize_textarea( $input ) {
    return wp_kses_post( $input );
}

/**
 * Get Province List (Italian Provinces)
 *
 * @return array
 */
function caniincasa_get_province_list() {
    return array(
        'AG' => 'Agrigento',
        'AL' => 'Alessandria',
        'AN' => 'Ancona',
        'AO' => 'Aosta',
        'AR' => 'Arezzo',
        'AP' => 'Ascoli Piceno',
        'AT' => 'Asti',
        'AV' => 'Avellino',
        'BA' => 'Bari',
        'BT' => 'Barletta-Andria-Trani',
        'BL' => 'Belluno',
        'BN' => 'Benevento',
        'BG' => 'Bergamo',
        'BI' => 'Biella',
        'BO' => 'Bologna',
        'BZ' => 'Bolzano',
        'BS' => 'Brescia',
        'BR' => 'Brindisi',
        'CA' => 'Cagliari',
        'CL' => 'Caltanissetta',
        'CB' => 'Campobasso',
        'CI' => 'Carbonia-Iglesias',
        'CE' => 'Caserta',
        'CT' => 'Catania',
        'CZ' => 'Catanzaro',
        'CH' => 'Chieti',
        'CO' => 'Como',
        'CS' => 'Cosenza',
        'CR' => 'Cremona',
        'KR' => 'Crotone',
        'CN' => 'Cuneo',
        'EN' => 'Enna',
        'FM' => 'Fermo',
        'FE' => 'Ferrara',
        'FI' => 'Firenze',
        'FG' => 'Foggia',
        'FC' => 'Forlì-Cesena',
        'FR' => 'Frosinone',
        'GE' => 'Genova',
        'GO' => 'Gorizia',
        'GR' => 'Grosseto',
        'IM' => 'Imperia',
        'IS' => 'Isernia',
        'SP' => 'La Spezia',
        'AQ' => 'L\'Aquila',
        'LT' => 'Latina',
        'LE' => 'Lecce',
        'LC' => 'Lecco',
        'LI' => 'Livorno',
        'LO' => 'Lodi',
        'LU' => 'Lucca',
        'MC' => 'Macerata',
        'MN' => 'Mantova',
        'MS' => 'Massa-Carrara',
        'MT' => 'Matera',
        'ME' => 'Messina',
        'MI' => 'Milano',
        'MO' => 'Modena',
        'MB' => 'Monza e Brianza',
        'NA' => 'Napoli',
        'NO' => 'Novara',
        'NU' => 'Nuoro',
        'OT' => 'Olbia-Tempio',
        'OR' => 'Oristano',
        'PD' => 'Padova',
        'PA' => 'Palermo',
        'PR' => 'Parma',
        'PV' => 'Pavia',
        'PG' => 'Perugia',
        'PU' => 'Pesaro e Urbino',
        'PE' => 'Pescara',
        'PC' => 'Piacenza',
        'PI' => 'Pisa',
        'PT' => 'Pistoia',
        'PN' => 'Pordenone',
        'PZ' => 'Potenza',
        'PO' => 'Prato',
        'RG' => 'Ragusa',
        'RA' => 'Ravenna',
        'RC' => 'Reggio Calabria',
        'RE' => 'Reggio Emilia',
        'RI' => 'Rieti',
        'RN' => 'Rimini',
        'RM' => 'Roma',
        'RO' => 'Rovigo',
        'SA' => 'Salerno',
        'VS' => 'Medio Campidano',
        'SS' => 'Sassari',
        'SV' => 'Savona',
        'SI' => 'Siena',
        'SR' => 'Siracusa',
        'SO' => 'Sondrio',
        'TA' => 'Taranto',
        'TE' => 'Teramo',
        'TR' => 'Terni',
        'TO' => 'Torino',
        'OG' => 'Ogliastra',
        'TP' => 'Trapani',
        'TN' => 'Trento',
        'TV' => 'Treviso',
        'TS' => 'Trieste',
        'UD' => 'Udine',
        'VA' => 'Varese',
        'VE' => 'Venezia',
        'VB' => 'Verbano-Cusio-Ossola',
        'VC' => 'Vercelli',
        'VR' => 'Verona',
        'VV' => 'Vibo Valentia',
        'VI' => 'Vicenza',
        'VT' => 'Viterbo',
    );
}

/**
 * Custom Comment Callback
 *
 * @param object $comment Comment object
 * @param array  $args    Comment args
 * @param int    $depth   Comment depth
 */
function caniincasa_custom_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
        <article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
            <div class="comment-author-avatar">
                <?php echo get_avatar( $comment, 50 ); ?>
            </div>

            <div class="comment-content-wrapper">
                <footer class="comment-meta">
                    <div class="comment-author vcard">
                        <?php
                        printf(
                            '<b class="fn">%s</b>',
                            get_comment_author_link()
                        );
                        ?>
                    </div>

                    <div class="comment-metadata">
                        <a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
                            <time datetime="<?php comment_time( 'c' ); ?>">
                                <?php
                                printf(
                                    esc_html__( '%1$s alle %2$s', 'caniincasa' ),
                                    get_comment_date(),
                                    get_comment_time()
                                );
                                ?>
                            </time>
                        </a>
                    </div>
                </footer>

                <?php if ( '0' === $comment->comment_approved ) : ?>
                    <p class="comment-awaiting-moderation">
                        <?php esc_html_e( 'Il tuo commento è in attesa di moderazione.', 'caniincasa' ); ?>
                    </p>
                <?php endif; ?>

                <div class="comment-content">
                    <?php comment_text(); ?>
                </div>

                <div class="comment-reply">
                    <?php
                    comment_reply_link(
                        array_merge(
                            $args,
                            array(
                                'depth'      => $depth,
                                'max_depth'  => $args['max_depth'],
                                'reply_text' => __( 'Rispondi', 'caniincasa' ),
                            )
                        )
                    );
                    ?>
                </div>
            </div>
        </article>
    <?php
}

/**
 * Get Archive Header HTML - Unified Style
 *
 * @param string $title Archive title
 * @param string $description Archive description
 * @param array $stats Optional stats array ['icon' => '', 'label' => '', 'value' => '']
 * @return string HTML output
 */
function caniincasa_get_archive_header( $title = '', $description = '', $stats = array() ) {
    if ( empty( $title ) ) {
        $title = get_the_archive_title();
    }

    $output = '<header class="archive-header">';
    $output .= '<div class="archive-header-content">';
    $output .= '<h1 class="archive-title">' . esc_html( $title ) . '</h1>';
    
    if ( ! empty( $description ) ) {
        $output .= '<p class="archive-description">' . esc_html( $description ) . '</p>';
    }

    if ( ! empty( $stats ) && is_array( $stats ) ) {
        $output .= '<div class="archive-stats">';
        foreach ( $stats as $stat ) {
            $output .= '<div class="archive-stat">';
            if ( ! empty( $stat['icon'] ) ) {
                $output .= '<span class="archive-stat-icon">' . esc_html( $stat['icon'] ) . '</span>';
            }
            if ( ! empty( $stat['label'] ) && ! empty( $stat['value'] ) ) {
                $output .= '<span>' . esc_html( $stat['value'] ) . ' ' . esc_html( $stat['label'] ) . '</span>';
            }
            $output .= '</div>';
        }
        $output .= '</div>';
    }

    $output .= '</div>'; // .archive-header-content
    $output .= '</header>';

    return $output;
}

/**
 * Display Archive Header
 */
function caniincasa_archive_header( $title = '', $description = '', $stats = array() ) {
    echo caniincasa_get_archive_header( $title, $description, $stats );
}

/**
 * Get Page Header HTML - Unified Style for Single Pages
 *
 * @param string $title Page title
 * @param array $meta Optional meta items ['icon' => '', 'label' => '']
 * @return string HTML output
 */
function caniincasa_get_page_header( $title = '', $meta = array() ) {
    if ( empty( $title ) ) {
        $title = get_the_title();
    }

    $output = '<header class="page-header">';
    $output .= '<h1 class="page-header-title">' . esc_html( $title ) . '</h1>';

    if ( ! empty( $meta ) && is_array( $meta ) ) {
        $output .= '<div class="page-header-meta">';
        foreach ( $meta as $item ) {
            $output .= '<div class="page-header-meta-item">';
            if ( ! empty( $item['icon'] ) ) {
                $output .= '<span class="page-header-meta-icon">' . esc_html( $item['icon'] ) . '</span>';
            }
            if ( ! empty( $item['label'] ) ) {
                $output .= '<span>' . esc_html( $item['label'] ) . '</span>';
            }
            $output .= '</div>';
        }
        $output .= '</div>';
    }

    $output .= '</header>';

    return $output;
}

/**
 * Display Page Header
 */
function caniincasa_page_header( $title = '', $meta = array() ) {
    echo caniincasa_get_page_header( $title, $meta );
}
