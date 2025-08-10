
<?php get_header(); ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>



<main class="bg-df x-align py-5 py-4 aer-bg-light">
<div class="container-lg index-inner">
  <!-- <h1 class="text-center mb-4"><?php //get_the_title() ?></h1> -->
  <?php the_content(); ?>
</div>
</main>
 

<?php endwhile; else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
<body>

<?php get_footer(); ?>