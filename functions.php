<?php


//
//  Gallery Child Theme Functions
//

function childtheme_menu_args($args) {
    $args = array(
        'show_home' => 'Home',
        'sort_column' => 'menu_order',
        'menu_class' => 'menu',
        'echo' => true
    );
	return $args;
}
add_filter('wp_page_menu_args', 'childtheme_menu_args');

// Adds a link to the author and other contributors
function childtheme_theme_link($themelink) {
      return $themelink . ' &amp; <a href="http://chris-wallace.com/2009/05/04/gallery-wordpress-theme/" title="Gallery Wordpress Theme" rel="designer">Gallery WordPress Theme</a> by <a href="http://chris-wallace.com">Chris Wallace</a>.<br> Released by <a href="http://www.smashingmagazine.com">Smashing Magazine</a>. <a href="http://www.komodomedia.com/blog/2008/12/social-media-mini-iconpack/" title="Social Media Icons">Social Media Icons</a> by Rogie King';
}
add_filter('thematic_theme_link', 'childtheme_theme_link');

// Add a drop down category menu
function childtheme_menus() { ?>
        <div id="page-menu" class="menu">
            <ul id="page-nav" class="sf-menu">
                <li class="rss"><a href="<?php bloginfo('rss2_url'); ?>">RSS Feed</a></li>
                <?php wp_list_pages('title_li='); ?>
            </ul>
        </div>
        <div id="category-menu" class="menu">
            <ul id="category-nav" class="sf-menu">
                <li class="home"><a href="<? bloginfo('url'); ?>">Home</a></li>
                <?php wp_list_categories('title_li=&number=7'); ?>
                <li class="blog-description"><span><?php bloginfo('description'); ?></span></li>
            </ul>
        </div>
<?php }
add_action('wp_page_menu','childtheme_menus');

// Remove sidebar on gallery-style pages
function remove_sidebar() {
  if(is_page()){
    return TRUE;
  } else {
    return FALSE;
  }
}

  add_filter('thematic_sidebar', 'remove_sidebar');


// Add fix for ie6 styles
function fix_ie6(){
  echo '  <!--[if lt IE 7]>
    <script src="/wp-content/themes/gallery/js/DD_belatedPNG.js"></script>
    <script type="text/javascript">
      DD_belatedPNG.fix("body,#wrapper, ul.meta li,#blog-title a,#access,#access a,.new,#comments h3,ul.children li,.cover-up,.entry-content .post-ratings img,.post-ratings-image");    
    </script>
  <![endif]-->';
}

// Add slider and lazyload
function gallery_slider(){
  echo '<script type="text/javascript" src="';  bloginfo('url'); echo '/wp-content/themes/gallery/js/gallery.js"></script>';
  echo '<script type="text/javascript" src="';  bloginfo('url'); echo '/wp-content/themes/gallery/js/jquery.lazyload.pack.js"></script>';
}
add_action('wp_head','fix_ie6');
add_action('wp_head','gallery_slider');

// Custom post header
function childtheme_post_header(){
	if ( (time()-get_the_time('U')) <= (3*86400) ) { // The number 3 is how many days to keep posts marked as new
		echo '<div class="new"></div>';
	}
}

/*
Plugin Name: Custom Write Panel
Plugin URI: http://wefunction.com/2008/10/tutorial-create-custom-write-panels-in-wordpress
Description: Allows custom fields to be added to the WordPress Post Page
Version: 1.0
Author: Spencer
Author URI: http://wefunction.com
/* ----------------------------------------------*/

$new_meta_boxes =
  array(
  "full-image" => array(
  "name" => "full-image",
  "std" => "",
  "title" => "Path to Full-Size Image (500x375)",
  "description" => "Using the \"<em>Add an Image</em>\" button, upload a 500x375 image and paste the URL here."),
  "thumbnail" => array(
  "name" => "thumbnail",
  "std" => "",
  "title" => "Path to Thumbnail Image (125x125)",
  "description" => "Using the \"<em>Add an Image</em>\" button, upload a 125x125 thumbnail image and paste the URL here."),
  "designed-by" => array(
  "name" => "designed-by",
  "std" => "",
  "title" => "Designed by",
  "description" => "Enter the name of the designer (if known or applicable)."),
  "web-url" => array(
  "name" => "web-url",
  "std" => "",
  "title" => "Website URL",
  "description" => "Enter the full website URL (if applicable).")
);

function new_meta_boxes() {
  global $post, $new_meta_boxes;
  
  foreach($new_meta_boxes as $meta_box) {
    $meta_box_value = get_post_meta($post->ID, $meta_box['name'], true);
    
    if($meta_box_value == "")
      $meta_box_value = $meta_box['std'];
    
    echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
    
    echo'<label style="font-weight: bold; display: block; padding: 5px 0 2px 2px" for="'.$meta_box['name'].'">'.$meta_box['title'].'</label>';
    
    echo'<input type="text" name="'.$meta_box['name'].'" value="'.$meta_box_value.'" size="55" /><br />';
    
    echo'<p><label for="'.$meta_box['name'].'">'.$meta_box['description'].'</label></p>';
  }
}

function create_meta_box() {
  global $theme_name;
  if ( function_exists('add_meta_box') ) {
    add_meta_box( 'new-meta-boxes', 'Gallery Post Settings', 'new_meta_boxes', 'post', 'normal', 'high' );
  }
}

function save_postdata( $post_id ) {
  global $post, $new_meta_boxes;
  
  foreach($new_meta_boxes as $meta_box) {
  // Verify
  if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {
    return $post_id;
  }
  
  if ( 'page' == $_POST['post_type'] ) {
  if ( !current_user_can( 'edit_page', $post_id ))
    return $post_id;
  } else {
  if ( !current_user_can( 'edit_post', $post_id ))
    return $post_id;
  }
  
  $data = $_POST[$meta_box['name']];
  
  if(get_post_meta($post_id, $meta_box['name']) == "")
    add_post_meta($post_id, $meta_box['name'], $data, true);
  elseif($data != get_post_meta($post_id, $meta_box['name'], true))
    update_post_meta($post_id, $meta_box['name'], $data);
  elseif($data == "")
    delete_post_meta($post_id, $meta_box['name'], get_post_meta($post_id, $meta_box['name'], true));
  }
}

add_action('admin_menu', 'create_meta_box');
add_action('save_post', 'save_postdata');


?>