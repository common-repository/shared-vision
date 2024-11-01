<?php

namespace SharedVision\Widget;

use SharedVision\Template as SharedVision_Template;
use SharedVision\Helper\Health as SharedVision_Helper_Health;
use SharedVision\Helper\Lists as SharedVision_Helper_Lists;

class Embed extends \WP_Widget {

  public function __construct() {
    parent::__construct(
      'sharedvision_embed', // Base ID
      sprintf( __( "%s Embed", 'sharedvision' ), SHARED_VISION_NAME ),
      array( 'description' => __( "Embed your shared vision list", "sharedvision" ) )
    );
  }

  public function widget( $args, $instance ) {
    echo $args['before_widget'];

    if ( ! empty( $instance['title'] ) ) {
      echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
    }

    // Fail silently...
    if( !empty( $instance[ 'list_hash' ] ) ) {
      SharedVision_Template::load_template( 'embed.php', [
        'list_hash' => $instance[ 'list_hash' ]
      ] );
    }

    echo $args['after_widget'];
  }

  public function form( $instance ) {
    $title = empty( $instance['title'] ) ? SHARED_VISION_NAME : $instance['title'];
    ?>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    </p>

    <?php if( SharedVision_Helper_Health::is_okay() ) : ?>
      <?php
        $lists = SharedVision_Helper_Lists::entries();
        $list_hash = !empty( $instance['list_hash'] ) ? $instance['list_hash'] : '';
      ?>
      <?php if( !empty( $lists ) ) : ?>
        <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'list_hash' ) ); ?>"><?php _e( 'List Hash:' ); ?></label>
          <select class="widefat" id="<?php echo $this->get_field_id( 'list_hash' ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'list_hash' ) ); ?>">
            <?php foreach( $lists as $list ) : ?>
              <option value="<?php echo esc_attr( $list[ 'hash' ] ); ?>" <?php selected( $list_hash, $list[ 'hash' ] );?>><?php echo esc_html( $list[ 'name' ] ); ?></option>
            <?php endforeach; ?>
          </select>
        </p>
      <?php else : ?>
        <p><?php echo esc_html( __( "No lists found, please make sure you have created at least one.", "sharedvision" ) ); ?></p>
      <?php endif; ?>
    <?php else: ?>
      <p><?php echo esc_html( __( "Invalid API credentials.", "sharedvision" ) ); ?></p>
      <p>
        <a class="button button-primary" href="<?php echo esc_url( admin_url( 'options-general.php?page=sharedvision-settings' ) ); ?>">
          <?php echo esc_html( sprintf( __( "Manage %s Settings", 'sharedvision' ), SHARED_VISION_NAME ) );  ?>
        </a>
      </p>
    <?php endif;
  }

  public function update( $new_instance, $old_instance ) {
    $instance = [];
    $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
    $instance['list_hash'] = ( ! empty( $new_instance['list_hash'] ) ) ? sanitize_text_field( $new_instance['list_hash'] ) : '';

    return $instance;
  }

}