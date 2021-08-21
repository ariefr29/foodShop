<?php get_header() ?>

<div class="profile d-flex container p-4 py-5 p-sm-5 shadow-sm" style="background: var(--bs-gray-100);">
  <div class="avatar overflow-hidden rounded-circle me-4" style="width: 85px;height: 85px;">
    <img src="<?php info_toko('url_gambar') ?>" alt="logo">
  </div>
  <div class="detail mt-2" style="font-size: 15px;color: var(--bs-gray-800);">
    <h2 class="h5 fw-bolder"> <?php the_title(); ?> </h2>
    <div><?php echo get_post_meta($post->ID, "etheme_whatsapp", true); ?></div>
    <div><?php echo get_post_meta($post->ID, "etheme_alamat", true);  ?></div>
  </div>
</div><!-- .profile -->

<div class="container p-4 shadow-sm">

  <div class="about-toko mb-5">
    <h3 class="h5 mb-3 pb-2 border-bottom border-3"><span style="position: relative;bottom: 2px;" class="border-bottom border-3 border-success pb-2 text-success">Info</span></h3>
    <?php the_content(); ?>
  </div>

  <h3 class="h5 mb-4 pb-2 border-bottom border-3"><span style="position: relative;bottom: 2px;" class="border-bottom border-3 border-success pb-2 text-success">Menu</span></h3>
  <div class="row">
    <?php
    $args = [
      'showposts' => -1,
      'post_type'  => 'post',
      'meta_key' => 'etheme_toko',
      'meta_value' => $post->ID,
      'orderby'    => ['post_date' => 'ASC']
    ];
    $list = new WP_Query($args);
    if ($list->have_posts()) {
      while ($list->have_posts()) {
        $list->the_post();
        get_template_part( 'aset/other/card' );
      }
    } 
    ?>
  </div><!-- .row -->

</div>


<?php get_footer() ?>