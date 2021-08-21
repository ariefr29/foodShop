<div class="col-6 col-sm-4">
  <a class="card text-decoration-none" href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
    <img src="<?php the_post_thumbnail_url() ?>" alt="<?php the_title() ?>">
    <div class="card-body">
      <h2 class="h6 card-title"> <?php the_title() ?> </h2>
      <div class="harga"> <?= get_post_meta( $post->ID, "etheme_harga", true ) ?> </div>
    </div>
  </a>
</div><!-- .col-6 col-sm-4 -->