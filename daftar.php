<?php
//include bagian - bagian dokumen html dan fungsi
require_once 'inc/sistem/konek.php'; //koneksi ke db
require_once 'inc/sistem/fungsi.php'; //fungsi - fungsi
require_once 'inc/sistem/kepala.php'; //kepala halaman
require_once 'inc/sistem/nav_anggota.php'; //menu navigasi kiri
 ?>

<div class="banner">
  <h2>
    <a href="index.php">Beranda</a>
    &raquo;
    <span>Pendaftaran</span>
  </h2>
</div>

<div class="validation-system">
 		<div class="validation-form">
      <!-- formulir pendaftaran -->
        <form action="daftar.php" method="post">
          <div class="vali-form">
          <div class="col-md-6 form-group1">
            <label class="control-label">Nama Lengkap</label>
            <input name="nama_asli" placeholder="Nama lengkap anda" required="" type="text">
          </div>
          <div class="col-md-6 form-group1 form-last">
            <label class="control-label">Nomor Telepon</label>
            <input name="no_telp" placeholder="Nomor telepon anda" required="" type="text">
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
              <label class="control-label">Alamat Lengkap</label>
              <textarea name="alamat" placeholder="Alamat lengkap anda" required=""></textarea>
            </div>
             <div class="clearfix"> </div>

            <div class="col-md-12 form-group1 group-mail">
              <label class="control-label">Nama Pengguna</label>
              <input name="username" placeholder="Nama pengguna" required="" type="text">
            </div>
             <div class="clearfix"> </div>


            <div class="vali-form">
            <div class="col-md-6 form-group1">
              <label class="control-label">Kata Sandi</label>
              <input name="password" placeholder="Kata sandi anda" required="" type="password">
            </div>
            <div class="col-md-6 form-group1 form-last">
              <label class="control-label">Ulangi Sandi</label>
              <input name="repassword" placeholder="Ulangi sandi anda" required="" type="password">
            </div>
            <div class="clearfix"> </div>
            </div>


            <div class="col-md-12 form-group">
              <button name="daftar" class="btn btn-primary hvr-shutter-in-horizontal">Daftar</button>
            </div>
          <div class="clearfix"> </div>
        </form>
 	<!--///// akhir formulir pendaftaran ///////-->

 </div>
 <?php

  if (isset($_POST['daftar'])) { //kalo udah diklik tombol daftar
    //ambil data dari masing - masing field. method isset() buat menghindari error undifined index
    $i_username = isset($_POST['username'])      ? $_POST['username']      : '';
      $i_password = isset($_POST['password'])      ? $_POST['password']      : '';
      $i_repassword = isset($_POST['repassword'])    ? $_POST['repassword']    : '';
      $i_nama_asli = isset($_POST['nama_asli'])     ? $_POST['nama_asli']     : '';
      $i_no_telp = isset($_POST['no_telp'])       ? $_POST['no_telp']       : '';
      $i_jen_kel = isset($_POST['jenis_kelamin']) ? $_POST['jenis_kelamin'] : '';
      $i_alamat = isset($_POST['alamat'])        ? $_POST['alamat']        : '';

    //echo $i_username . '-'. $i_password .'-'. $i_repassword . '-'. $i_nama_asli .'-'. $i_no_telp;
    //die();

    //cek datanya kosong atau nggak
    if (empty($i_username) || empty($i_password) || empty($i_repassword) || empty($i_nama_asli) || empty($i_no_telp) || empty($i_jen_kel) || empty($i_alamat)) { //kalo kosong
      pesan('Error!', 'Harap isi semua formulir', 'error');  //kasih error
    } else { //kalo nggak kosong, berarti siap di utak - atik
      if ($i_password != $i_repassword) { //cek konfirmasi password, ini kalo nggak sama
        pesan('Error!', 'Kata sandi tidak cocok', 'error'); //kasih error
      } else { //kalo pass-nya sama
        //saring dari karakter yang nggak perlu (selain alpha-numerik dan simbol umum)
        $i_username = bersihkan($i_username);
          $i_password = bersihkan($i_password);
          $i_repassword = bersihkan($i_repassword);
          $i_nama_asli = bersihkan($i_nama_asli);
          $i_no_telp = bersihkan($i_no_telp);
          $i_jen_kel = bersihkan($i_jen_kel);
          $i_alamat = bersihkan($i_alamat);

        //lihat ke database usernamenya udah ada yang pake/belum
        $q = mysql_query("select * from anggota where username = '".$i_username."'");
          if (mysql_num_rows($q) > 0) { //kalo udah dipake
          pesan('Error!', 'Nama pengguna yang anda pilih sudah dipakai', 'error'); //kasih error
          } else { //kalo belum ada yang pake
          //yaudah, datanya di masukin ke database
          $q = mysql_query("insert into `anggota` (`username`, `password`, `nama_asli`, `jenis_kelamin`, `foto`, `alamat`, `no_telp`) values ('".$i_username."', '".md5($i_password)."', '".$i_nama_asli."', '".$i_jen_kel."', 'assets/images/avatar.png', '".$i_alamat."', '".$i_no_telp."');");
              if ($q) { //berhasil nggak masukin ke database? ini kalo berhasil:
              pesan('Selamat!', 'Registrasi telah berhasil. Silahkan login dengan akun anda.', 'success'); //kasih pesan sukses
              } else { //ini kalo gagal masukin ke database
              pesan('Error!', 'Terjadi kesalahan pada database', 'error'); //kasih error
              }
          }
      }
    }
  }

  ?>

</div>

<?php
//include kaki halamannya
require_once 'inc/sistem/kaki.php';
 ?>
