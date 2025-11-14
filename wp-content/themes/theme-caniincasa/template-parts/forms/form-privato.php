<?php
/**
 * Form Annuncio Privato
 * Form per inserire annuncio privato
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
        <h2 class="form-title">Inserisci Annuncio Privato</h2>
        <p class="form-subtitle">Vendi o cerca un nuovo padrone per il tuo cane</p>
    </div>

    <form id="privato-form" class="annuncio-form" enctype="multipart/form-data">
        <?php wp_nonce_field( 'caniincasa_submit_privato', 'privato_nonce' ); ?>

        <div class="form-section">
            <h3 class="section-title">Tipo di Annuncio</h3>

            <div class="form-group">
                <label>Tipologia *</label>
                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="tipo_annuncio" value="vendita" required>
                        <span>Vendita cucciolo/cane</span>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="tipo_annuncio" value="cessione" required>
                        <span>Cessione gratuita (cambio proprietà)</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">Informazioni Cane</h3>

            <div class="form-group">
                <label for="titolo">Titolo Annuncio *</label>
                <input type="text" id="titolo" name="titolo" required
                       placeholder="Es: Splendido Cucciolo di Golden Retriever">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="razza">Razza *</label>
                    <input type="text" id="razza" name="razza" required
                           placeholder="Es: Labrador Retriever, Meticcio, etc.">
                    <small>Specifica la razza o scrivi "Meticcio"</small>
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
                </div>

                <div class="form-group">
                    <label for="taglia">Taglia *</label>
                    <select id="taglia" name="taglia" required>
                        <option value="">Seleziona</option>
                        <option value="piccola">Piccola (fino a 10kg)</option>
                        <option value="media">Media (10-25kg)</option>
                        <option value="grande">Grande (25-45kg)</option>
                        <option value="gigante">Gigante (oltre 45kg)</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="pedigree">Pedigree</label>
                    <select id="pedigree" name="pedigree">
                        <option value="">Seleziona</option>
                        <option value="si">Sì</option>
                        <option value="no">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="microchip">Microchip</label>
                    <select id="microchip" name="microchip">
                        <option value="">Seleziona</option>
                        <option value="si">Sì</option>
                        <option value="no">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="vaccinato">Vaccinato</label>
                    <select id="vaccinato" name="vaccinato">
                        <option value="">Seleziona</option>
                        <option value="si">Sì</option>
                        <option value="parzialmente">Parzialmente</option>
                        <option value="no">No</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">Prezzo e Località</h3>

            <div class="form-row">
                <div class="form-group">
                    <label for="prezzo">Prezzo (€) *</label>
                    <input type="number" id="prezzo" name="prezzo" min="0" step="10" required>
                    <small>Inserisci 0 per cessione gratuita</small>
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
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">Descrizione</h3>

            <div class="form-group">
                <label for="descrizione">Descrizione Dettagliata *</label>
                <textarea id="descrizione" name="descrizione" rows="8" required
                          placeholder="Descrivi il carattere, le abitudini, eventuali necessità particolari, motivo della cessione, etc."></textarea>
                <small>Più informazioni fornisci, più facile sarà trovare la persona giusta</small>
            </div>
        </div>

        <div class="form-section">
            <h3 class="section-title">Foto</h3>

            <div class="form-group">
                <label for="immagini">Carica Foto *</label>
                <input type="file" id="immagini" name="immagini[]" multiple accept="image/*" required>
                <small class="form-help">Almeno 1 foto, massimo 5 (max 2MB ciascuna)</small>
                <div id="image-preview" class="image-preview-grid"></div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="terms" id="terms" required>
                    <span>Ho letto e accetto i <a href="/termini/" target="_blank">Termini e Condizioni</a></span>
                </label>
            </div>

            <div class="info-box">
                <strong>Importante:</strong> Il tuo annuncio sarà sottoposto a moderazione.
                Assicurati di fornire informazioni veritiere e foto recenti del cane.
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
