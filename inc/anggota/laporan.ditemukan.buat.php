<?php
require_once 'inc/sistem/konek.php'; //sda
require_once 'inc/sistem/fungsi.php'; //sda
if (!isset($_SESSION)) { //sda
  session_start(); //sda
}

if (dia_admin() || dia_anggota()) { //biar cuma admin dan anggota yang bisa akses
  require_once 'inc/sistem/kepala.php'; //sda
  require_once 'inc/sistem/nav_anggota.php'; //sda
?>
<div class="banner">
  <h2>
    <a href="<?php echo $index;
    ?>">Beranda</a>
    &raquo;
    <a href="#">Buat Laporan</a>
    &raquo;
    <span>Laporan Ditemukan</span>
  </h2>
</div>



<div class="validation-system">
  <div class="validation-form">
    <form id="form_cari" method="post" onsubmit="return false;">
      <div class="col-md-12 form-group1 group-mail pull-right">
        <div class="well">
          <h4>
            Silahkan cari data orang hilang terlebih dahulu melalui formulir dibawah ini:
          </h4>
          <br>
        <label class="control-label">Pencarian Nama  : </label>
        <input autocomplete="off" id="searchbox" name="keyword" onkeyup="CariData()" type="textbox">
      </div>
    </div>
       <div class="clearfix"> </div>
    </form>


    <div id="tempat_hasil">
      <!-- Disini tempat buat nampilin data hasil pencarian. pake fungsi CariData() dibawah itu buat nyetingnya -->
    </div>

    <script src="assets/js/prototype.js" type="text/javascript"></script>
    <script>
      function CariData() {
        new Ajax.Updater('tempat_hasil', 'kelola.php?aksi=laporan_ditemukan_cari_form',
        { method: 'post',
          parameters: $('form_cari').serialize()
        });
      }
    </script>

</div>
</div>
 <?php
require_once 'inc/sistem/kaki.php'; //sda
} else { //kalo dia bukan admin atau anggota
  require_once 'keluar.php'; //keluar sana!
}
  ?>
