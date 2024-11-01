<?php

namespace SharedVision;

class Builders {

  /**
   * @var Builders|null;
   */
  protected static ?Builders $_instance = null;

  /**
   * @return Builders
   */
  public static function instance() :Builders {
    if( self::$_instance === null )
      self::$_instance = new self();

    return self::$_instance;
  }

  public ?Builders\DiviBuilder $diviBuilder = null;
  public ?Builders\Elementor $elementor = null;
  public ?Builders\Gutenberg $gutenberg = null;
  public ?Builders\WPBakery $wpBakery = null;

  public function setup() {
    $this->diviBuilder = new Builders\DiviBuilder();
    $this->elementor = new Builders\Elementor();
    $this->gutenberg = new Builders\Gutenberg();
    $this->wpBakery = new Builders\WPBakery();

    $this->diviBuilder->setup();
    $this->elementor->setup();
    $this->gutenberg->setup();
    $this->wpBakery->setup();
  }

}