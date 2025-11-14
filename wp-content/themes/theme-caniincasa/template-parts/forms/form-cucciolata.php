<?php
/**
 * Form Cucciolata
 * Form per inserire annuncio di cucciolata
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
        <h2 class="form-title">Pubblica una Cucciolata</h2>
        <p class="form-subtitle">Compila il form per annunciare una cucciolata disponibile</p>
    </div>

    <form id="cucciolata-form" class="annuncio-form" enctype="multipart/form-data">
        <?php wp_nonce_field( 'caniincasa_submit_cucciolata', 'cucciolata_nonce' ); ?>

        <div class="form-section">
            <h3 class="section-title">Informazioni Generali</h3>

            <div class="form-group">
                <label for="titolo">Titolo Annuncio *</label>
                <input type="text" id="titolo" name="titolo" required
                       placeholder="Es: Cuccioli di Labrador Retriever disponibili">
                <small>Scegli un titolo chiaro e descrittivo</small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="razza">Razza *</label>
                    <select id="razza" name="razza" required>
                        <option value="">Seleziona una razza</option>
                        <?php
                        $razze = get_posts( array(
                            'post_type' => 'razze_di_cani',
                            'posts_per_page' => -1,
                            'orderby' => 'title',
                            'order' => 'ASC',
                        ) );

                        foreach ( $razze as $razza ):
                        ?>
                            <option value="<?php echo $razza->ID; ?>">
                                <?php echo esc_html( $razza->post_title ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="data_nascita">Data di Nascita Cuccioli *</label>
                    <input type="date" id="data_nascita" name="data_nascita" required>
                    <small>Data di nascita o prevista</small>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="numero_maschi">Numero Maschi</label>
                    <input type="number" id="numero_maschi" name="numero_maschi" min="0" value="0">
                </div>

                <div class="form-group">
                    <label for="numero_femmine">Numero Femmine</label>
                    <input type="number" id="numero_femmine" name="numero_femmine" min="0" value="0">
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">Dettagli</h3>

            <div class="form-row">
                <div class="form-group">
                    <label for="prezzo">Prezzo (€)</label>
                    <input type="number" id="prezzo" name="prezzo" min="0" step="50"
                           placeholder="Lascia vuoto se non specificato">
                </div>

                <div class="form-group">
                    <label for="pedigree">Pedigree</label>
                    <select id="pedigree" name="pedigree">
                        <option value="">Seleziona</option>
                        <option value="si">Sì</option>
                        <option value="no">No</option>
                        <option value="disponibile">Disponibile su richiesta</option>
                    </select>
                </div>
            </div>

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
                <label for="descrizione">Descrizione *</label>
                <textarea id="descrizione" name="descrizione" rows="8" required
                          placeholder="Descrivi la cucciolata, i genitori, eventuali caratteristiche particolari, test genetici effettuati, etc."></textarea>
                <small>Fornisci quante più informazioni possibili per aiutare i futuri proprietari</small>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">Foto</h3>

            <div class="form-group">
                <label for="immagini">Carica Foto</label>
                <input type="file" id="immagini" name="immagini[]" multiple accept="image/*">
                <small class="form-help">Puoi caricare fino a 5 immagini (max 2MB ciascuna). La prima foto sarà quella di copertina.</small>
                <div id="image-preview" class="image-preview-grid"></div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="terms" id="terms" required>
                    <span>Ho letto e accetto i <a href="/termini/" target="_blank">Termini e Condizioni</a> per la pubblicazione di annunci</span>
                </label>
            </div>

            <div class="info-box">
                <strong>Nota:</strong> Il tuo annuncio sarà sottoposto a moderazione prima della pubblicazione.
                Riceverai una notifica via email quando verrà approvato. Di solito la verifica richiede 24-48 ore.
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary btn-submit">
                <span class="btn-text">Pubblica Annuncio</span>
                <span class="btn-loading" style="display:none;">
                    <span class="spinner"></span> Invio in corso...
                </span>
            </button>
            <a href="<?php echo esc_url( remove_query_arg( 'tipo' ) ); ?>" class="btn btn-outline">Annulla</a>
        </div>

        <div class="form-message" id="form-message" style="display:none;"></div>
    </form>
</div>
