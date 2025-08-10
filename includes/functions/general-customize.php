<?php

//ADICIONA CAMPO PARA UPLOAD DE LOGOTIPO NO CUSTOMIZER
function aer_customizer( $wp_customize ) {

  // Adiciona o Campo de Upload
  $wp_customize->add_setting( 'aer_logo' , array(
      'default'     => '',
      'transport'   => 'refresh',
  ) );

  $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'aer_logo', array(
      'label'      => "Upload do Logotipo",
      'section'    => 'title_tagline',
      'settings'   => 'aer_logo',
  ) ) );
}

add_action( 'customize_register', 'aer_customizer' );

?>