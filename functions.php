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

// Add fix for ie6 styles
function fix_ie6(){
  echo '  <!--[if lt IE 7]>
    <script src="/wp-content/themes/gallery/js/DD_belatedPNG.js"></script>
    <script type="text/javascript">
      DD_belatedPNG.fix("body,#wrapper,.twitter,.delicious,#blog-title a,#access,#access a,.new,.post-ratings img,#comments h3,ul.children li,.cover-up");    
    </script>
    <style type="text/css">
    #access a{height: auto !important; padding:16px !important; line-height: 1em !important}
    .single #content {height: auto}
    .entry-content{height: 450px}
    </style>
  <![endif]-->';
}

function gallery_slider(){

  echo '<script type="text/javascript" src="';  bloginfo('url'); echo '/wp-content/themes/gallery/js/gallery.js"></script>';
  echo '<script type="text/javascript" src="';  bloginfo('url'); echo '/wp-content/themes/gallery/js/jquery.lazyload.pack.js"></script>';
}

add_action('wp_head','fix_ie6');
add_action('wp_head','gallery_slider');

function childtheme_post_header(){
	if ( (time()-get_the_time('U')) <= (3*86400) ) { // The number 3 is how many days to keep posts marked as new
		echo '<div class="new"></div>';
	}
}

?>