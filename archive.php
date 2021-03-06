<?php
global $options;
foreach ($options as $value) {
    if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; }
    else { $$value['id'] = get_settings( $value['id'] ); }
    }
?>
<?php get_header() ?>

	<div id="container">
		<div id="content">

<?php the_post() ?>

<?php if ( is_day() ) : ?>
			<h1 class="page-title"><?php printf(__('Daily Archives: <span>%s</span>', 'thematic'), get_the_time(get_option('date_format'))) ?></h1>
<?php elseif ( is_month() ) : ?>
			<h1 class="page-title"><?php printf(__('Monthly Archives: <span>%s</span>', 'thematic'), get_the_time('F Y')) ?></h1>
<?php elseif ( is_year() ) : ?>
			<h1 class="page-title"><?php printf(__('Yearly Archives: <span>%s</span>', 'thematic'), get_the_time('Y')) ?></h1>
<?php elseif ( isset($_GET['paged']) && !empty($_GET['paged']) ) : ?>
			<h1 class="page-title"><?php _e('Blog Archives', 'thematic') ?></h1>
<?php endif; ?>

<?php rewind_posts() ?>

			<div id="nav-above" class="navigation">
                <?php if(function_exists('wp_pagenavi')) { ?>
                <?php wp_pagenavi(); ?>
                <?php } else { ?>  
				<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts', 'thematic')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>', 'thematic')) ?></div>
				<?php } ?>
			</div>

<?php while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID() ?>" class="<?php thematic_post_class() ?>">
				<div class="entry-content">
				<?php childtheme_post_header() ?>
	        	<a href="<?php echo the_permalink() ?>"><span class="slide-title"><?php echo the_title(); ?></span><img class="thumbnail" src="<?php if(get_post_meta($post->ID, 'thumbnail')){echo get_post_meta($post->ID, 'thumbnail', $single = true);} else{bloginfo('url'); echo "/wp-content/themes/gallery/images/thumbnail-default.jpg";} ?>" width="125" height="125" alt="<?php echo the_title() ?>" /></a>
				</div>
			</div><!-- .post -->

<?php endwhile ?>

			<div id="nav-below" class="navigation">
                <?php if(function_exists('wp_pagenavi')) { ?>
                <?php wp_pagenavi(); ?>
                <?php } else { ?>  
				<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts', 'thematic')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>', 'thematic')) ?></div>
				<?php } ?>
			</div>

		</div><!-- #content .hfeed -->
	</div><!-- #container -->

<?php thematic_sidebar() ?>
<?php get_footer() ?>