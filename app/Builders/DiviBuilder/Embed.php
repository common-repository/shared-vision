<?php

namespace SharedVision\Builders\DiviBuilder;

use SharedVision\Helper\Lists as SharedVision_Helper_Lists;
use SharedVision\Template as SharedVision_Template;

class Embed extends \ET_Builder_Module {

  public $slug       = 'sharedvision_embed';
  public $has_advanced_fields = false;
  public $advanced_fields = false;

  public function init() {
    $this->vb_support = 'partial';
    $this->use_raw_content = true;

    $this->name = esc_html( sprintf( __( '%s Embed', 'sharedvision' ), SHARED_VISION_NAME ) );
  }

  public function get_fields() {
    return [
      'list_hash' => [
        'label'           => esc_html__( 'List', 'sharedvision' ),
        'type'            => 'select',
        'options'         => SharedVision_Helper_Lists::assoc_list( 'hash', 'name', true ),
        'option_category' => 'basic_option'
      ]
    ];
  }

  public function render( $unprocessed_props, $content, $render_slug ) {
    \SharedVision\Helper\Embed::script_load();

    return SharedVision_Template::get_template( 'embed.php', [
      'list_hash' => $this->props[ 'list_hash' ]
    ] );
  }

}