<?php
/**
 * The Template for displaying all single posts.
 */
get_header(); ?>

<div class="clear"></div>

</header> <!-- / END HOME SECTION  -->

<div id="content" class="site-content">

	<div class="container">
		<div class="content-left-wrap col-md-9">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">
				<?php while ( have_posts() ) : the_post();

						 get_template_part( 'content', 'single' );

						 zerif_post_nav();
					 
					endwhile; // end of the loop. ?>
				</main><!-- #main -->
			</div><!-- #primary -->
		</div>
		<div class="sidebar-wrap col-md-3 content-left-wrap">
			<?php get_sidebar(); ?>
		</div><!-- .sidebar-wrap -->
	</div><!-- .container -->
<?php get_footer(); ?>
