<?php

namespace SharedVision\Builders\Elementor;

use Elementor\Controls_Manager;
use SharedVision\Helper\Lists as SharedVision_Helper_Lists;
use SharedVision\Template as SharedVision_Template;

class Embed extends \Elementor\Widget_Base{

  public function __construct($data = [], $args = null){
    parent::__construct($data, $args);
  }

  public function get_name(){
    return 'sharedvision-embed';
  }

  public function get_title(){
    return sprintf( __('%s - Embed', 'sharedvision'), SHARED_VISION_NAME );
  }

  public function get_categories(){
    return [ 'basic' ];
  }

  protected function register_controls(){
    $this->start_controls_section( 'section_settings_sharedvision_embed', [
      'label' => __( 'Settings', 'sharedvision' ),
    ] );

    $list_assoc = SharedVision_Helper_Lists::assoc_list( 'hash', 'name', false );

    if( empty( $list_assoc ) ) {
      $this->add_control('sharedvision_warning', [
        'type'  => Controls_Manager::RAW_HTML,
        'raw'   => '<p>' . __( "Shared Vision, cannot retrieve lists, please ensure API credentials are set.", 'sharedvision' ) . '</p>' .
                   '<a target="_blank" class="elementor-button elementor-button-success" href="' . esc_url( admin_url( 'options-general.php?page=sharedvision-settings' ) ) . '" style="padding: 5px;margin: 10px 0 0 0;">' .
                      esc_html( sprintf( __( "%s Settings >", 'sharedvision' ), SHARED_VISION_NAME ) ) .
                   '</a>'
      ]);
    } else {
      $this->add_control( 'list_hash', [
          'label'   => __( "List", "sharedvision" ),
          'type'    => 'select',
          'options' => $list_assoc,
          'default' => array_key_first( $list_assoc )
      ] );
    }

    $this->end_controls_section();
  }

  protected function render(){
    $settings = $this->get_settings_for_display();

    if( !isset( $settings[ 'list_hash' ] ) || empty( $settings[ 'list_hash' ] ) )
      return;

    \SharedVision\Helper\Embed::script_load();

    echo SharedVision_Template::get_template( 'embed.php', [
      'list_hash' => $settings[ 'list_hash' ]
    ] );
  }
}