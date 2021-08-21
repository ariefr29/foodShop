<?php get_header(); ?>

<div id="post-page" class="container p-4 shadow-sm">
  <h3 class="h5 mb-3 pb-2 border-bottom border-3">
    <span style="bottom: 2px;" class="border-bottom border-3 position-relative border-success pb-2 text-success"><?php the_title(); ?></span>
  </h3>
  <?php the_content(); ?>
</div>

<?php get_footer(); ?>
