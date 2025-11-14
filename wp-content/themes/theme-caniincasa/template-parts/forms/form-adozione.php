<?php
/**
 * Form Adozione
 * Form per inserire annuncio di adozione
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
        <h2 class="form-title">Cane in Adozione</h2>
        <p class="form-subtitle">Aiuta un cane a trovare una famiglia amorevole</p>
    </div>

    <form id="adozione-form" class="annuncio-form" enctype="multipart/form-data">
        <?php wp_nonce_field( 'caniincasa_submit_adozione', 'adozione_nonce' ); ?>

        <div class="form-section">
            <h3 class="section-title">Informazioni Cane</h3>

            <div class="form-group">
                <label for="nome_cane">Nome del Cane *</label>
                <input type="text" id="nome_cane" name="nome_cane" required
                       placeholder="Es: Bobby, Luna, Rex...">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="razza">Razza *</label>
                    <input type="text" id="razza" name="razza" required
                           placeholder="Es: Pastore Tedesco, Meticcio, etc.">
                </div>

                <div class="form-group">
                    <label for="sesso">Sesso *</label>
                    <select id="sesso" name="sesso" required>
                        <option value="">Seleziona</option>
                        <option value="maschio">Maschio</option>
                        <option value="femmina">Femmina</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="eta_anni">Età (Anni)</label>
                    <input type="number" id="eta_anni" name="eta_anni" min="0" max="20" value="0">
                </div>

                <div class="form-group">
                    <label for="eta_mesi">Età (Mesi)</label>
                    <input type="number" id="eta_mesi" name="eta_mesi" min="0" max="11" value="0">
                    <small>Lascia 0 se non sai l'età esatta</small>
                </div>

                <div class="form-group">
                    <label for="taglia">Taglia *</label>
                    <select id="taglia" name="taglia" required>
                        <option value="">Seleziona</option>
                        <option value="piccola">Piccola</option>
                        <option value="media">Media</option>
                        <option value="grande">Grande</option>
                        <option value="gigante">Gigante</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">Salute e Comportamento</h3>

            <div class="form-row">
                <div class="form-group">
                    <label for="microchip">Microchip *</label>
                    <select id="microchip" name="microchip" required>
                        <option value="">Seleziona</option>
                        <option value="si">Sì</option>
                        <option value="no">No</option>
                        <option value="da_fare">Da fare</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="sterilizzato">Sterilizzato *</label>
                    <select id="sterilizzato" name="sterilizzato" required>
                        <option value="">Seleziona</option>
                        <option value="si">Sì</option>
                        <option value="no">No</option>
                        <option value="da_fare">Da fare</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="vaccinato">Vaccinato *</label>
                    <select id="vaccinato" name="vaccinato" required>
                        <option value="">Seleziona</option>
                        <option value="si">Sì, completo</option>
                        <option value="parzialmente">Parzialmente</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Carattere e Compatibilità</label>
                <div class="checkbox-group-vertical">
                    <label class="checkbox-label-inline">
                        <input type="checkbox" name="compatibilita[]" value="bambini">
                        <span>Compatibile con bambini</span>
                    </label>
                    <label class="checkbox-label-inline">
                        <input type="checkbox" name="compatibilita[]" value="cani">
                        <span>Compatibile con altri cani</span>
                    </label>
                    <label class="checkbox-label-inline">
                        <input type="checkbox" name="compatibilita[]" value="gatti">
                        <span>Compatibile con gatti</span>
                    </label>
                    <label class="checkbox-label-inline">
                        <input type="checkbox" name="compatibilita[]" value="appartamento">
                        <span>Adatto alla vita in appartamento</span>
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label for="problemi_salute">Eventuali Problemi di Salute</label>
                <textarea id="problemi_salute" name="problemi_salute" rows="3"
                          placeholder="Descrivi eventuali problemi di salute, allergie, necessità di cure particolari..."></textarea>
                <small>Importante per trovare la famiglia adatta</small>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">Storia e Descrizione</h3>

            <div class="form-group">
                <label for="storia">Storia del Cane</label>
                <textarea id="storia" name="storia" rows="4"
                          placeholder="Come è arrivato da te, da quanto tempo lo hai, perché cerca una nuova casa..."></textarea>
            </div>

            <div class="form-group">
                <label for="carattere">Carattere *</label>
                <textarea id="carattere" name="carattere" rows="6" required
                          placeholder="Descrivi il carattere, le abitudini, cosa gli piace fare, come si comporta..."></textarea>
                <small>Aiuta i futuri proprietari a capire se è il cane giusto per loro</small>
            </div>

            <div class="form-group">
                <label for="requisiti_adottante">Requisiti per l'Adottante</label>
                <textarea id="requisiti_adottante" name="requisiti_adottante" rows="4"
                          placeholder="Es: Giardino recintato, esperienza con cani di taglia grande, disponibilità di tempo..."></textarea>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">Località</h3>

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
        </div>

        <div class="form-section">
            <h3 class="section-title">Foto *</h3>

            <div class="form-group">
                <label for="immagini">Carica Foto del Cane</label>
                <input type="file" id="immagini" name="immagini[]" multiple accept="image/*" required>
                <small class="form-help">Almeno 1 foto, massimo 5. Le foto aiutano molto a trovare una famiglia!</small>
                <div id="image-preview" class="image-preview-grid"></div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="terms" id="terms" required>
                    <span>Confermo che le informazioni fornite sono veritiere e accetto i <a href="/termini/" target="_blank">Termini e Condizioni</a></span>
                </label>
            </div>

            <div class="info-box success">
                <strong>❤️ Adozione Gratuita:</strong> Gli annunci di adozione sono completamente gratuiti.
                Il tuo annuncio sarà verificato e pubblicato entro 24-48 ore.
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
