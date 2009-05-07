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
        <?php get_sidebar('index-top') ?>
		<h1 class="page-title"><span><?php echo single_cat_title(); ?></span></h1>
			<div class="archive-meta"><?php if ( !(''== category_description()) ) : echo apply_filters('archive_meta', category_description()); endif; ?></div>

			<div id="nav-above" class="navigation">
                <?php if(function_exists('wp_pagenavi')) { ?>
                <?php wp_pagenavi(); ?>
                <?php } else { ?>  
				<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts', 'thematic')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>', 'thematic')) ?></div>
				<?php } ?>
			</div>

<?php while ( have_posts() ) : the_post() ?>

			<div id="post-<?php the_ID() ?>" class="<?php thematic_post_class() ?>">
				<div class="entry-content">
				<?php childtheme_post_header() ?>
	        	<a href="<?php echo the_permalink() ?>"><span class="slide-title"><?php echo the_title(); ?></span><img class="thumbnail" src="<?php if(get_post_meta($post->ID, 'thumbnail')){echo get_post_meta($post->ID, 'thumbnail', $single = true);} else{bloginfo('url'); echo "/wp-content/themes/gallery/images/thumbnail-default.jpg";} ?>" width="125" height="125" alt="<?php echo the_title() ?>" /></a>
			  </div>
			</div><!-- .post -->

<?php comments_template() ?>

<?php if ($count==$thm_insert_position) { ?><?php get_sidebar('index-insert') ?><?php } ?>
<?php $count = $count + 1; ?>
<?php endwhile ?>

			<div id="nav-below" class="navigation">
                <?php if(function_exists('wp_pagenavi')) { ?>
                <?php wp_pagenavi(); ?>
                <?php } else { ?>  
				<div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts', 'thematic')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>', 'thematic')) ?></div>
				<?php } ?>
			</div>

		</div><!-- #content -->
	</div><!-- #container -->

<?php thematic_sidebar() ?>
<?php get_footer() ?>