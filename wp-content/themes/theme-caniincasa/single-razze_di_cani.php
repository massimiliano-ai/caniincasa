<?php
/**
 * Single Razze di Cani Template
 *
 * @package CaninCasa
 * @since 1.0.0
 */

get_header();
?>

<main id="main-content" class="site-main">
    <?php while ( have_posts() ) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class( 'razza-single' ); ?>>

            <?php caniincasa_breadcrumbs(); ?>

            <div class="container">
                <div class="razza-single__layout">

                    <!-- Main Content -->
                    <div class="razza-single__content">

                        <!-- Header -->
                        <header class="razza-single__header">
                            <h1 class="razza-single__title"><?php the_title(); ?></h1>

                            <?php if ( has_post_thumbnail() ) : ?>
                                <div class="razza-single__image">
                                    <?php the_post_thumbnail( 'caniincasa-featured', array( 'alt' => get_the_title() ) ); ?>
                                </div>
                            <?php endif; ?>
                        </header>

                        <!-- Description -->
                        <div class="razza-single__description">
                            <?php the_content(); ?>
                        </div>

                        <!-- Caratteristiche della Razza con Sistema Zampette -->
                        <?php
                        // Display new paw-based rating system
                        if ( function_exists( 'caniincasa_breed_characteristics' ) ) {
                            caniincasa_breed_characteristics();
                        }
                        ?>

                        <!-- Backward compatibility: Old characteristics (if new fields not filled) -->
                        <?php
                        // Check if new fields exist
                        $has_new_fields = function_exists( 'get_field' ) && get_field( 'livello_energia' );

                        if ( ! $has_new_fields ) {
                            // Show old characteristics format
                            $caratteristiche_caratteriali = array(
                                'livello_di_energia'                          => 'Livello di Energia',
                                'livello_di_affettuosità'                     => 'Livello di Affettuosità',
                                'socialità'                                   => 'Socialità',
                                'intelligenza'                                => 'Intelligenza',
                                'facilità_di_addestramento'                   => 'Facilità di Addestramento',
                                'necessità_di_toelettatura'                   => 'Necessità di Toelettatura',
                                'perdita_di_pelo'                             => 'Perdita di Pelo',
                                'tendenza_ad_abbaiare'                        => 'Tendenza ad Abbaiare',
                                'compatibilita_con_i_bambini'                 => 'Compatibilità con i Bambini',
                                'compatibilita_con_altri_animali_domestici'   => 'Compatibilità con Altri Animali',
                                'esigenze_di_esercizio'                       => 'Esigenze di Esercizio',
                                'predisposizioni_per_la_salute'               => 'Predisposizioni per la Salute',
                                'tolleranza_alla_solitudine'                  => 'Tolleranza alla Solitudine',
                                'adattabilita_clima_freddo'                   => 'Adattabilità al Clima Freddo',
                                'adattabilita_clima_caldo'                    => 'Adattabilità al Clima Caldo',
                                'istinti_di_caccia'                           => 'Istinti di Caccia',
                            );

                            $has_old_data = false;
                            foreach ( $caratteristiche_caratteriali as $field => $label ) {
                                if ( get_post_meta( get_the_ID(), $field, true ) ) {
                                    $has_old_data = true;
                                    break;
                                }
                            }

                            if ( $has_old_data ) :
                        ?>
                            <div class="characteristic-group">
                                <h2 class="characteristic-group__title">Caratteristiche Caratteriali</h2>
                                <div class="characteristic-list">
                                    <?php foreach ( $caratteristiche_caratteriali as $field => $label ) : ?>
                                        <?php $value = get_post_meta( get_the_ID(), $field, true ); ?>
                                        <?php if ( $value ) : ?>
                                            <div class="rating-item">
                                                <span class="rating-label"><?php echo esc_html( $label ); ?></span>
                                                <?php caniincasa_rating_stars( absint( $value ) ); ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php
                            endif;
                        }
                        ?>

                    </div><!-- .razza-single__content -->

                    <!-- Sidebar -->
                    <aside class="razza-single__sidebar">

                        <!-- Caratteristiche Fisiche -->
                        <div class="info-box">
                            <h3 class="info-box__title">Caratteristiche Fisiche</h3>
                            <dl class="info-list">
                                <?php
                                $altezza_min_maschio = get_post_meta( get_the_ID(), 'altezza_minima_maschio', true );
                                $altezza_max_maschio = get_post_meta( get_the_ID(), 'altezza_massima_maschio', true );
                                if ( $altezza_min_maschio && $altezza_max_maschio ) :
                                ?>
                                    <dt>Altezza Maschio</dt>
                                    <dd><?php echo esc_html( $altezza_min_maschio . ' - ' . $altezza_max_maschio . ' cm' ); ?></dd>
                                <?php endif; ?>

                                <?php
                                $altezza_min_femmina = get_post_meta( get_the_ID(), 'altezza_minima_femmina', true );
                                $altezza_max_femmina = get_post_meta( get_the_ID(), 'altezza_massima_femmina', true );
                                if ( $altezza_min_femmina && $altezza_max_femmina ) :
                                ?>
                                    <dt>Altezza Femmina</dt>
                                    <dd><?php echo esc_html( $altezza_min_femmina . ' - ' . $altezza_max_femmina . ' cm' ); ?></dd>
                                <?php endif; ?>

                                <?php
                                $peso_min_maschio = get_post_meta( get_the_ID(), 'peso_minimo_maschio', true );
                                $peso_max_maschio = get_post_meta( get_the_ID(), 'peso_massimo_maschio', true );
                                if ( $peso_min_maschio && $peso_max_maschio ) :
                                ?>
                                    <dt>Peso Maschio</dt>
                                    <dd><?php echo esc_html( $peso_min_maschio . ' - ' . $peso_max_maschio . ' kg' ); ?></dd>
                                <?php endif; ?>

                                <?php
                                $peso_min_femmina = get_post_meta( get_the_ID(), 'peso_minimo_femmina', true );
                                $peso_max_femmina = get_post_meta( get_the_ID(), 'peso_massimo_femmina', true );
                                if ( $peso_min_femmina && $peso_max_femmina ) :
                                ?>
                                    <dt>Peso Femmina</dt>
                                    <dd><?php echo esc_html( $peso_min_femmina . ' - ' . $peso_max_femmina . ' kg' ); ?></dd>
                                <?php endif; ?>

                                <?php
                                $vita_min = get_post_meta( get_the_ID(), 'aspettativa_di_vita_minima', true );
                                $vita_max = get_post_meta( get_the_ID(), 'aspettativa_di_vita_massima', true );
                                if ( $vita_min && $vita_max ) :
                                ?>
                                    <dt>Aspettativa di Vita</dt>
                                    <dd><?php echo esc_html( $vita_min . ' - ' . $vita_max . ' anni' ); ?></dd>
                                <?php endif; ?>

                                <?php
                                $gruppo = get_post_meta( get_the_ID(), 'gruppo_razza', true );
                                if ( $gruppo ) :
                                ?>
                                    <dt>Gruppo FCI</dt>
                                    <dd><?php echo esc_html( $gruppo ); ?></dd>
                                <?php endif; ?>

                                <?php
                                $paese = get_post_meta( get_the_ID(), 'paese_origine', true );
                                if ( $paese ) :
                                ?>
                                    <dt>Paese d'Origine</dt>
                                    <dd><?php echo esc_html( $paese ); ?></dd>
                                <?php endif; ?>
                            </dl>
                        </div>

                        <!-- Allevamenti Collegati -->
                        <?php
                        $args = array(
                            'post_type'      => 'allevamenti',
                            'posts_per_page' => 5,
                            'tax_query'      => array(
                                array(
                                    'taxonomy' => 'razze_allevamenti',
                                    'field'    => 'slug',
                                    'terms'    => get_post_field( 'post_name', get_the_ID() ),
                                ),
                            ),
                        );

                        $allevamenti_query = new WP_Query( $args );

                        if ( $allevamenti_query->have_posts() ) :
                        ?>
                            <div class="info-box">
                                <h3 class="info-box__title">Allevamenti di <?php the_title(); ?></h3>
                                <ul class="related-list">
                                    <?php while ( $allevamenti_query->have_posts() ) : $allevamenti_query->the_post(); ?>
                                        <li>
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                            <?php
                                            $provincia = get_post_meta( get_the_ID(), 'provincia_', true );
                                            if ( $provincia ) :
                                                echo ' <span class="provincia">(' . esc_html( $provincia ) . ')</span>';
                                            endif;
                                            ?>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                                <a href="<?php echo esc_url( home_url( '/allevamenti/' ) ); ?>" class="btn btn-outline btn-block mt-3">
                                    Vedi tutti gli allevamenti
                                </a>
                            </div>
                        <?php
                        endif;
                        wp_reset_postdata();
                        ?>

                    </aside><!-- .razza-single__sidebar -->

                </div><!-- .razza-single__layout -->

                <!-- Related Content -->
                <?php
                $related = caniincasa_get_related_posts( get_the_ID(), 3 );
                if ( $related ) :
                ?>
                    <div class="related-posts">
                        <h2 class="related-posts__title">Altre Razze che Potrebbero Interessarti</h2>
                        <div class="grid grid-3">
                            <?php
                            while ( $related->have_posts() ) :
                                $related->the_post();
                                get_template_part( 'template-parts/content', 'razza-card' );
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div><!-- .container -->

        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
