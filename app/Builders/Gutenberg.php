<?php

namespace SharedVision\Builders;

use SharedVision\Helper\Lists as SharedVision_Helper_Lists;
use SharedVision\Template as SharedVision_Template;

class Gutenberg {

  public function setup() {
    if ( ! function_exists( 'register_block_type' ) ) {
      // Gutenberg is not active.
      return;
    }

    wp_register_script(
      'sharedvision-block-embed',
      plugins_url( 'interface/gutenberg/embed.js', SHARED_VISION_BASE_FILE_PATH ),
      [ 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-data' ],
      SHARED_VISION_VERSION,
      true
    );

    wp_localize_script( 'sharedvision-block-embed', 'sharedvision_data', [
      'lists' => SharedVision_Helper_Lists::entries(),
    ] );

    register_block_type(
      'sharedvision/embed',
      [
        'editor_script'   => 'sharedvision-block-embed',
        'render_callback' => function( array $attributes ) {
          if( !isset( $attributes[ 'list_hash' ] ) || empty( $attributes[ 'list_hash' ] ) )
            return '';

          \SharedVision\Helper\Embed::script_load();

          return SharedVision_Template::get_template( 'embed.php', [
            'list_hash' => $attributes[ 'list_hash' ]
          ] );
        }
      ]
    );
  }

}