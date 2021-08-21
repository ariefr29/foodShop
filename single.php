<?php get_header();
  if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div class="big-hero container p-0 overflow-hidden shadow-sm">
  <a href="<?php bloginfo('url'); ?>" class="btn position-absolute rounded-circle bg-white" style="z-index: 9;"><span class="iconify fs-4" data-icon="eva:arrow-back-outline"></span></a>
  <div class="cover mb-4">
    <img class="position-cover" src="<?php the_post_thumbnail_url()  ?>" alt="<?php the_title() ?>">
  </div><!-- .cover -->
  <div class="judul mb-4">
    <h1 class="h4 mb-3 text-center"> <?php the_title(); ?> </h1>
    <div class="profile d-flex align-items-center justify-content-center">
      <img class="rounded-circle" src="<?php info_toko("url_gambar") ?>" alt="avatar" style="width: 28px;height: 28px;">
      <span class="ms-2"><?php info_toko(); ?></span>
    </div>
  </div><!-- .judul -->
  <div class="harga p-4 mb-2 text-center" style="background: #DCFCE7;color: var(--bs-green);">
    <span class="h4 fw-bold"> <?= get_post_meta( $post->ID, "etheme_harga", true ) ?> </span>
  </div><!-- .harga -->
</div><!-- .big-hero -->

<!-- box Modal Whatsapp -->
<?php get_template_part( 'aset/other/order', 'whatsapp' ) ?>

<div class="container p-4 mb-4 shadow-sm">
  <div class="desc mb-5">
    <div class="deskripsi mb-3">
      <?php the_content(); ?>
    </div>
    <div class="kategori text-success">
      <span class="iconify me-1" style="font-size: 20px;" data-icon="ci:tag"></span>
      <?php the_category( ", " ) ?>
    </div>
  </div>

  <h3 class="h5 mb-4 pb-2 border-bottom border-3"><span style="position: relative;bottom: 2px;" class="border-bottom border-3 border-success pb-2 text-success">Menu Lain <?php info_toko('nama') ?></span></h3>
  <div class="row mb-5">
    <?php
    $toko_ID = get_post_meta(get_the_ID(), 'etheme_toko', true);
    $args = [
      'showposts' => 6,
      'post_type'  => 'post',
      'meta_key' => 'etheme_toko',
      'meta_value' => $toko_ID,
      'orderby'    => ['post_date' => 'rand']
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
</div><!-- .container -->

<div class="fixed-bottom">
  <div class="container shadow p-3">
    <div class="btn d-block mx-2 p-2 bg-success text-white rounded-pill" data-bs-toggle="modal" data-bs-target="#pesanan">Pesan Sekarang</div>
  </div>
</div> <!-- .fixed-bottom -->



<?php endwhile; endif;
  get_footer(); ?>
