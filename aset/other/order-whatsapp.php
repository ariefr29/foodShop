<div class="modal fade" id="pesanan" tabindex="-1" aria-labelledby="pesananLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-danger" id="pesananLabel">Checkout Pesanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="produk" class="form-label fw-bolder">Nama Pesanan</label>
          <p id="namapesanan"><?php the_title() ?></p>
        </div>
        <div class="row mb-3">
          <div class="col-6">
            <label for="harga" class="form-label fw-bolder">Harga</label>
            <p id="hargasatuan"><?= get_post_meta( $post->ID, "etheme_harga", true ) ?></p>
          </div>
          <div class="col-6">
            <label for="jumlah" class="form-label fw-bolder">Jumlah Pesanan</label>
            <input id="jumlahpesanan" type="text" class="form-control" value="1" onkeyup="sum()">
          </div>
        </div>
        <div class="mb-3">
          <label for="catatan" class="form-label fw-bolder">Catatan</label>
          <textarea class="form-control" id="catatan" rows="3"></textarea>
        </div>
        <div id="text-info"></div>
      </div>
      <div class="modal-footer">
        <div id="totalbayar" class="me-auto text-danger fs-5 fw-bolder"> <?= get_post_meta( $post->ID, "etheme_harga", true ) ?> </div>
        <button type="button" class="send btn btn-success px-4 rounded-pill">Pesan via Whatsapp</button>
      </div>
    </div>
  </div>
</div>

<script>
  function sum() {
    var hargaSatuan   = document.getElementById("hargasatuan").textContent,
        hargaSatuan   = hargaSatuan.replace(/[^0-9]/g, ''),
        jumlahPesanan = document.getElementById("jumlahpesanan").value,
        totalHarga    = parseInt(hargaSatuan) * parseInt(jumlahPesanan);

    var number_string = totalHarga.toString(),
          split   		= number_string.split(','),
          sisa     		= split[0].length % 3,
          rupiah     	= split[0].substr(0, sisa),
          ribuan     	= split[0].substr(sisa).match(/\d{3}/gi);
    
          // tambahkan titik jika yang di input sudah menjadi angka ribuan
          if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
          }

    document.getElementById("totalbayar").textContent = "Rp. " + rupiah;
  }

  $(document).on('click','.send', function(){
      /* Inputan Formulir */
      var input_namapesanan   = document.getElementById("namapesanan").textContent,
          input_jumlahpesanan = $("#jumlahpesanan").val(),
          input_totalbayar    = document.getElementById("totalbayar").textContent,
          input_catatan       = $("#catatan").val();
  
      /* Pengaturan Whatsapp */
      var walink      = 'https://web.whatsapp.com/send',
          phone       = '<?php info_toko("whatsapp") ?>',
          text        = 'Halo saya ingin memesan ',
          text_yes    = 'Pesanan Anda berhasil terkirim.',
          text_no     = 'Isilah formulir dengan benar.';
  
      /* Smartphone Support */
      if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
          var walink = 'whatsapp://send';
      }
  
      if(input_totalbayar != "Rp. "){
          /* Whatsapp URL */
          var checkout_whatsapp = walink + '?phone=' + phone + '&text=' + text + '%0A%0A' +
              '🛒 *INFO PESANAN* %0A' +
              '=============================%0A' +
              '▪️ *Nama Pesanan* : ' + input_namapesanan + '%0A' +
              '▪️ *Jumlah Pesanan* : ' + input_jumlahpesanan + '%0A' +
              '▪️ *Total Harga* : ' + input_totalbayar + '%0A' +
              '=============================%0A' +
              '*Link Pesanan* : ' + '<?php the_permalink() ?>' + '%0A' +
              '=============================%0A' + '%0A' +
              '📌 *Catatan* : ' + input_catatan + '%0A';
  
          /* Whatsapp Window Open */
          window.open(checkout_whatsapp,'_blank');
          document.getElementById("text-info").innerHTML = '<div class="alert alert-success">'+text_yes+'</div>';
      } else {
          document.getElementById("text-info").innerHTML = '<div class="alert alert-danger">'+text_no+'</div>';
      }
  });
</script>