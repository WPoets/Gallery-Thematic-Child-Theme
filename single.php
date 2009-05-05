<?php
global $options;
foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; }
    else { $$value['id'] = get_settings( $value['id'] ); }
    }
$shortenedurl = file_get_contents('http://tinyurl.com/api-create.php?url=' . urlencode(get_permalink()));
?>
<?php get_header() ?>

	<div id="container">

		<div id="content">

		<?php the_post(); ?>

		  <?php get_sidebar('single-top') ?>

			<div id="post-<?php the_ID(); ?>" class="<?php thematic_post_class(); ?>">
			  <div class="entry-content">
			    <?php if(function_exists('the_ratings')) { echo the_ratings(); } ?>  
			    <h1><?php the_title(); ?></h1>
				<?php the_content(''.__('Read More <span class="meta-nav">&raquo;</span>', 'thematic').''); ?>
				<ul class="meta">
				  <?php if(get_post_meta($post->ID, 'designed-by')){ ?><li class="designer">Designed by: <?php echo get_post_meta($post->ID, 'designed-by', $single = true); ?></li><?php } ?>
				  <?php if(get_post_meta($post->ID, 'web-url')){ ?>
					  <li class="site-link"><a rel="source" href="<?php echo get_post_meta($post->ID, 'web-url', $single = true); ?>"><?php echo get_post_meta($post->ID, 'web-url', $single = true); ?></a></li>
					  <li class="delicious"><a href="http://del.icio.us/post?url=<?php echo get_post_meta($post->ID, 'web-url', $single = true); ?>&amp;<?php the_title(); ?>">Bookmark This (<?php echo get_post_meta($post->ID, 'web-url', $single = true); ?>)</a></li>
					  <li class="twitter"><a href="http://www.twitter.com/home?status=<?php echo str_replace(' ', '+', the_title_attribute('echo=0')); echo '+' . $shortenedurl; echo "+(via+@mixcss)"; ?>" title="Share <?php the_title_attribute(); ?> on Twitter">Tweet This</a></li>
				  <?php } ?>
				</ul>
			    <div id="nav-below" class="navigation">
			      <div class="nav-previous"><?php previous_post_link('%link', '<span class="meta-nav">&laquo;</span> %title') ?></div>
				  <div class="nav-next"><?php next_post_link('%link', '%title <span class="meta-nav">&raquo;</span>') ?></div>
			    </div>
			  </div>
			</div><!-- .post -->

			<div class="artwork-container">
			  <div class="entry-artwork">
				  <?php if(get_post_meta($post->ID, 'web-url')){ ?>
				    <a href="<?php echo get_post_meta($post->ID, 'web-url', $single = true); ?>"><img src="<?php if(get_post_meta($post->ID, 'full-image')){echo get_post_meta($post->ID, 'full-image', $single = true);}else{bloginfo('url'); echo '/wp-content/themes/gallery/images/full-image-default.jpg';} ?>" width="500" height="375" alt="<?php echo get_post_meta($post->ID, 'web-url', $single = true); ?>"></a>
				  <?php }else{ ?>
				    <img src="<?php if(get_post_meta($post->ID, 'full-image')){echo get_post_meta($post->ID, 'full-image', $single = true);}else{echo '/wp-content/themes/gallery/images/full-image-default.jpg';} ?>" width="500" height="375" alt="<?php echo get_post_meta($post->ID, 'web-url', $single = true); ?>">
			      <?php } ?>
			  </div>
			</div>
			
<?php get_sidebar('single-insert') ?>

<?php comments_template('', true); ?>

<?php get_sidebar('single-bottom') ?>

		</div><!-- #content -->
	</div><!-- #container -->

<?php thematic_sidebar() ?>
<?php get_footer() ?>
