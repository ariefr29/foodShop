<?php 
/*
Template Name: Daftar Toko
*/
get_header(); ?>


<div class="container p-4 shadow-sm">
  <h3 class="h5 mb-4 pb-2 border-bottom border-3">
    <span style="bottom: 2px;" class="border-bottom border-3 position-relative border-success pb-2 text-success"><?php the_title(); ?></span>
  </h3>

  <div class="row">
    <?php 
    $relakan = new WP_Query("post_type=toko&showposts=9999&orderby=date"); 
    while($relakan->have_posts()) : $relakan->the_post(); ?>
      <div class="col-6 col-sm-4">
        <a class="card p-3 text-decoration-none" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
          <div class="mx-auto my-3" style="width: 75px;height: 75px;">
            <img class="rounded-pill" src="<?php the_post_thumbnail_url() ?>" alt="<?php the_title() ?>">
          </div>
          <h2 class="h6 text-center text-danger"> <?php the_title() ?> </h2>
        </a>
      </div><!-- .col-6 col-sm-4 -->
    <?php endwhile; ?>
  </div><!-- .row -->
</div><!-- .container -->


<?php get_footer(); ?>