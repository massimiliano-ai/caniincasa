<?php
/**
 * Custom Fields Configuration (ACF)
 *
 * This file will contain ACF field group registrations
 * Install Advanced Custom Fields PRO plugin first
 *
 * @package CaninCasa
 * @since 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Check if ACF is active
 */
if ( ! function_exists( 'acf_add_local_field_group' ) ) {
    return;
}

/**
 * Register Field Groups
 *
 * Field groups will be added here after ACF PRO is installed
 * Each CPT will have its dedicated field group
 */

// TODO: Add ACF field groups for:
// 1. Razze di Cani - Caratteristiche fisiche e caratteriali
// 2. Allevamenti - Informazioni contatto e dettagli
// 3. Strutture Veterinarie - Orari, servizi, contatti
// 4. Annunci Dogsitter - Disponibilità e tariffe
// 5. Annunci Cucciolate - Dettagli cucciolata
// 6. Canili - Informazioni struttura
// 7. Centri Cinofili - Corsi e istruttori
// 8. Pensioni - Servizi e tariffe

/**
 * Example ACF Field Group Registration
 * Uncomment and customize after installing ACF PRO
 */

/*
acf_add_local_field_group( array(
    'key' => 'group_razze_caratteristiche',
    'title' => 'Caratteristiche Razza',
    'fields' => array(
        array(
            'key' => 'field_altezza_minima_maschio',
            'label' => 'Altezza Minima Maschio (cm)',
            'name' => 'altezza_minima_maschio',
            'type' => 'number',
            'min' => 0,
            'max' => 200,
        ),
        // Add more fields here
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'razze_di_cani',
            ),
        ),
    ),
) );
*/
