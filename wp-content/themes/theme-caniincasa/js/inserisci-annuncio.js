/**
 * Inserisci Annuncio JavaScript
 * Handles form submissions for all ad types
 *
 * @package CaninCasa
 * @since 2.0.0
 */

(function($) {
    'use strict';

    /**
     * Image Preview Handler
     */
    function handleImagePreview(input) {
        const previewContainer = $('#image-preview');
        previewContainer.empty();

        if (input.files && input.files.length > 0) {
            const maxFiles = 5;
            const fileCount = Math.min(input.files.length, maxFiles);

            for (let i = 0; i < fileCount; i++) {
                const file = input.files[i];

                if (file.type.match('image.*')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const preview = $('<div class="image-preview"></div>');
                        const img = $('<img>').attr('src', e.target.result);
                        const removeBtn = $('<button type="button" class="image-preview-remove">&times;</button>');

                        removeBtn.on('click', function() {
                            preview.remove();
                        });

                        preview.append(img).append(removeBtn);
                        previewContainer.append(preview);
                    };

                    reader.readAsDataURL(file);
                }
            }

            if (input.files.length > maxFiles) {
                alert('Puoi caricare massimo ' + maxFiles + ' immagini. Solo le prime ' + maxFiles + ' saranno utilizzate.');
            }
        }
    }

    /**
     * Handle Form Submission
     */
    function handleFormSubmit(formId, actionName) {
        const form = $('#' + formId);

        if (form.length === 0) {
            return;
        }

        form.on('submit', function(e) {
            e.preventDefault();

            const submitBtn = form.find('.btn-submit');
            const btnText = submitBtn.find('.btn-text');
            const btnLoading = submitBtn.find('.btn-loading');
            const messageBox = $('#form-message');

            // Disable submit button
            submitBtn.prop('disabled', true);
            btnText.hide();
            btnLoading.show();

            // Prepare form data
            const formData = new FormData(this);
            formData.append('action', actionName);

            // Get the appropriate nonce
            const nonceKey = actionName.replace('caniincasa_ajax_submit_', '');
            if (typeof annuncioData !== 'undefined' && annuncioData.nonces[nonceKey]) {
                formData.append('nonce', annuncioData.nonces[nonceKey]);
            }

            // AJAX request
            $.ajax({
                url: annuncioData.ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        messageBox
                            .removeClass('error info')
                            .addClass('success')
                            .html(response.data.message)
                            .fadeIn();

                        // Reset form
                        form[0].reset();
                        $('#image-preview').empty();

                        // Redirect after 2 seconds
                        if (response.data.redirect) {
                            setTimeout(function() {
                                window.location.href = response.data.redirect;
                            }, 2000);
                        }
                    } else {
                        // Show error message
                        messageBox
                            .removeClass('success info')
                            .addClass('error')
                            .html(response.data.message || 'Si è verificato un errore. Riprova.')
                            .fadeIn();

                        // Re-enable submit button
                        submitBtn.prop('disabled', false);
                        btnText.show();
                        btnLoading.hide();
                    }
                },
                error: function(xhr, status, error) {
                    // Show error message
                    messageBox
                        .removeClass('success info')
                        .addClass('error')
                        .html('Errore di connessione. Riprova più tardi.')
                        .fadeIn();

                    // Re-enable submit button
                    submitBtn.prop('disabled', false);
                    btnText.show();
                    btnLoading.hide();

                    console.error('AJAX Error:', error);
                }
            });
        });
    }

    /**
     * Initialize on Document Ready
     */
    $(document).ready(function() {

        // Image preview for all file inputs
        $('input[type="file"][name="immagini[]"]').on('change', function() {
            handleImagePreview(this);
        });

        // Handle form submissions for each type
        handleFormSubmit('cucciolata-form', 'caniincasa_ajax_submit_cucciolata');
        handleFormSubmit('privato-form', 'caniincasa_ajax_submit_privato');
        handleFormSubmit('adozione-form', 'caniincasa_ajax_submit_adozione');
        handleFormSubmit('allevamento-form', 'caniincasa_ajax_submit_allevamento');

        // Smooth scroll to form on page load if tipo parameter is present
        if (window.location.search.includes('tipo=')) {
            $('html, body').animate({
                scrollTop: $('.form-container').offset().top - 100
            }, 500);
        }
    });

})(jQuery);
