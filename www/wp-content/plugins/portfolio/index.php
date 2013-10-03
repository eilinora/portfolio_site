<?php 
  /*
  Plugin Name: Lori Hutchek Portfolio Items
  Plugin URI: www.lorihutchek.com
  Description: This module is used for portfolio items
  Author: Lori Hutchek 
  Version: 1.0
  Author URI: http://www.lorihutchek.com
  */


function custom_lab_post () {
  $labels = array(
    'name'               => _x( 'Portfolio', 'post type general name' ),
    'singular_name'      => _x( 'Portfolio', 'post type singular name' ),
    'add_new'            => _x( 'Add New Item', 'lab' ),
    'edit_item'          => __( 'Edit Portfolio Item' ),
    'all_items'          => __( 'All Portfolio Items' ),
    'view_item'          => __( 'View Portfolio Items' ),
    'search_items'       => __( 'Search Portfolio Items' ),
    'not_found'          => __( 'No labs found' ),
    'not_found_in_trash' => __( 'No labs found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Portfolio'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds our portfolio items',
    'public'        => true,
    'menu_position' => 5,
    'has_archive'   => false,
    'supports' => array('title',
                        'excerpt',
                        'editor',
                        'thumbnail',
                        'revisions'),
    'taxonomies' => array('post_tag'),
    'rewrite' => array('slug' => 'portfolio'),
    'register_meta_box_cb' => 'add_portfolio_metaboxes'
  );
  //'_edit_link'    => '/m/%d/edit',
  register_post_type( 'portfolio', $args );
}
add_action( 'init', 'custom_lab_post' );

// Add the Events Meta Boxes

function add_portfolio_metaboxes() {
  add_meta_box('wpt_portfolio_url', 'Portfolio', 'wpt_portfolio_url', 'portfolio', 'side', 'default');
}
// The Event Location Metabox

function wpt_portfolio_url() {
  global $post;
  
  // Noncename needed to verify where the data originated
  echo '<input type="hidden" name="portfoliometa_noncename" id="portfoliometa_noncename" value="' . 
  wp_create_nonce( plugin_basename(__FILE__) ) . '" />';
  
  // Get the location data if its already been entered
  $url = get_post_meta($post->ID, '_portfolio_item_url', true);
  
  // Echo out the field
  echo '<input type="text" name="_portfolio_item_url" value="' . $url . '" class="widefat" />';

}
add_action( 'add_meta_boxes', 'add_portfolio_metaboxes' );



// Save the Metabox Data

function wpt_save_portfolio_meta ($post_id, $post) {
  
  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times
  if ( !wp_verify_nonce( $_POST['portfoliometa_noncename'], plugin_basename(__FILE__) )) {
    return $post->ID;
  }

  // Is the user allowed to edit the post or page?
  if ( !current_user_can( 'edit_post', $post->ID ))
    return $post->ID;

  // OK, we're authenticated: we need to find and save the data
  // We'll put it into an array to make it easier to loop though.
  
  $_meta['_portfolio_item_url'] = $_POST['_portfolio_item_url'];
  
  // Add values of $events_meta as custom fields
  
  foreach ($_meta as $key => $value) { // Cycle through the $_meta array!
    if( $post->post_type == 'revision' ) return; // Don't store custom data twice
    $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
    if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
      update_post_meta($post->ID, $key, $value);
    } else { // If the custom field doesn't have a value
      add_post_meta($post->ID, $key, $value);
    }
    if(!$value) delete_post_meta($post->ID, $key); // Delete if blank
  }

}

add_action('save_post', 'wpt_save_portfolio_meta', 1, 2); // save the custom fields

/*****************
* Replaces built in urls and also add routing info needed
******************/


function filter_post_link($permalink, $post) {
  if ($post->post_type != 'post')
    return $permalink;
  return $post->post_type.$permalink;
}
add_filter('pre_post_link', 'filter_post_link', 10, 2);


/*function sr_blog_archive_link ($link) {
  return '/lab/archive'.$link;
}
add_filter('month_link', 'sr_blog_archive_link');
*/
/*****************
* The additional rewrite rules based on the link changes above
******************/
/*function add_news_rewrites( $wp_rewrite ) {
    $wp_rewrite->rules = array(
        
        'news/([^/]+)/?$' => 'index.php?name=$matches[1]',
        'news/[^/]+/attachment/([^/]+)/?$' => 'index.php?attachment=$matches[1]',
        'news/[^/]+/attachment/([^/]+)/trackback/?$' => 'index.php?attachment=$matches[1]&tb=1',
        'news/[^/]+/attachment/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?attachment=$matches[1]&feed=$matches[2]',
        'news/[^/]+/attachment/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?attachment=$matches[1]&feed=$matches[2]',
        'news/[^/]+/attachment/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?attachment=$matches[1]&cpage=$matches[2]',
        'news/([^/]+)/trackback/?$' => 'index.php?name=$matches[1]&tb=1',
        'news/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?name=$matches[1]&feed=$matches[2]',
        'news/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?name=$matches[1]&feed=$matches[2]',
        'news/([^/]+)/page/?([0-9]{1,})/?$' => 'index.php?name=$matches[1]&paged=$matches[2]',
        'news/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?name=$matches[1]&cpage=$matches[2]',
        'news/([^/]+)(/[0-9]+)?/?$' => 'index.php?name=$matches[1]&page=$matches[2]',
        'news/[^/]+/([^/]+)/?$' => 'index.php?attachment=$matches[1]',
        'news/[^/]+/([^/]+)/trackback/?$' => 'index.php?attachment=$matches[1]&tb=1',
        'news/[^/]+/([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?attachment=$matches[1]&feed=$matches[2]',
        'news/[^/]+/([^/]+)/(feed|rdf|rss|rss2|atom)/?$' => 'index.php?attachment=$matches[1]&feed=$matches[2]',
        'news/[^/]+/([^/]+)/comment-page-([0-9]{1,})/?$' => 'index.php?attachment=$matches[1]&cpage=$matches[2]'
    ) + $wp_rewrite->rules;
}
add_action( 'generate_rewrite_rules', 'add_news_rewrites' );
*/

