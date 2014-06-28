<?php
	// add custom menu fields to menu
	add_filter( 'wp_setup_nav_menu_item', 'rc_scm_add_custom_nav_fields' );

	// save menu custom fields
	add_action( 'wp_update_nav_menu_item', 'rc_scm_update_custom_nav_fields', 10, 3 );
	
	// edit menu walker
	add_filter( 'wp_edit_nav_menu_walker', 'rc_scm_edit_walker', 10, 2 );

	/**
	 * Add custom fields to $item nav object
	 * in order to be used in custom Walker
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function rc_scm_add_custom_nav_fields( $menu_item ) {
	
	    $menu_item->colour = get_post_meta( $menu_item->ID, '_menu_item_colour', true );
	    return $menu_item;
	    
	}
	
	/**
	 * Save menu custom fields
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function rc_scm_update_custom_nav_fields( $menu_id, $menu_item_db_id, $args ) {	

	    // Check if element is properly sent
	    if ( is_array( $_REQUEST['menu-item-colour']) ) {
	        $colour_value = $_REQUEST['menu-item-colour'][$menu_item_db_id];
	        update_post_meta( $menu_item_db_id, '_menu_item_colour', $colour_value );
	    }
	    
	}
	
	/**
	 * Define new Walker edit
	 *
	 * @access      public
	 * @since       1.0 
	 * @return      void
	*/
	function rc_scm_edit_walker($walker,$menu_id) {
	
	    return 'Walker_Nav_Menu_Edit_Custom';
	    
	}

	include_once( 'edit_custom_walker.php' );
	include_once( 'custom_walker.php' );
	

