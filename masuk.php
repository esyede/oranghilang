<?php
include_once 'inc/sistem/konek.php'; //sda
include_once 'inc/sistem/fungsi.php'; //sda
 ?>

<!DOCTYPE HTML>
<html>
<head>
<title>Lost in Karawang</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="MLost in Karawang" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="assets/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<link href="assets/css/style.css" rel='stylesheet' type='text/css' />
<link href="assets/css/font-awesome.css" rel="stylesheet">
<link href="assets/css/sweetalert.css" rel="stylesheet">
<script src="assets/js/sweetalert.min.js"> </script>
<script src="assets/js/jquery.min.js"> </script>
<script src="assets/js/bootstrap.min.js"> </script>
</head>
<body>
  <?php set_judul_halaman(); ?>
	<div class="login">
		<h1><a href="index.html">Lost in Karawang </a></h1>
		<div class="login-bottom">
			<h2>Otentikasi Login</h2>
			<form action="masuk.php" method="post">
			<div class="col-md-6">
				<div class="login-mail">
					<input type="text" name="username" placeholder="Nama Pengguna" required="true">
					<i class="fa fa-user"></i>
				</div>
				<div class="login-mail">
					<input type="password" name="password" placeholder="Kata Sandi" required="">
					<i class="fa fa-lock"></i>
				</div>


			</div>
			<div class="col-md-6 login-do">
				<label class="hvr-shutter-in-horizontal login-sub">
					<input type="submit" name="masuk" value="Masuk">
					</label>
					<p>Belum punya akun?</p>
				<a href="daftar.php" class="hvr-shutter-in-horizontal">Daftar Disini</a>
			</div>
			<div class="clearfix">
      </div>
			</form>

      <?php
      if (isset($_POST['masuk'])) { //kalo tombol masuk diklik
        ob_start(); //sda
        session_start(); //sda

        $usr = bersihkan($_POST['username']); //ambil inputan username
        $pwd = md5(bersihkan($_POST['password'])); //ambil inputan password
        if (!empty($usr) && !empty($pwd)) { //kalo username dan password tidak kosong
          $q = mysql_query("select * from anggota where username = '".$usr."' AND password = '".$pwd."'") or die(mysql_error()); //cocokkan dengan yang di database
          $ada = mysql_num_rows($q); //cek berapa jumlah data yang cocok
          if ($ada > 0) { //kalo jumlah datanya lebih besar dari nol (berarti datanya ada)
            while ($data = mysql_fetch_array($q)) { //ambil data - datanya, lalu simpan sebagai sesi
              $_SESSION['id'] = $data['id']; //sesi id
              $_SESSION['username'] = $data['username']; //sesi username
              $_SESSION['password'] = $data['password']; //sesi password
              $_SESSION['level'] = $data['level']; //sesi level
              $_SESSION['nama_asli'] = $data['nama_asli']; //sesi nama_asli
              $_SESSION['jenis_kelamin'] = $data['jenis_kelamin']; //sesi jenis_kelamin
              $_SESSION['foto'] = $data['foto']; //sesi foto
              $_SESSION['alamat'] = $data['alamat']; //sesi alamat
              $_SESSION['no_telp'] = $data['no_telp']; //sesi no_telp
              ++$data;
            }

              if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'anggota') { //jika dia admin atau anggota
              if (!file_exists('foto/agt-'.$_SESSION['id']).'/') { //cek udah ada folder pribadi buat naruh data foto dia atau belum, kalo belum ada
                mkdir('foto/agt-'.$_SESSION['id'].'/'); //bikinin foldernya. nanti url foldernya seperti ini:
                // foto/agt-[ID_ANGGOTANYA]. misal id anggotanya '1' maka urlnya menjadi 'foto/agt-1/'
                chmod('foto/agt-'.$_SESSION['id'].'/', 0777); //atur hak aksesnya ke 777 (baca, tulis, eksekusi) --> unix/linux
              }
              //lalu lempar ke dabor.php
              header('location: dasbor.php');
              }
          } else { //kalo nggak ada yang cocok di database
          pesan('Error!', 'Data login anda tidak cocok', 'error');
              ob_end_flush(); //bersihin output buffernya
          }
        } else { //kalo formulirnya dikosongin
        pesan('Error!', 'Harap isi semua formulir', 'error');
        }
      } else { //kalo tombol 'masuk' belum diklik
      ob_end_flush();
      }
    ?>
    <br>
    <center>
      <a class="btn btn-primary" href="index.php"><i class="fa fa-reply"></i> Kembali ke Beranda</a>
    </center>
		</div>
	</div>
		<!---->
<div class="copy-right">
            <p> &copy; 2016 Fasilkom Unsika | Design by <a href="http://w3layouts.com/" target="_blank">W3layouts</a> </p>	    </div>
<!---->
<!--scrolling js-->
	<script src="assets/js/jquery.nicescroll.js"></script>
	<script src="assets/js/scripts.js"></script>
	<!--//scrolling js-->
</body>
</html>
