<?php

namespace SharedVision\Builders;

use Elementor\Plugin as Elementor_Plugin;

class Elementor {

  public $modules = [];

  public function setup() {
    add_action('elementor/widgets/register', [ $this, '_register_widgets' ] );
  }

  public function _register_widgets() {
    Elementor_Plugin::instance()->widgets_manager->register(new Elementor\Embed() );
  }

}