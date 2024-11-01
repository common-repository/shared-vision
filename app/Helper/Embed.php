<?php

namespace SharedVision\Helper;

use SharedVision\Settings as SharedVision_Settings;

class Embed {

  public static function script_load() {
      if( !has_action( "wp_footer", [ '\SharedVision\Helper\Embed', '_wp_footer' ] ) )
        add_action( "wp_footer", [ '\SharedVision\Helper\Embed', '_wp_footer' ], 200 );
  }

  public static function _wp_footer() {
    $src = ( SharedVision_Settings::instance()->get( 'mode' ) === SHARED_VISION_API_LIVE_ALIAS
        ? SHARED_VISION_EMBED_LIVE_URL
        : SHARED_VISION_EMBED_DEV_URL
    );

    echo '<script src="' . esc_attr( $src ) . '" async="async"></script>';
  }

}