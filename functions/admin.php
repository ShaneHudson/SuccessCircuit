<?php
    /**
     * Functionality for the Success Circuit Admin panel
     *
     * @package     WordPress
     * @subpackage  Admin Functionality
     * @since       1.0
     */

    /* ========================================================================================================================


    /* ========================================================================================================================
    
    Category functionality

    These functions are used to add fields to the category taxonomy, such as colour.

    @source One Trick Pony on Stack Overflow http://wordpress.stackexchange.com/questions/6549/any-examples-of-adding-custom-fields-to-the-category-editor
    
    ======================================================================================================================== */

    // the option name
    define('sc_categories_fields', 'sc_categories_fields_option');

    // your fields (the form)
    add_filter('edit_category_form', 'sc_categories_fields');
    function sc_categories_fields($tag) {
        $tag_extra_fields = get_option(sc_categories_fields); ?>
        <div class="form-field">
            <label for="category_colour">Category Colour</label>
            <input type="text" name="category_colour" value="<?php echo $tag_extra_fields[$tag->term_id]['category_colour']; ?>">
        </div>
        <?php
    }


    // when the form gets submitted, and the category gets updated (in your case the option will get updated with the values of your custom fields above
    add_filter('edited_terms', 'update_sc_categories_fields');
    function update_sc_categories_fields($term_id) {
      if($_POST['taxonomy'] == 'category'):
        $tag_extra_fields = get_option(sc_categories_fields);
        $tag_extra_fields[$term_id]['category_colour'] = strip_tags($_POST['category_colour']);
        update_option(sc_categories_fields, $tag_extra_fields);
      endif;
    }


    // when a category is removed
    add_filter('deleted_term_taxonomy', 'remove_sc_categories_fields');
    function remove_sc_categories_fields($term_id) {
      if($_POST['taxonomy'] == 'category'):
        $tag_extra_fields = get_option(sc_categories_fields);
        unset($tag_extra_fields[$term_id]);
        update_option(sc_categories_fields, $tag_extra_fields);
      endif;
    }

    function the_category_unlinked($separator = ' ') {
    $categories = (array) get_the_category();
    
    $thelist = '';
    foreach($categories as $category) {    // concate
        $thelist .= $separator . $category->category_nicename;
    }
    
    echo $thelist;
}
    
?>