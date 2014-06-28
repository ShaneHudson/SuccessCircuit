<?php
function unregister_default_wp_widgets() {
  unregister_widget('WP_Widget_Calendar');
  unregister_widget('WP_Widget_Search');
  unregister_widget('WP_Widget_Recent_Comments');
}
add_action('widgets_init', 'unregister_default_wp_widgets', 1);

/**
 * Adds Foo_Widget widget.
 */
add_action( 'widgets_init', create_function( '', 'register_widget( "sc_custom_widget" );' ) );
class SC_Custom_Widget extends WP_Widget {

  /**
   * Register widget with WordPress.
   */
  public function __construct() {
    parent::__construct(
      'sc_custom_widget', // Base ID
      'SC Custom Text', // Name
      array( 'description' => __( 'Custom text widget for Success Circuit. Used for Homepage.', 'text_domain' ), ) // Args
    );
  }

  /**
   * Front-end display of widget.
   *
   * @see WP_Widget::widget()
   *
   * @param array $args     Widget arguments.
   * @param array $instance Saved values from database.
   */
  public function widget( $args, $instance ) {
    extract( $args );
    $title = apply_filters( 'sc_custom_widget', $instance['title'] );
    $link = apply_filters( 'sc_custom_widget', $instance['link'] );
    $colour = apply_filters( 'sc_custom_widget', $instance['colour'] );
    $text = apply_filters( 'sc_custom_widget', $instance['text'] );

    if ($colour)
      $before_widget = str_replace('li id=', "li data-colour='$colour' id=", $before_widget);
      $before_widget = str_replace('class="', 'class="custom-bg ', $before_widget);
    echo $before_widget;

    if ($link)
      echo "<a href='$link'>";
    else
      echo "<a>";

    if ($title)
      echo $before_title . $title . $after_title;

    if ($text)
      echo "<p>$text</p>";

    echo "</a>";
    echo $after_widget;
  }

  /**
   * Sanitize widget form values as they are saved.
   *
   * @see WP_Widget::update()
   *
   * @param array $new_instance Values just sent to be saved.
   * @param array $old_instance Previously saved values from database.
   *
   * @return array Updated safe values to be saved.
   */
  public function update( $new_instance, $old_instance ) {
    $instance = array();
    $instance['title'] = strip_tags( $new_instance['title'] );
    $instance['colour'] = strip_tags( $new_instance['colour'] );
    $instance['link'] = strip_tags( $new_instance['link'] );
    $instance['text'] = strip_tags( $new_instance['text'] );

    return $instance;
  }

  /**
   * Back-end widget form.
   *
   * @see WP_Widget::form()
   *
   * @param array $instance Previously saved values from database.
   */
  public function form( $instance ) {
    if ( isset( $instance[ 'title' ] ) ) {
      $title = $instance[ 'title' ];
    }
    else {
      $title = __( 'New title', 'text_domain' );
    }
    if ( isset( $instance[ 'link' ] ) ) {
      $link = $instance[ 'link' ];
    }
    else {
      $link = __( '', 'text_domain' );
    }
    if ( isset( $instance[ 'colour' ] ) ) {
      $colour = $instance[ 'colour' ];
    }
    else {
      $colour = __( '', 'text_domain' );
    }
    if ( isset( $instance[ 'text' ] ) ) {
      $text = $instance[ 'text' ];
    }
    else {
      $text = __( '', 'text_domain' );
    }
    ?>
    <p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Link:' ); ?></label> 
    <input link="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'colour' ); ?>"><?php _e( 'Colour:' ); ?></label> 
    <input class="widefat" id="<?php echo $this->get_field_id( 'colour' ); ?>" name="<?php echo $this->get_field_name( 'colour' ); ?>" type="text" value="<?php echo esc_attr( $colour ); ?>" />
    </p>
    <p>
    <label for="<?php echo $this->get_field_id( 'text' ); ?>"><?php _e( 'Text:' ); ?></label> 
    <textarea class="widefat" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo esc_attr( $text ); ?></textarea>
    </p>
    <?php 
  }

} // class Foo_Widget


?>
