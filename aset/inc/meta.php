<?php
$prefix = "etheme_";

$meta_post = [
  "harga" => "text",
  "toko" => "ajax_select",
];

function add_custom_meta_post()
{
  add_meta_box(
    'post_info',                // Unique ID
    'Toko Information',       // Box title
    'meta_info_post_html',      // Content callback, must be of type callable
    'post'                      // Post type
  );
}

function meta_info_post_html($post)
{
  global $prefix, $meta_post;
?>
    <table class="form-table">
      <tbody>
        <?php foreach ($meta_post as $key => $type) {
          $meta = $prefix . $key;
        ?>
          <tr>
            <th scope="row">
              <label for="my-text-field"><?php echo ucfirst($key) ?></label>
            </th>
            <td>
              <?php if ($type == "text") { ?>
                <input type="text" name="<?php echo $meta ?>" id="<?php echo $meta ?>" value="<?php echo get_post_meta($post->ID, $meta, true) ?>" style="width: 100%" placeholder="Input <?php echo $key ?>...">
                <script>
                  var rupiah = document.getElementById('etheme_harga');
                  rupiah.addEventListener('keyup', function(e){
                    // tambahkan 'Rp.' pada saat form di ketik
                    // gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
                    rupiah.value = formatRupiah(this.value, 'Rp. ');
                  });
              
                  /* Fungsi formatRupiah */
                  function formatRupiah(angka, prefix){
                    var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split   		= number_string.split(','),
                    sisa     		= split[0].length % 3,
                    rupiah     		= split[0].substr(0, sisa),
                    ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
              
                    // tambahkan titik jika yang di input sudah menjadi angka ribuan
                    if(ribuan){
                      separator = sisa ? '.' : '';
                      rupiah += separator + ribuan.join('.');
                    }
              
                    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
                  }
                </script>
                <br>
              <?php } ?>
              <?php if ($type == "ajax_select") { ?>
                <select name="<?php echo $meta; ?>" id="<?php echo $meta; ?>" style="width: 100%;">
                  <option value="">Pilih Toko...</option>
                  <?php
                  $selected = get_post_meta($post->ID, $meta, true);
                  if ($selected) {
                    echo "<option value='" . $selected . "' selected>" . get_the_title($selected) . "</option>";
                  }
                  ?>
                </select>
                <script>
                  jQuery(document).ready(function() {
                    jQuery('#<?php echo $meta; ?>').select2({
                      ajax: {
                        url: ajaxurl,
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                          return {
                            q: params.term,
                            action: 'toko_id_post'
                          };
                        },
                        processResults: function(data) {
                          var options = [];
                          if (data) {

                            jQuery.each(data, function(index, text) {
                              options.push({
                                id: text[0],
                                text: text[1]
                              });
                            });

                          }
                          return {
                            results: options
                          };
                        },
                      },
                    });
                  })
                </script>
              <?php } ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
<?php
}

add_action('add_meta_boxes', 'add_custom_meta_post');

function save_postdata_post($post_id)
{
  global $prefix, $meta_post;
  foreach ($meta_post as $key => $type) {
    $meta = $prefix . $key;
    if (array_key_exists($meta, $_POST)) {
      update_post_meta(
        $post_id,
        $meta,
        $_POST[$meta]
      );
    }
  }
}
add_action('save_post_post', 'save_postdata_post');



// Toko [meta]
$meta_toko = [
  "whatsapp" => "text",
  "alamat" => "wysiwyg",
];

function add_custom_meta_toko()
{
  add_meta_box(
    'toko_info',                 // Unique ID
    'Informasi Toko',           // Box title
    'meta_info_toko_html',      // Content callback, must be of type callable
    'toko'                      // Post type
  );
}

function meta_info_toko_html($post)
{
    global $prefix, $meta_toko;
?>
    <table class="form-table">
      <tbody>   
        <?php foreach ($meta_toko as $key => $type) {
          $meta = $prefix . $key;
        ?> 
          <tr>
            <th scope="row">
              <label for="my-text-field"><?php echo ucfirst($key) ?></label>
            </th>
            <td>
              <?php if ($type == "text") { ?>
                <input type="text" name="<?php echo $meta ?>" id="<?php echo $meta ?>" value="<?php echo get_post_meta($post->ID, $meta, true) ?>" style="width: 100%" placeholder="Input <?php echo $key ?>...">
                <p style="display:block;margin-top: 7px;color: #777;font-size: 13px;"><em>wajib menggunakan angka '62' pengganti '0'</em></p>
                <br>
              <?php } ?>
              <?php if ($type == "wysiwyg") { ?>
                <?php wp_editor(get_post_meta($post->ID, $meta, true), $meta, [
                  "media_buttons" => false
                ]) ?>
              <?php } ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
    <style>
      #toko_info input{ max-width:300px; }
    </style>
<?php
}

add_action('add_meta_boxes', 'add_custom_meta_toko');

function save_postdata_toko($post_id)
{
  global $prefix, $meta_toko;
  foreach ($meta_toko as $key => $type) {
    $meta = $prefix . $key;
    if (array_key_exists($meta, $_POST)) {
      update_post_meta(
        $post_id,
        $meta,
        $_POST[$meta]
      );
    }
  }
}
add_action('save_post_toko', 'save_postdata_toko');