<?php
/*
Template Name: WeWork Masonry Template Page
*/

get_header(); ?>

<?php
	$terms = get_terms( 'tagweworkdemo' );
	$count = count( $terms );
	echo '<ul id="demo-filter">';
	echo '<li><a href="#all" title="">All</a></li>';
		if ( $count > 0 )
		{	
			foreach ( $terms as $term ) {
				$termname = strtolower( $term->name );
				$termname = str_replace( ' ', '-', $termname );
				echo '<li><a href="#" title="" rel="'. $termname .'" data-filter=".' . $termname .'">' . $term->name. '</a></li>';
			}
		}
	echo "</ul>";
?>

<?php 
	$loop = new WP_Query( array( 'post_type' => 'wework_demo', 'posts_per_page' => -1 ) );
	$count = 0;
?>
			
<div id="demo-wrapper">
	<div id="demo-list">
			
		<?php if ( $loop ) : 
					 
			while ( $loop->have_posts() ) : $loop->the_post(); ?>
					
				<?php
				$terms = get_the_terms( $post->ID, 'tagweworkdemo' );
									
				if ( $terms && ! is_wp_error( $terms ) ) : 
					$links = array();

					foreach ( $terms as $term ) {
						$links[] = $term->name;
					}
					$links = str_replace( ' ', '-', $links );	
					$tax = join( " ", $links );		
				else :	
					$tax = '';	
				endif;
				?>
							
				<?php $infos = get_post_custom_values('_url'); ?>
							
				<div class="demo-item <?php echo strtolower($tax); ?> all">
					<a href="<?php the_permalink() ?>"><?php the_post_thumbnail( array(300, 250) ); ?></a>
					<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
					<p class="excerpt"><a href="<?php the_permalink() ?>"><?php echo get_the_excerpt(); ?></a></p>
					<p class="links"><a href="<?php the_permalink() ?>">More Details →</a></p>
				</div>
						
			<?php endwhile; else: ?>
					 
				<div class="error-not-found">Sorry, no WeWork Demo entries found.</div>
						
		<?php endif; ?>

	</div>

	<div class="clearboth"></div>
</div>

<script>
	jQuery('#demo-list').isotope({
		itemSelector : '.demo-item',
		layoutMode : 'masonry'
	});
	
	// cache container
	var $container = jQuery('#demo-list');
	// initialize isotope
	$container.isotope({
	});
	
	// filter items when filter link is clicked
	jQuery('#demo-filter a').click(function(){
		var selector = jQuery(this).attr('data-filter');
		$container.isotope({ filter: selector });
		return false;
	});
</script>

<?php get_footer(); ?>



















