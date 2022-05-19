<?php

/**
 * Implements styles set in the theme customizer
 *
 * @package Customizer Library WooCommerce Designer
 */
if ( !function_exists( 'comment_customize_style_build' ) && class_exists( 'comment_customize_style_library_Styles' ) ) {
    /**
     * Process user options to generate CSS needed to implement the choices.
     *
     * @since  1.0.0.
     *
     * @return void
     */
    function comment_customize_style_build()
    {


        /** Customize Add to Cart Button CSS Start */
        // Button - Font Size
        $gclacc_comment_box_options = get_option('gclacc_comment_box_options');
        

        


        comment_customize_style_library_Styles()->add( array(
            'selectors'    => array( '.comment-author-label-administrator' ),
            'declarations' => array(
                'color' => 'red',
                'font-size' => '10px !important'
            ),
        ) );
    
    }

}
add_action( 'customizer_library_styles', 'comment_customize_style_build' );
if ( !function_exists( 'woocustomizer_customizer_library_styles' ) ) {
    /**
     * Generates the style tag and CSS needed for the theme options.
     *
     * By using the "comment_customize_style_library_Styles" filter, different components can print CSS in the header.
     * It is organized this way to ensure there is only one "style" tag.
     *
     * @since  1.0.0.
     *
     * @return void
     */
    function woocustomizer_customizer_library_styles()
    {
        do_action( 'customizer_library_styles' );
        // Echo the rules
        $css = comment_customize_style_library_Styles()->build();
        
        if ( !empty($css) ) {
            wp_register_style( 'gclacc-customizer-custom-css', false );
            wp_enqueue_style( 'gclacc-customizer-custom-css' );
            wp_add_inline_style( 'gclacc-customizer-custom-css', $css );
        }
    
    }

}
add_action( 'wp_enqueue_scripts', 'woocustomizer_customizer_library_styles', 11 );



function gclacc_sanitize_hex_color( $color ) {
	if ( '' === $color ) {
		return '';
	}

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
		return $color;
	}

	return null;
}
?>