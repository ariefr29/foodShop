<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php wp_head(); ?>
  <?php get_template_part('/aset/inc/style'); ?>
</head>

<body>

<?php if ( !is_singular('post') ) : ?>
  <header class="container p-4 shadow-sm">
    <h1 class="h3 text-center fw-bolder p-1 mb-4 text-success"> <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a> </h1>
    <form class="d-flex position-relative" action="<?php bloginfo('url'); ?>">
      <span class="iconify position-absolute" style="top: 15px;color: #aaa;font-size: 18px;left: 15px;" data-icon="akar-icons:search"></span>
      <input class="sercing me-3" type="test" placeholder="Cari Makanan Kesukaanmu" name="s">
      <input type="hidden" name="post_type" value="post" />
      <div class="menux" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><span class="iconify" data-icon="ri:menu-4-fill"></span></div>
    </form>
    <div class="collapse" id="collapseExample">
      <?php wp_nav_menu(array(
        'theme_location'  =>  'main_menu', 
        'container'       =>  '',
        'menu_class'      =>  'menulist mt-4 m-0 p-4 shadow-sm', 
      )); ?>
    </div>
  </header>
<?php endif; ?>

