<?php

namespace SharedVision\Builders;

use SharedVision\Helper\Lists as SharedVision_Helper_Lists;
use SharedVision\Template as SharedVision_Template;

class WPBakery {

    public function setup() {
      if ( !function_exists( 'vc_lean_map' ) )
        return;

      // Registers the shortcode in WordPress
      add_shortcode( 'sharedvision_wpbakery_shortcode_embed', __CLASS__ . '::output' );
      vc_lean_map( 'sharedvision_wpbakery_shortcode_embed', __CLASS__ . '::map' );
    }

    public static function output( $attributes, $content = null ) {
      if( !function_exists( 'vc_map_get_attributes' ) )
        return '';

      try {
        $attributes_parsed = vc_map_get_attributes('sharedvision_wpbakery_shortcode_embed', $attributes );
        $attributes = $attributes_parsed;
      } catch ( \Exception $e ) {
        // Variable is used to assign, to prevent it to become null, or damaged, and just rely on defaults.
      }

      if( !isset( $attributes[ 'list_hash' ] ) || empty( $attributes[ 'list_hash' ] ) )
        return '';

      \SharedVision\Helper\Embed::script_load();

      return SharedVision_Template::get_template( 'embed.php', [
        'list_hash' => $attributes[ 'list_hash' ]
      ] );
    }

    public static function map() {
      return [
        'name'        => esc_html( sprintf( __( '%s Embed', 'sharedvision' ), SHARED_VISION_NAME ) ),
        'description' => esc_html__( 'Embed your shared vision list.', 'sharedvision' ),
        'base'        => 'sharedvision_wpbakery_shortcode_embed',
        "icon"        => plugins_url( 'interface/assets/icon.png', SHARED_VISION_BASE_FILE_PATH ),
        // "category"    => 'sharedvision',
        'params'      => [
          [
            'type'       => 'dropdown',
            'heading'    => esc_html__( 'List', 'sharedvision' ),
            'param_name' => 'list_hash',
            'value'      => SharedVision_Helper_Lists::assoc_list( 'name', 'hash', true ),
          ],
        ],
      ];
    }

}