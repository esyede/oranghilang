<?php
require_once 'inc/sistem/konek.php'; //include file koneksi ke db
require_once 'inc/sistem/fungsi.php'; //include file yang berisi fungsi2
if (!isset($_SESSION)) { // cek sesi login udah ada atau belum, kalo belum ada (!isset())
  session_start(); //mulai sesinya
}
//ini buat url index di navigationj bar
if (dia_admin() || dia_anggota()) { //kalo dia admin atau anggota
  $index = 'dasbor.php'; //indexnya ke dasbor
} else { //selain itu
  $index = 'index.php'; //ke index biasa (halaman depan)
}
 ?>

<!DOCTYPE HTML>
<html>
<head>
<title>Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Lost in Karawang" />
<!-- JS Buat fungsi full screen -->
<script type="application/x-javascript">
  addEventListener("load", function() {
    setTimeout(hideURLbar, 0);
   }, false);
   function hideURLbar(){
     window.scrollTo(0,1);
   }
</script>
<link href="assets/css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<link href="assets/css/style.css" rel='stylesheet' type='text/css' />
<link href="assets/css/font-awesome.css" rel="stylesheet">
<link href="assets/css/sweetalert.css" rel="stylesheet">
<script src="assets/js/sweetalert.min.js"> </script>
<script src="assets/js/jquery.min.js"> </script>
<script src="assets/js/typed.min.js"> </script>
<!-- Mainly scripts -->
<script src="assets/js/jquery.metisMenu.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<!-- Custom and plugin javascript -->
<link href="assets/css/custom.css" rel="stylesheet">
<script src="assets/js/custom.js"></script>
<script src="assets/js/screenfull.js"></script>
		<script>
		$(function () {
			$('#supported').text('Supported/allowed: ' + !!screenfull.enabled); //cek apakah browser suport fungsi HideURLBar
			if (!screenfull.enabled) { //kalo nggak
				return false; //kasih return false
			}

			$('#toggle').click(function () { //kalo support dan id 'toggle' di klik
				screenfull.toggle($('#container')[0]); //buat full screen semua elemen dalam id container paling awal
        //fungsi screenfull ada di file assets/js/screenfull.js
			});



		});
		</script>

<!--skycons-icons-->
<script src="assets/js/skycons.js"></script>
<!--Respond dan Html5Shiv-->
<script src="assets/js/html5shiv.js"></script>
<script src="assets/js/respond.min.js"></script>
<link rel="icon" href="assets/images/ikon.png">
</head>

<body>
<div id="wrapper">

  <nav class="navbar-default navbar-static-top" role="navigation">
       <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
              <span class="sr-only">Beralih</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </button>
         <h1> <a class="navbar-brand smaller" href="<?php echo $index; ?>">Lost in Karawang</a></h1>
   </div>
 <div class=" border-bottom">
    <div class="full-left">
      <section class="full-top">
  <button id="toggle"><i class="fa fa-arrows-alt"></i></button>
</section>
     </div>


      <!-- Brand and toggle get grouped for better mobile display -->

 <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="drop-men" >
      <ul class=" nav_1">
        <?php
        if (dia_admin() || dia_anggota()) { //set hak akses biar yang yang bisa akses hanya admin dan anggota

          $q = mysql_query("select * from anggota where id='".$_SESSION['id']."'"); //ngambil semua data dari tbl anggota milik user ini. (milik kamu yg laogin sekarang)
          while ($akun = mysql_fetch_array($q)) {
              $nama = $akun['nama_asli']; // ambil data nama aslinya
            $url_foto = $akun['foto']; // data url fotonya
            //gunanya buat display nama dan foto di pojok kanan atas web ini
            ++$akun;
          }

          //ini menu buat user yang kita ambil datanya tadi
         echo '
        <li class="dropdown">
            <a href="#" class="dropdown-toggle dropdown-at" data-toggle="dropdown"><span class=" name-caret">'.$nama.'<i class="caret"></i></span><img src="'.$url_foto.'"  width="60px" height="60px"></a>
            <ul class="dropdown-menu " role="menu">
              <li><a href="kelola.php?aksi=lihat_profil"><i class="fa fa-user"></i>Profil Saya</a></li>
              <li><a href="kelola.php?aksi=ganti_sandi"><i class="fa fa-key"></i>Ganti sandi</a></li>
              <li><a href="keluar.php"><i class="fa fa-sign-out"></i>Keluar</a></li>
            </ul>
        </li>';
        } else { //yang ini buat yang belum login (yang bukan admin dan bukan anggota)
            echo '<li class="dropdown">
                <a href="#" class="dropdown-toggle dropdown-at" data-toggle="dropdown"><span class=" name-caret">Pengunjung<i class="caret"></i></span><img src="assets/images/avatar.png" width="60px" height="60px"></a>
                <ul class="dropdown-menu " role="menu">
                  <li><a href="masuk.php"><i class="fa fa-sign-in"></i>Masuk</a></li>
                  <li><a href="daftar.php"><i class="fa fa-users"></i>Registrasi</a></li>
                </ul>
            </li>';
        } ?>
      </ul>
   </div><!-- /.navbar-collapse -->
<div class="clearfix">
</div>
