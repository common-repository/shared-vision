<?php

namespace SharedVision;

use SharedVision\Template as SharedVision_Template;

class Controller {

  /**
   * @var null|Controller;
   */
  protected static ?Controller $_instance = null;

  /**
   * @return Controller
   */
  public static function instance(): Controller {
    if( self::$_instance === null )
      self::$_instance = new self();

    return self::$_instance;
  }

  public function _init() {
    add_shortcode( 'sharedvision_embed', [ $this, '_shortcode_embed' ] );
  }

  public function _widgets_init() {
    register_widget( 'SharedVision\Widget\Embed' );
  }

  public function _shortcode_embed( $attributes, $content ) {
    if( empty( $attributes[ 'list_hash' ] ) )
      return '';

    \SharedVision\Helper\Embed::script_load();

    return SharedVision_Template::get_template( 'embed.php', [
      'list_hash' => $attributes[ 'list_hash' ]
    ] );
  }

}