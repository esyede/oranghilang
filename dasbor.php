<?php
require_once 'inc/sistem/konek.php'; //sda
require_once 'inc/sistem/fungsi.php'; //sda
if (!isset($_SESSION)) {
    //cek sesi, kalo belum ada
  session_start(); //mulai nsesinya
}

if (dia_admin() || dia_anggota()) { //yang boleh akses halaman ini cuma admin dan anggota
  require_once 'inc/sistem/kepala.php'; //sda
  require_once 'inc/sistem/nav_anggota.php'; //sda
   ?>

  <div class="banner">
    <h2>
      <a href="<?php echo $index;
    ?>">Beranda</a>
      &raquo;
      <span>Dasbor</span>
    </h2>
  </div>



  <div class="validation-system">
   		<div class="validation-form">
         <p>
           <img src="assets/images/logo.png" alt="logo" width="100%"  align="center"/>
         </p>

         <div class="clearfix"> </div>
         <hr>
         <h3>Entah Ini Mau Diisi Apa</h3>
         <hr>
         <p>
           Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
         </p>
         <p>
           Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
         </p>


       </div>
   </div>

   <?php
  require_once 'inc/sistem/kaki.php'; //kaki
} else {
    require_once 'keluar.php'; //selain anggota dan admin, kasih file keluar.php
  //file keluar.php isinya destroy sesi dan lempar ke halaman login
}
    ?>
