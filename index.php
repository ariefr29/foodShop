<?php get_header(); ?>

<div class="container p-4 shadow-sm">

  <div class="row">
    <?php 

      if (is_search()) {
        echo "<h3 class='h6 mb-4'>Menampilkan hasil dari : " . get_search_query() . "</h3>";
      } elseif (is_archive()) {
        the_archive_title('<h3 class="h6 mb-4">','</h3>');
      }
      

      if ( have_posts() ) : while ( have_posts() ) : the_post(); 
        get_template_part( 'aset/other/card' );
      endwhile; endif; 

      paginate();
    ?>
    <style>
      .page-item.active .page-link {
        background: var(--bs-green);
        color: #fff !important;
        border-color: var(--bs-green);
      }
    </style>
  </div><!-- .row -->

</div><!-- .container -->


<?php get_footer(); ?>
