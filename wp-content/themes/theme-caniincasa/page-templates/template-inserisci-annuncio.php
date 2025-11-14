<?php
/**
 * Template Name: Inserisci Annuncio
 * Template Post Type: page
 *
 * @package CaninCasa
 * @since 2.0.0
 */

// Redirect if not logged in
if ( ! is_user_logged_in() ) {
    wp_redirect( home_url( '/registrati/' ) );
    exit;
}

get_header();

$current_user = wp_get_current_user();
$form_type = isset( $_GET['tipo'] ) ? sanitize_text_field( $_GET['tipo'] ) : '';
?>

<main id="main-content" class="site-main page-inserisci-annuncio">

    <div class="container">

        <?php caniincasa_breadcrumbs(); ?>

        <?php if ( empty( $form_type ) ): ?>
            <!-- Selezione Tipo Annuncio -->
            <div class="annuncio-selection">

                <div class="page-header">
                    <h1 class="page-title">Inserisci il tuo annuncio</h1>
                    <p class="page-subtitle">Scegli il tipo di annuncio che vuoi pubblicare</p>
                </div>

                <div class="annuncio-types-grid">

                    <!-- Cucciolate -->
                    <a href="?tipo=cucciolata" class="annuncio-type-card">
                        <div class="card-icon">🐾</div>
                        <h3 class="card-title">Cucciolata Disponibile</h3>
                        <p class="card-description">
                            Annuncia una cucciolata in arrivo o disponibile.
                            Ideale per allevatori professionisti.
                        </p>
                        <div class="card-features">
                            <span class="feature">✓ Informazioni razza</span>
                            <span class="feature">✓ Data nascita</span>
                            <span class="feature">✓ Galleria foto</span>
                            <span class="feature">✓ Pedigree</span>
                        </div>
                        <span class="card-cta">Inserisci Cucciolata →</span>
                    </a>

                    <!-- Allevamento -->
                    <a href="?tipo=allevamento" class="annuncio-type-card">
                        <div class="card-icon">🏠</div>
                        <h3 class="card-title">Registra il tuo Allevamento</h3>
                        <p class="card-description">
                            Registra il tuo allevamento nella nostra directory.
                            Aumenta la tua visibilità online.
                        </p>
                        <div class="card-features">
                            <span class="feature">✓ Scheda dettagliata</span>
                            <span class="feature">✓ Razze allevate</span>
                            <span class="feature">✓ Contatti e mappa</span>
                            <span class="feature">✓ Certificazioni</span>
                        </div>
                        <span class="card-cta">Registra Allevamento →</span>
                    </a>

                    <!-- Privato -->
                    <a href="?tipo=privato" class="annuncio-type-card">
                        <div class="card-icon">👤</div>
                        <h3 class="card-title">Annuncio Privato</h3>
                        <p class="card-description">
                            Vendi cuccioli da privato o cerca un nuovo padrone
                            per il tuo amico a quattro zampe.
                        </p>
                        <div class="card-features">
                            <span class="feature">✓ Vendita cuccioli</span>
                            <span class="feature">✓ Cambio proprietà</span>
                            <span class="feature">✓ Foto e descrizione</span>
                            <span class="feature">✓ Contatto diretto</span>
                        </div>
                        <span class="card-cta">Inserisci Annuncio →</span>
                    </a>

                    <!-- Adozione -->
                    <a href="?tipo=adozione" class="annuncio-type-card featured">
                        <div class="card-icon">❤️</div>
                        <h3 class="card-title">Cane in Adozione</h3>
                        <p class="card-description">
                            Aiuta un cane a trovare una famiglia.
                            Pubblica un annuncio di adozione gratuito.
                        </p>
                        <div class="card-features">
                            <span class="feature">✓ 100% Gratuito</span>
                            <span class="feature">✓ Informazioni cane</span>
                            <span class="feature">✓ Storia e carattere</span>
                            <span class="feature">✓ Requisiti adozione</span>
                        </div>
                        <span class="card-cta">Inserisci Adozione →</span>
                        <div class="card-badge">Gratuito</div>
                    </a>

                </div>

                <!-- Info Box -->
                <div class="submission-info">
                    <div class="info-icon">ℹ️</div>
                    <div class="info-content">
                        <h4>Prima di pubblicare</h4>
                        <ul>
                            <li>Tutti gli annunci sono soggetti a moderazione</li>
                            <li>Riceverai una email quando il tuo annuncio verrà approvato</li>
                            <li>Assicurati di fornire informazioni complete e veritiere</li>
                            <li>Le foto di qualità aumentano le possibilità di contatto</li>
                        </ul>
                    </div>
                </div>

            </div>

        <?php elseif ( $form_type === 'cucciolata' ): ?>
            <!-- Form Cucciolata -->
            <?php include( locate_template( 'template-parts/forms/form-cucciolata.php' ) ); ?>

        <?php elseif ( $form_type === 'allevamento' ): ?>
            <!-- Form Allevamento -->
            <?php include( locate_template( 'template-parts/forms/form-allevamento.php' ) ); ?>

        <?php elseif ( $form_type === 'privato' ): ?>
            <!-- Form Privato -->
            <?php include( locate_template( 'template-parts/forms/form-privato.php' ) ); ?>

        <?php elseif ( $form_type === 'adozione' ): ?>
            <!-- Form Adozione -->
            <?php include( locate_template( 'template-parts/forms/form-adozione.php' ) ); ?>

        <?php endif; ?>

    </div>

</main>

<?php get_footer(); ?>
