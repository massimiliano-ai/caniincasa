<?php
/**
 * Form Allevamento
 * Form per registrare un allevamento
 *
 * @package CaninCasa
 * @since 2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="form-container">
    <div class="form-header">
        <a href="<?php echo esc_url( remove_query_arg( 'tipo' ) ); ?>" class="back-link">
            ← Torna alla selezione
        </a>
        <h2 class="form-title">Registra il tuo Allevamento</h2>
        <p class="form-subtitle">Inserisci il tuo allevamento nella nostra directory</p>
    </div>

    <form id="allevamento-form" class="annuncio-form" enctype="multipart/form-data">
        <?php wp_nonce_field( 'caniincasa_submit_allevamento', 'allevamento_nonce' ); ?>

        <div class="form-section">
            <h3 class="section-title">Informazioni Generali</h3>

            <div class="form-group">
                <label for="nome_allevamento">Nome Allevamento *</label>
                <input type="text" id="nome_allevamento" name="nome_allevamento" required
                       placeholder="Es: Allevamento Del Bosco Incantato">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="affisso_enci">Affisso ENCI</label>
                    <input type="text" id="affisso_enci" name="affisso_enci"
                           placeholder="Se presente">
                </div>

                <div class="form-group">
                    <label for="anno_fondazione">Anno di Fondazione</label>
                    <input type="number" id="anno_fondazione" name="anno_fondazione"
                           min="1900" max="<?php echo date('Y'); ?>"
                           placeholder="<?php echo date('Y'); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="descrizione">Descrizione Allevamento *</label>
                <textarea id="descrizione" name="descrizione" rows="6" required
                          placeholder="Descrivi il tuo allevamento, la tua esperienza, la filosofia di allevamento..."></textarea>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">Razze Allevate</h3>

            <div class="form-group">
                <label>Seleziona le Razze Allevate *</label>
                <div class="razze-selection">
                    <?php
                    $razze_allevamenti = get_terms( array(
                        'taxonomy' => 'razze_allevamenti',
                        'hide_empty' => false,
                        'orderby' => 'name',
                        'order' => 'ASC',
                    ) );

                    if ( ! empty( $razze_allevamenti ) && ! is_wp_error( $razze_allevamenti ) ):
                        $count = 0;
                        foreach ( $razze_allevamenti as $razza ):
                            if ( $count % 3 === 0 ) echo '<div class="checkbox-row">';
                    ?>
                            <label class="checkbox-label-inline">
                                <input type="checkbox" name="razze_allevate[]" value="<?php echo $razza->term_id; ?>">
                                <span><?php echo esc_html( $razza->name ); ?></span>
                            </label>
                    <?php
                            $count++;
                            if ( $count % 3 === 0 || $count === count( $razze_allevamenti ) ) echo '</div>';
                        endforeach;
                    else:
                    ?>
                        <p class="form-help">Seleziona almeno una razza</p>
                    <?php endif; ?>
                </div>
                <small>Seleziona tutte le razze che allevi</small>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">Contatti e Indirizzo</h3>

            <div class="form-row">
                <div class="form-group">
                    <label for="provincia">Provincia *</label>
                    <select id="provincia" name="provincia" required>
                        <option value="">Seleziona provincia</option>
                        <?php
                        $province = get_terms( array(
                            'taxonomy' => 'provincia',
                            'hide_empty' => false,
                            'orderby' => 'name',
                            'order' => 'ASC',
                        ) );

                        foreach ( $province as $provincia ):
                        ?>
                            <option value="<?php echo $provincia->term_id; ?>">
                                <?php echo esc_html( $provincia->name ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="citta">Città *</label>
                    <input type="text" id="citta" name="citta" required>
                </div>
            </div>

            <div class="form-group">
                <label for="indirizzo">Indirizzo</label>
                <input type="text" id="indirizzo" name="indirizzo"
                       placeholder="Via, numero civico (opzionale)">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="telefono">Telefono *</label>
                    <input type="tel" id="telefono" name="telefono" required
                           placeholder="+39 ...">
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required
                           value="<?php echo esc_attr( wp_get_current_user()->user_email ); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="sito_web">Sito Web</label>
                <input type="url" id="sito_web" name="sito_web"
                       placeholder="https://www.tuosito.it">
            </div>

            <div class="form-group">
                <label for="facebook">Pagina Facebook</label>
                <input type="url" id="facebook" name="facebook"
                       placeholder="https://facebook.com/tuapagina">
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">Certificazioni e Riconoscimenti</h3>

            <div class="form-group">
                <label>Certificazioni</label>
                <div class="checkbox-group-vertical">
                    <label class="checkbox-label-inline">
                        <input type="checkbox" name="certificazioni[]" value="enci">
                        <span>Riconosciuto ENCI</span>
                    </label>
                    <label class="checkbox-label-inline">
                        <input type="checkbox" name="certificazioni[]" value="fci">
                        <span>Riconosciuto FCI</span>
                    </label>
                    <label class="checkbox-label-inline">
                        <input type="checkbox" name="certificazioni[]" value="club_razza">
                        <span>Iscritto al Club di Razza</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="test_genetici">Test Genetici Effettuati</label>
                <textarea id="test_genetici" name="test_genetici" rows="3"
                          placeholder="Elenca i test genetici che effettui sui tuoi riproduttori"></textarea>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">Foto</h3>

            <div class="form-group">
                <label for="immagini">Foto Allevamento e Cani</label>
                <input type="file" id="immagini" name="immagini[]" multiple accept="image/*">
                <small class="form-help">Carica foto del tuo allevamento, dei riproduttori, delle strutture (max 5 foto)</small>
                <div id="image-preview" class="image-preview-grid"></div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="terms" id="terms" required>
                    <span>Confermo di essere il proprietario dell'allevamento e accetto i <a href="/termini/" target="_blank">Termini e Condizioni</a></span>
                </label>
            </div>

            <div class="info-box">
                <strong>Nota:</strong> La registrazione del tuo allevamento è soggetta a verifica.
                Potrebbe essere necessario fornire documentazione che attesti l'affisso ENCI o altre certificazioni.
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-submit">
                <span class="btn-text">Registra Allevamento</span>
                <span class="btn-loading" style="display:none;">
                    <span class="spinner"></span> Invio in corso...
                </span>
            </button>
            <a href="<?php echo esc_url( remove_query_arg( 'tipo' ) ); ?>" class="btn btn-outline">Annulla</a>
        </div>

        <div class="form-message" id="form-message" style="display:none;"></div>
    </form>
</div>
