<?php 
// file eksternal
require_once('aset/inc/meta.php');

//Sets up theme defaults and registers support for various WordPress features.
function etheme_setup() {

  //Make theme available for translation.
  load_theme_textdomain( 'etheme' );
  //Theme Support
  add_theme_support( 'title-tag' );
  add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'post-thumbnails' );


  // Menu
  register_nav_menus(array(
    'main_menu' => __( 'header menu', 'etheme' ),
    'footer_menu' => __( 'footer menu', 'etheme' ),
  ));
}
add_action( 'after_setup_theme', 'etheme_setup' );

// pingback url auto-discovery header for singularly identifiable articles.
add_action( 'wp_head', 'etheme_pingback_header' );
function etheme_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url(get_bloginfo( 'pingback_url' )) );
	}
}


//  Toko Post type
function toko() {
  $labels = array(
    'name'               => 'Toko Makanan',
    'singular_name'      => 'Toko',
    'menu_name'          => 'Toko Makanan',
    'name_admin_bar'     => 'Toko',
    'add_new'            => 'Tambah Baru',
    'add_new_item'       => 'Tambah Toko Baru',
    'new_item'           => 'New Toko',
    'edit_item'          => 'Edit Toko',
    'view_item'          => 'View Toko',
    'all_items'          => 'Semua Toko',
    'search_items'       => 'Search Toko',
    'parent_item_colon'  => 'Parent Toko:',
    'not_found'          => 'No Toko found.',
    'not_found_in_trash' => 'No Toko found in Trash.'
  );

  $args = array(
    'labels'        => $labels,
    'public'        => true,
    'rewrite'       => array('slug' => 'toko'),
    'has_archive'   => true,
    'menu_position' => 2,
    'menu_icon'     => 'dashicons-admin-multisite',
    'supports'      => array('title', 'editor', 'author', 'thumbnail', 'comments'),
  );
  register_post_type('toko', $args);
}
add_action('init', 'toko');


function enqueue_select2_jquery()
{
    wp_register_style('select2css', '//cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css', false, '1.0', 'all');
    wp_register_script('select2', '//cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js', array('jquery'), '1.0', true);
    wp_enqueue_style('select2css');
    wp_enqueue_script('select2');
}
add_action('admin_enqueue_scripts', 'enqueue_select2_jquery');

// Ajax Search Series
add_action('wp_ajax_toko_id_post', 'toko_id_post_ajax_callback');
function toko_id_post_ajax_callback() {

    $return = array();

    $search_results = new WP_Query(array(
        's' => $_GET['q'],
        'post_status' => 'publish',
        'post_type' => 'toko',
        'ignore_sticky_posts' => 1,
        'posts_per_page' => 25,
    ));

    if ($search_results->have_posts()) :
        while ($search_results->have_posts()) : $search_results->the_post();
            $title = (mb_strlen($search_results->post->post_title) > 70) ? mb_substr($search_results->post->post_title, 0, 69) . '...' : $search_results->post->post_title;
            $return[] = array($search_results->post->ID, $title);
        endwhile;
    endif;
    echo json_encode($return);
    die;
}

// Info toko for post
function info_toko($info=null) {
  $toko_ID = get_post_meta(get_the_ID(), 'etheme_toko', true);

  switch ($info) {
    case 'whatsapp';
      echo get_post_meta($toko_ID, "etheme_whatsapp", true);
      break;
    case 'gambar':
      echo '<img src="'. get_the_post_thumbnail_url($toko_ID) .'" alt="'. get_the_title($toko_ID) .'">';
      break;
    case 'url_gambar':
      echo get_the_post_thumbnail_url($toko_ID);
      break;
    case 'nama':
      echo get_the_title($toko_ID);
      break; 
    default:
      echo '<a class="text-danger" href="' . get_the_permalink($toko_ID) . '" rel="category tag" title="' . get_the_title($toko_ID) . '">';
      echo get_the_title($toko_ID);
      echo '</a>';
      break;
  }
}


/**
 * Pagination
 */
function paginate(\WP_Query $wp_query = null, $echo = true) {
  if (null === $wp_query) {
    global $wp_query;
  }
  $pages = paginate_links(
    [
      'base'         => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
      'format'       => '?paged=%#%',
      'current'      => max(1, get_query_var('paged')),
      'total'        => $wp_query->max_num_pages,
      'type'         => 'array',
      'show_all'     => false,
      'end_size'     => 1,
      'mid_size'     => 1,
      'prev_next'    => true,
      'prev_text'    => __('Prev'),
      'next_text'    => __('Next'),
      'add_args'     => false,
      'add_fragment' => ''
    ]
  );
  if (is_array($pages)) { 
    $pagination = '<div class="paginate py-3"><ul class="pagination justify-content-center my-4">';
    foreach ($pages as $page) {
      $pagination .= '<li class="page-item ' . (strpos($page, 'current') !== false ? 'active' : '') . '"> ' . str_replace('page-numbers', 'page-link text-success', $page) . '</li>';
    }
    $pagination .= '</ul></div>';
    if ($echo) {
      echo $pagination;
    } else {
      return $pagination;
    }
  }
  return null;
}
?>
