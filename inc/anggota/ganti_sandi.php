<?php
ob_start(); //sda
require_once 'inc/sistem/konek.php'; //sda
require_once 'inc/sistem/fungsi.php'; //sda

if (dia_admin() || dia_anggota()) { //biar cuma admin dan anggota yang bisa akases
  require_once 'inc/sistem/kepala.php'; //sda
  require_once 'inc/sistem/nav_anggota.php'; //sda

  //deklarasikan variabelnya dulu biar nggak ada warning undefined index
  $p_lama = isset($p_lama)     ? $p_lama  : null;
    $p_baru1 = isset($p_baru1)    ? $p_baru1 : null;
    $q = mysql_query("select * from anggota where id='".$_SESSION['id']."'"); //kueri ambil data - data anggota ini (kamu)
  $ada = mysql_num_rows($q); //ada berapa data yang ketemu?
  if ($ada > 0) { //kalo yang ketemu lebih dari nol (artinya tidakk kosong atau ada data yang cocok)
    while ($data = mysql_fetch_array($q)) { //keluarin datanya
      $pass = $data['password']; //password
      $uid = $data['id']; //id
      ++$data; //increement biar nggak infinite loop
    }
  }
    ?>

   <div class="banner">
     <h2>
       <a href="<?php echo $index;
    ?>">Beranda</a> &raquo;
       <a href="kelola.php?aksi=lihat_profil">Profil</a> &raquo;
       <span>Ganti Sandi</span>
     </h2>
   </div>

   <div class="validation-system">

    		<div class="validation-form">
          <?php
            //tampilin info
            info('warning', '<i class="fa fa-warning"></i> Penting! Silahkan log in ulang menggunakan sandi baru anda setelah berhasil mengganti sandi.');
    ?>
        	<!-- Form ganti password -->
           <form action="kelola.php?aksi=ganti_sandi" method="post">
               <div class="col-md-12 form-group1 group-mail">
                 <label class="control-label">Sandi Lama</label>
                 <input name="i_p_lama" placeholder="sandi lama anda.." required="" type="password">
               </div>
                <div class="clearfix"> </div>

                <div class="col-md-12 form-group1 group-mail">
                  <label class="control-label">Sandi Baru</label>
                  <input name="i_p_baru" placeholder="sandi baru anda.." required="" type="text">
                </div>
                 <div class="clearfix"> </div>

               <div class="col-md-12 form-group">
                 <a href="index.php" class="btn btn-primary"><i class="fa fa-reply"></i> Kembali</a>
                 <button name="ganti_sandi" type="submit" class="btn btn-success pull-right"><i class="fa fa-key"></i> Ganti Sandi</button>
               </div>
             <div class="clearfix"> </div>
             <?php
             if (isset($_POST['ganti_sandi'])) { //kalo tombol ganti sandi diklik
               //buang undefined index dan ambil data inputannya
               $p_lama = isset($_POST['i_p_lama'])  ? $_POST['i_p_lama']  : null; //ambil inputan p_lama
               $p_baru = isset($_POST['i_p_baru'])  ? $_POST['i_p_baru']  : null; //ambil inputan p_baru
               if (empty($p_lama) || empty($p_baru)) { //kalo inputannya kososng
                 pesan('Error!', 'Harap isi semua formulir.', 'error'); //kaih pesan ini
               } else { //kalo ada isinya
                 if (md5($p_lama) == $pass) { //cek apakah hasil enkripsi md5 dari inputan p_lama sama dengan p_lama yang di database, kalo sama
                     $q = mysql_query("update anggota set password='".md5(bersihkan($p_baru))."' where id='".$uid."'"); //update datanya di database
                     //ohya, password di database saya enkripsi pake md5 ya...
                     if ($q) { //kalo kuerinya berhasil
                       pesan('Berhasil!', 'Sandi anda berhasil diubah menjadi \''.$p_baru.'\'', 'success'); //kasih pesan ini
                     } else { //kalo kuerinya gagal
                       pesan('Error!', 'Kesalahan saat menyimpan sandi.', 'error'); //kasih pesan ini
                     }
                 } else { //kalo md5 p_lama tidak cocok dengan yang di database
                   pesan('Error!', 'Sandi lama tidak cocok.', 'error'); //kasih pesan ini
                 }
               }
             }
    ?>
           </form>

    	<!---->
    </div>

   </div>

  <?php
  require_once 'inc/sistem/kaki.php';
} else {
    require_once 'keluar.php';
}
ob_end_flush();
  ?>
