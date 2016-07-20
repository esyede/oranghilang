<?php
require_once 'inc/sistem/konek.php'; //konek db
require_once 'inc/sistem/fungsi.php'; //fungsi - fungsi
require_once 'inc/sistem/kepala.php'; //kepala
require_once 'inc/sistem/nav_anggota.php'; //menu navigasi kiri
 ?>

<!-- ini url bar-->
<div class="banner">
  <h2>
    <a href="index.php">Beranda</a>
    &laquo; &raquo;
    <span>Laporan Terbaru</span>
  </h2>
</div>


<div class="validation-system">
  <div class="validation-form">
<?php
//ini buat slideshow foto
$slide = ''; //deklarasi var. slide (biar nggak undifined index)
$indikator = ''; //sda
$hitung = 0; //nilai awal var hitung, buat ngitung jumlah slide

//ngambil 10 data terbaru di tabel pelaporan
$q = mysql_query('select * from pelaporan order by tanggal_hilang desc limit 10');
$jml = mysql_num_rows($q); //ada hasilnya nggak?

if ($jml > 0) { //kalo ada hasilnya
  while ($data = mysql_fetch_array($q)) { //ambil data - datanya
    $nama = $data['nama']; //data nama
    $ciri_khusus = $data['ciri_khusus']; //ciri khusus
    $foto_lpr = $data['foto_lpr']; //url foto
    $contact_person = $data['contact_person']; //kontak

    if ($hitung == 0) { //kalo slidenya slide pertama
      $indikator .= '<li data-target="#foto-korban" data-slide-to="'.$hitung.'" class="active"></li>'; //arrow kanan aktifin
      $slide    .= '<div class="item active">
  	    							<img src="'.$foto_lpr.'" alt="'.$nama.'"/>
  	    								<div class="carousel-caption teks-hitam">
  	      								<h3>'.$nama.'</h3>
  	      								<p>'.$ciri_khusus.'</p>
  												<p>(CP: '.$contact_person.')</p>
  	    							</div>
  	  							</div>';
    } else { //kalo nggak
          $indikator .= '<li data-target="#foto-korban" data-slide-to="'.$hitung.'"></li>'; // arrow kanan matiin
                $slide    .= '<div class="item">
  												<img src="'.$foto_lpr.'" alt="'.$nama.'"/>
  													<div class="carousel-caption teks-hitam">
  														<h3>'.$nama.'</h3>
  														<p>'.$ciri_khusus.'</p>
  														<p>(CP: '.$contact_person.')</p>
  												</div>
  											</div>';
    }
      ++$hitung;
      ++$data;
  }
} else { //kalo datanya nggak ada
    info('danger', 'Tidak ada data untuk ditampilkan.'); //kasih info ini
}

?>

    <style>
    /* css buat setting slideshow (carouselnya) */
    img { border-width: 0; } /* ilangin bordernya biar gambarnya full */
    	* { font-family:'Lucida Grande', sans-serif; } /* font buat captionnya */

    .carousel-caption { background-image: url("assets/images/bg-slide.png"); } /* background buat foto korban (lihat gambarnya di url itu) */
    .carousel-inner>.item>img, .carousel-inner>.item>a>img { /* nyetting gambar */
      height:400px; /* tinggi maks */
      width:100%; /* lebar maks */
    }
    </style>

    <div class="container carousel slide" style="width: 100%">
      <div id="foto-korban" class="carousel slide" data-ride="carousel">
        <!-- ini slideshow yang pake indikator tadi -->
        <ol class="carousel-indicators">
        <?php echo $indikator; ?>
        </ol>

        <!-- bungkus slide -->
        <div class="carousel-inner">
        <?php echo $slide; ?>
        </div>

        <!-- kontrol kiri -->
        <a class="left carousel-control" href="#foto-korban" data-slide="prev">
          <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <!-- kontrol kiri -->
        <a class="right carousel-control" href="#foto-korban" data-slide="next">
          <span class="glyphicon glyphicon-chevron-right"></span>
        </a>

      </div>
    </div>
    <div class="clearfix"> </div>
    <hr>
    <h3>Selamat datang di Lost in Karawang!</h3>
    <hr>
    <p>
      Lost in Karawang adalah Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    <p>
      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    </p>

</div>
</div>


  <?php
  require_once 'inc/sistem/kaki.php'; //kaki
  ?>
