<?php
/**
 * Custom Fields Configuration (ACF)
 *
 * This file contains ACF field group registrations
 * Requires Advanced Custom Fields PRO plugin
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
 * Razze di Cani - Caratteristiche con Rating 1-5
 * Sistema di valutazione visuale con zampette
 */
acf_add_local_field_group( array(
    'key' => 'group_razze_caratteristiche_rating',
    'title' => 'Caratteristiche Razza - Sistema Rating',
    'fields' => array(

        // ========================================
        // TAB 1: Temperamento & Comportamento
        // ========================================
        array(
            'key' => 'field_tab_temperamento',
            'label' => 'Temperamento',
            'name' => '',
            'type' => 'tab',
            'placement' => 'left',
        ),

        array(
            'key' => 'field_livello_energia',
            'label' => 'Livello Energia',
            'name' => 'livello_energia',
            'type' => 'range',
            'instructions' => '1 = Molto basso (es. Bulldog) | 5 = Molto alto (es. Border Collie)',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_affettuosita',
            'label' => 'Affettuosità',
            'name' => 'affettuosita',
            'type' => 'range',
            'instructions' => '1 = Indipendente | 5 = Molto affettuoso (es. Golden Retriever)',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_vocalita',
            'label' => 'Vocalità / Tendenza ad Abbaiare',
            'name' => 'vocalita',
            'type' => 'range',
            'instructions' => '1 = Molto silenzioso (es. Basenji) | 5 = Abbaia molto (es. Beagle)',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_socievolezza_cani',
            'label' => 'Socievolezza con Altri Cani',
            'name' => 'socievolezza_cani',
            'type' => 'range',
            'instructions' => '1 = Preferisce essere unico | 5 = Ama altri cani',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        // ========================================
        // TAB 2: Adattabilità
        // ========================================
        array(
            'key' => 'field_tab_adattabilita',
            'label' => 'Adattabilità',
            'name' => '',
            'type' => 'tab',
            'placement' => 'left',
        ),

        array(
            'key' => 'field_adattabilita_appartamento',
            'label' => 'Adattabilità Appartamento',
            'name' => 'adattabilita_appartamento',
            'type' => 'range',
            'instructions' => '1 = Necessita spazio esterno | 5 = Perfetto per appartamento',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_tolleranza_caldo',
            'label' => 'Tolleranza al Caldo',
            'name' => 'tolleranza_caldo',
            'type' => 'range',
            'instructions' => '1 = Soffre molto il caldo (es. Husky) | 5 = Tollera bene',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_tolleranza_freddo',
            'label' => 'Tolleranza al Freddo',
            'name' => 'tolleranza_freddo',
            'type' => 'range',
            'instructions' => '1 = Soffre il freddo (es. Chihuahua) | 5 = Ama il freddo (es. Malamute)',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        // ========================================
        // TAB 3: Famiglia & Socialità
        // ========================================
        array(
            'key' => 'field_tab_famiglia',
            'label' => 'Famiglia & Socialità',
            'name' => '',
            'type' => 'tab',
            'placement' => 'left',
        ),

        array(
            'key' => 'field_compatibilita_bambini',
            'label' => 'Compatibilità con Bambini',
            'name' => 'compatibilita_bambini',
            'type' => 'range',
            'instructions' => '1 = Non adatto | 5 = Eccellente con bambini (es. Labrador)',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_tolleranza_estranei',
            'label' => 'Tolleranza verso Estranei',
            'name' => 'tolleranza_estranei',
            'type' => 'range',
            'instructions' => '1 = Diffidente/protettivo | 5 = Amichevole con tutti',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_compatibilita_altri_animali',
            'label' => 'Compatibilità Altri Animali',
            'name' => 'compatibilita_altri_animali',
            'type' => 'range',
            'instructions' => '1 = Difficile con gatti/piccoli animali | 5 = Va d\'accordo con tutti',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        // ========================================
        // TAB 4: Addestramento & Cura
        // ========================================
        array(
            'key' => 'field_tab_addestramento',
            'label' => 'Addestramento & Cura',
            'name' => '',
            'type' => 'tab',
            'placement' => 'left',
        ),

        array(
            'key' => 'field_facilita_addestramento',
            'label' => 'Facilità Addestramento',
            'name' => 'facilita_addestramento',
            'type' => 'range',
            'instructions' => '1 = Testardo/difficile | 5 = Facile da addestrare (es. Border Collie)',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_intelligenza',
            'label' => 'Intelligenza / Problem Solving',
            'name' => 'intelligenza',
            'type' => 'range',
            'instructions' => '1 = Segue più l\'istinto | 5 = Molto intelligente',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_bisogno_esercizio',
            'label' => 'Bisogno di Esercizio Fisico',
            'name' => 'bisogno_esercizio',
            'type' => 'range',
            'instructions' => '1 = Poche passeggiate brevi | 5 = Necessita sport intenso quotidiano',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_facilita_toelettatura',
            'label' => 'Facilità Toelettatura',
            'name' => 'facilita_toelettatura',
            'type' => 'range',
            'instructions' => '1 = Richiede toelettatura professionale frequente | 5 = Manutenzione minima',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_perdita_pelo',
            'label' => 'Perdita Pelo',
            'name' => 'perdita_pelo',
            'type' => 'range',
            'instructions' => '1 = Minima (es. Barboncino) | 5 = Perde molto pelo (es. Husky)',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        // ========================================
        // TAB 5: Esperienza & Costi
        // ========================================
        array(
            'key' => 'field_tab_esperienza',
            'label' => 'Esperienza & Costi',
            'name' => '',
            'type' => 'tab',
            'placement' => 'left',
        ),

        array(
            'key' => 'field_livello_esperienza_richiesto',
            'label' => 'Livello Esperienza Richiesto',
            'name' => 'livello_esperienza_richiesto',
            'type' => 'range',
            'instructions' => '1 = Perfetto per principianti | 5 = Solo padroni esperti (es. Akita)',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),

        array(
            'key' => 'field_costo_mantenimento',
            'label' => 'Costo Mantenimento',
            'name' => 'costo_mantenimento',
            'type' => 'range',
            'instructions' => '1 = Economico | 5 = Costoso (cibo, cure, toelettatura)',
            'default_value' => 3,
            'min' => 1,
            'max' => 5,
            'step' => 0.5,
            'append' => '/5',
        ),
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
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'left',
    'instruction_placement' => 'field',
    'active' => true,
) );

/**
 * Helper function to get rating label text
 */
function caniincasa_get_rating_label( $field_name, $value ) {
    $labels = array(
        'livello_energia' => array(
            1 => 'Molto basso',
            2 => 'Basso',
            3 => 'Medio',
            4 => 'Alto',
            5 => 'Molto alto',
        ),
        'affettuosita' => array(
            1 => 'Indipendente',
            2 => 'Poco affettuoso',
            3 => 'Moderatamente affettuoso',
            4 => 'Affettuoso',
            5 => 'Molto affettuoso',
        ),
        'adattabilita_appartamento' => array(
            1 => 'Non adatto',
            2 => 'Poco adatto',
            3 => 'Si adatta',
            4 => 'Adatto',
            5 => 'Perfetto',
        ),
        'compatibilita_bambini' => array(
            1 => 'Non adatto',
            2 => 'Con supervisione',
            3 => 'Adatto',
            4 => 'Ottimo',
            5 => 'Eccellente',
        ),
        'facilita_addestramento' => array(
            1 => 'Molto difficile',
            2 => 'Difficile',
            3 => 'Media',
            4 => 'Facile',
            5 => 'Molto facile',
        ),
        'livello_esperienza_richiesto' => array(
            1 => 'Principianti',
            2 => 'Principianti+',
            3 => 'Intermedio',
            4 => 'Avanzato',
            5 => 'Esperti',
        ),
    );

    $rounded = round( $value );

    if ( isset( $labels[ $field_name ][ $rounded ] ) ) {
        return $labels[ $field_name ][ $rounded ];
    }

    return '';
}
