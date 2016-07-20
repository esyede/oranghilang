<?php
require_once 'inc/sistem/konek.php'; //sda
require_once 'inc/sistem/fungsi.php'; //sda

if (dia_admin() || dia_anggota()) { //sda
  require_once 'inc/sistem/kepala.php'; //sda
  require_once 'inc/sistem/nav_anggota.php'; //sda

?>

   <div class="banner">
     <h2>
       <a href="<?php echo $index;
    ?>">Beranda</a> &raquo;
       <a href="kelola.php?aksi=lihat_profil">Profil</a> &raquo;
       <span>Ganti Foto Profil</span>
     </h2>
   </div>



  <div class=" profile">

  		<div class="profile-bottom">
  			<h3><i class="fa fa-user"></i>Ganti Foto Profil</h3>
  			<div class="profile-bottom-top">
  			<div class="col-md-4 profile-bottom-img">
  				<a href="kelola.php?aksi=ganti_foto" data-toggle="tooltip" title="Klik untuk mengganti foto"><img src="<?php echo $url_foto ?>" width="150px" height="150px" alt="Foto Profil"></a>
  			</div>
  			<div class="col-md-8 profile-text">
          <form action="kelola.php?aksi=ganti_foto" method="post" enctype="multipart/form-data">
            <label class="control-label">Pilih Berkas foto</label>
            <input name="berkas" type="file" class="custom-file-input">
  			</div>
  			<div class="clearfix"></div>
  			</div>
  			<div class="profile-bottom-bottom">
  			<div class="col-md-4 profile-fo">
  			</div>
  			<div class="col-md-4 profile-fo">
  				<button class="btn btn-danger btn-block" name="unggah"><i class="fa fa-upload"></i> Unggah</button>
  			</div>
     </form>
       <div class="clearfix"></div>
        <?php
        if (isset($_POST['unggah'])) { //kalo tombol unggah diklik
          if ($_FILES['berkas']['size'] > 1024 && $_FILES['berkas']['size'] < 1048576) { // kalo file foto lebih besar dari 1024 byte (1 KB) dan kurang dari 1048576 byte (1 MB). upload OK!
            $f_nama = $_FILES['berkas']['name']; //ambil nama file
            $f_nm_tmp = $_FILES['berkas']['tmp_name']; //ambil nama sementara filenya. karena defaultnya, di server file upload sebelum dipindahkan akan ditaruh di folder /tmp/ (linux/unix) dengan session id sebagai nama defaultnya (sesi ini otomatis digenerate oleh si php)
            $f_ukuran = $_FILES['berkas']['size']; //ukuran file
            $f_tipe = pathinfo($f_nama, PATHINFO_EXTENSION); //ekstensi file
            //buat keamanan, cek modul magic_quotes_runtime diaktifkan atau nggak. kalo nggak, saring string nama filenya pake mysql_real_escape_string()
            $f_tipe = (get_magic_quotes_gpc() == 0 ? mysql_real_escape_string(pathinfo($f_nama, PATHINFO_EXTENSION)) : mysql_real_escape_string(stripslashes($_FILES['berkas'])));
            //ini array tipe file yang diizinkan untuk di upload
            $tipe_ok = array('jpg', 'png', 'gif');

            //ini juga buat keamanan, cek modul magic_quotes_runtime aktif atau nggak
            if (!get_magic_quotes_gpc()) {
                $f_nama = addslashes($f_nama);
            } //kalo nggak aktif, kasih \\ di string nama file yang mengandung tanda ' atau " (menghindari sql inject di database)

            if (in_array($f_tipe, $tipe_ok)) { //cek, kalo tipe filenya essuai dengan salah satu aray tipe file yang kita ijinkan
              //kita udah bisa proses filenya sekarang!
              $f_nama = str_replace(' ', '_', $f_nama); //ganti spasi dengan underscore di nama file
              $f_nama = preg_replace('/[^a-zA-Z0-9_.-]/', '', $f_nama); //hapus karakter - karakter khusus
              $f_nama = bersihkan($f_nama); //bersihkan lagi dengangan fungsi 'bersihkan' (lihat /inc/sistem/fungsi.php)
              $url = 'foto/agt-'.$_SESSION['id'].'/Avatar.'.$f_tipe; //tentukan url foto milik anggota
              //nanti urlnya bakal jadi seperti ini:
              //misal id kita '1' maka urlnya : /foto/agt-1/Avatar.ekstesinya (jpg/png/gif)
              //ingat! folder /foto/agt-[ID_ANGGOTANYA] sudah kita bikin pas usernya login. cek file masuk.php

              //udah dipermak nama sama tipenya? kalo udah, yuk pindahin filenya
              $pndh = move_uploaded_file($f_nm_tmp, $url); //pindahin file ke $url. lihat var. $url diatas
              $pndh = chmod($url, 0666); //ubah hak aksesnya ke 666 (baca, tulis, eksekusi)

              if ($pndh) { //kalo filenya sukses di pindahin
                $q = mysql_query("update anggota set foto = '".$url."' where id = '".$_SESSION['id']."'"); //siapin kueri ke db
                if ($q) { //coba cek, kalo kuerinya dijalanin dan hasilnya sukses
                  if (file_exists($_SESSION['foto'])) unlink($_SESSION['foto']); //hapus avatar lama kalo ada
                  $_SESSION['foto'] = $url; //perbarui sesi untuk thumbnail avatar di header
                  pesan('Berhasil!', 'Foto anda ('.bulatkan($f_ukuran).') berhasil diunggah.', 'success'); //kasih pesan ini
                } else { //kalo kuerinya gagal dijalanin
                  pesan('Error!', 'Upload gagal. Kesalalahn query ke database.', 'error'); //kasih pesan ini
                  if (file_exists($url)) { //lalu cek filenya udah terlanjur dipindah ke $url belum. Kalo udah dipindahin kesana
                    unlink($url); //hapus lagi filenya biar hemat hardisk
                  }
                }
              } else { //kalo filenya gagal dipindahin
                pesan('Error!', 'Gagal memindahkan berkas. cek hak akses di server', 'error'); //kasih pesan ini
              }
            } else { //kalo tipenya nggak ada dalam array file yang diijinkan
                pesan('Error!', 'Berkas tipe ini tidak diijinkan. Yang diijinkan hanya JPG, PNG dan GIF.', 'error'); //kasih pesan ini
            }
          } else { //kalo ukuran filenya kurang dari 1KB atau lebih dari 1 MB
            pesan('Error!', 'Ukuran berkas minimal 1 KB dan maksimal 1 MB.', 'error'); //kasih pesan Ini
          }
        } //punya isset unggah
         ?>
  			</div>
  			<div class="profile-btn">

                  <a href="<?php echo $index;
    ?>" class="btn btn-primary"><i class="fa fa-reply"></i> Kembali</a>
             <div class="clearfix"></div>
  			</div>


  		</div>
  	</div>

    <?php
    require_once 'inc/sistem/kaki.php'; //sda
} else { //sda
    require_once 'keluar.php'; //sda
}
    ?>
