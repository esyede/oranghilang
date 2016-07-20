<?php
ob_start(); //sda
require_once 'inc/sistem/konek.php'; //sda
require_once 'inc/sistem/fungsi.php'; //sda

if (dia_admin() || dia_anggota()) { //biar cuma admin dan anggota yang bisa akses
  require_once 'inc/sistem/kepala.php'; //sda
  require_once 'inc/sistem/nav_anggota.php'; //sda

  ?>
<div class="banner">
  <h2>
    <a href="<?php echo $index;
    ?>">Beranda</a>
    &raquo;
    <a href="kelola.php?aksi=laporan_saya">Data Pelaporan</a>
    &raquo;
    <span>Buat Laporan Kehilangan</span>
  </h2>
</div>

<div class="validation-system">

 		<div class="validation-form">
        <form action="kelola.php?aksi=buat_laporan_kehilangan" method="post" enctype="multipart/form-data">
            <div class="col-md-12 form-group1 group-mail">

              <label class="control-label">Foto Korban</label>
              <input name="foto_korban" placeholder="Foto korban" required="" type="file" class="custom-file-input">
            </div>
             <div class="clearfix"> </div>

            <div class="vali-form">
            <div class="col-md-6 form-group1">
              <label class="control-label">Nama Korban</label>
              <input name="nama_korban" placeholder="Nama lengkap korban" required="" type="text">
            </div>
            <div class="col-md-6 form-group1 form-last">
              <label class="control-label">Contact Person</label>
              <input name="contact_person" placeholder="Contact person" required="" type="text">
            </div>
            <div class="clearfix"> </div>
            </div>

              <div class="col-md-12 form-group2 group-mail">
               <label class="control-label">Jenis Kelamin</label>
             <select name="jenis_kelamin">
             	<option value="pria">Pria</option>
             	<option value="wanita">Wanita</option>
             </select>
             </div>
              <div class="clearfix"> </div>

            <div class="col-md-12 form-group1 ">
              <label class="control-label">Lokasi Hilang</label>
              <textarea name="lokasi_hilang" placeholder="Lokasi hilang korban" required=""></textarea>
            </div>
             <div class="clearfix"> </div>

             <div class="col-md-12 form-group1 ">
               <label class="control-label">Ciri Khusus Korban </label> <i class="text text-muted small">(Pisahkan dengan koma)</i>
               <textarea name="ciri_khusus" placeholder="Ciri khusus korban" required=""></textarea>
             </div>
              <div class="clearfix"> </div>

            <div class="col-md-12 form-group">
              <button name="laporkan" class="btn btn-primary hvr-shutter-in-horizontal">Laporkan</button>
            </div>
          <div class="clearfix"> </div>
        </form>

 </div>
 <?php
 if (isset($_POST['laporkan'])) { //kalo tombol laporkan diklik
   //ambil semau data inputan, cek dengan isset() biar nggak undefined index
   $nama_korban = isset($_POST['nama_korban'])    ? $_POST['nama_korban']     : ''; //nama korban
   $contact_person = isset($_POST['contact_person']) ? $_POST['contact_person']  : ''; //contact person
   $jenis_kelamin = isset($_POST['jenis_kelamin'])  ? $_POST['jenis_kelamin']   : ''; //jenis kelamin
   $lokasi_hilang = isset($_POST['lokasi_hilang'])  ? $_POST['lokasi_hilang']   : ''; //lokasi hilang
   $ciri_khusus = isset($_POST['ciri_khusus'])    ? $_POST['ciri_khusus']     : ''; //ciri khusus

   //UNTUK PANDUAN KOMENTAR, LIHAT FILE /inc/anggota/edit_foto.php. LANGKAHNYA SAMA
   //SELANJUTNYA LANGKAH - LANGKAH YANG SAMA AKAN DITULIS DENGAN '//sda'

   if ($_FILES['foto_korban']['size'] > 1024 && $_FILES['foto_korban']['size'] < 1048576) { // kalo file foto lebih besar dari 1024 byte (1 KB) dan kurang dari 1048576 byte (1 MB). upload OK!
      //cek inputanya diisi semua atau nggak
       if (!empty($nama_korban) || !empty($contact_person) || !empty($jenis_kelamin) || !empty($lokasi_hilang) || !empty($ciri_khusus)) {  //kalo diisi semua
         //ampil data inputan file
         $f_nama = $_FILES['foto_korban']['name']; //nama file
         $f_nm_tmp = $_FILES['foto_korban']['tmp_name']; //nama file sementara
         $f_ukuran = $_FILES['foto_korban']['size']; //ukuran
         $f_tipe = pathinfo($f_nama, PATHINFO_EXTENSION); //ekstensi
         $f_tipe = (get_magic_quotes_gpc() == 0 ? mysql_real_escape_string(pathinfo($f_nama, PATHINFO_EXTENSION)) : mysql_real_escape_string(stripslashes($_FILES['foto_korban']))); //sda

         //tipe diizinkan
         $tipe_ok = array('jpg', 'png', 'gif'); //sda

         //inputan string, bersihkan
         $nama_korban = bersihkan($nama_korban); //sda
         $contact_person = bersihkan($contact_person); //sda
         $jenis_kelamin = bersihkan($jenis_kelamin); //sda
         $lokasi_hilang = bersihkan($lokasi_hilang); //sda
         $ciri_khusus = bersihkan($ciri_khusus); //sda

         if (!get_magic_quotes_gpc()) {
             $f_nama = addslashes($f_nama);
         }  //sda

         if (in_array($f_tipe, $tipe_ok)) {  //sda
           $f_nama = str_replace(' ', '_', $f_nama);  //sda
           $f_nama = preg_replace('/[^a-zA-Z0-9_.-]/', '', $f_nama); //sda
           $f_nama = bersihkan($f_nama);  //sda
           $acak = rand(0, 99999);  //sda
           $url = 'foto/agt-'.$_SESSION['id'].'/Lap_'.$acak.'.'.$f_tipe; //sda
           $pndh = move_uploaded_file($f_nm_tmp, $url); //sda
           chmod($url, 0666); //sda

           if ($pndh) {  //jikoa file berehasil dipindahkan
               $tgl_sekarang = date('d-m-Y');  //sda
            //masukkan data - data inputan tadi ke database
             $sql = "insert into `pelaporan` (`nama`, `jenis_kelamin`, `lokasi_hilang`, `tanggal_hilang`, `ciri_khusus`, `foto_lpr`, `contact_person`, `tipe_pelaporan`, `id_pelapor`, `tanggal_lapor`) values
             ('".$nama_korban."', '".$jenis_kelamin."', '".$lokasi_hilang."', '".$tgl_sekarang."', '".$ciri_khusus."', '".$url."', '".$contact_person."', 'hilang', ".$_SESSION['id'].", '".$tgl_sekarang."')";

               $q = mysql_query($sql); //ini ngejalanin kuerinya

             if ($q) { //kalo kuerinya berhasil
               pesan('Berhasil!', 'Data pelaporan telah disimpan.', 'success'); //kasih pesan ini
             } else { //kalo kuerinya gagal
               pesan('Error!', 'Upload gagal. Kesalalahn query ke database.', 'error'); //kasih pesan ini
              //karena kuerinya gagal, mari hapus ulang file yang udah dipindahin tadi biar hemat hardisk. caranya:
               if (file_exists($url)) { //cek apakah filenya ada, kalo ada..
                 unlink($url); //langsung hapus aja
               }
             }
           } else { //kalo filenya gagal dipindahin
             pesan('Error!', 'Gagal memindahkan berkas. cek hak akses di server : '.$url, 'error'); //kasih pesan ini
           }
         } else { //kalo tipe filenya bukan jpg, png atau gif
             pesan('Error!', 'Berkas tipe ini tidak diijinkan. Yang diijinkan hanya JPG, PNG dan GIF.', 'error'); //kasih pesan ini
         }
       } else { //kalo formulirnya nggak diisi semua
         pesan('Error!', 'Harap isi semua formulir!', 'error'); //kasih pesan ini
       }
   } else { //kalo ukuran filenya kurang dari 1 KB atau lebih dari 1 MB
     pesan('Error!', 'Ukuran berkas minimal 1 KB dan maksimal 1 MB.', 'error'); //kasih pesan ini
   }
 } //ini punya isset laporkan
  ?>

  </div>
  </div>
   <?php
  require_once 'inc/sistem/kaki.php'; //sda
} else { //kalo dia bukan admin atau anggota
    require_once 'keluar.php'; //keluar sana!
}
ob_end_flush(); //bersihkan output buffer
?>
