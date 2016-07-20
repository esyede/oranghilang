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
    <a href="#">Data Pelaporan</a>
    &raquo;
    <span>Cari Tanggal</span>
  </h2>
</div>



<div class="validation-system">
  <div class="validation-form">
    <?php
    //manngil fungsi info buat nampilin panduan pengisian tanggal
    info('info', 'Klik pada ikon <i class="fa fa-calendar"></i> untuk memilih tanggal.');
    ?>
    <div class="vali-form">
      <link rel="stylesheet" href="assets/css/datetimepicker.min.css">
  <script type="text/javascript" src="assets/js/moment-2.2.1.js"></script>
  <script type="text/javascript" src="assets/js/datetimepicker.min.js"></script>
  <!-- form pilih rentang tanggal -->
  <form class="form-inline" action="kelola.php?aksi=cari_tanggal" method="post">
  <div id="tgl_mulai" class="form-group input-append">
    <input class="form-control" data-format="yyyy-MM-dd" type="text" name="tgl_mulai" placeholder="mulai tanggal.."></input>
    <span class="add-on">
      <i data-time-icon="fa fa-calendar icon-time" data-date-icon="fa fa-calendar icon-calendar">
      </i>
    </span>
  </div>
  <div id="tgl_sampai" class="form-group input-append">
    <input class="form-control" data-format="yyyy-MM-dd" type="text" name="tgl_sampai" placeholder="sampai tanggal.."></input>
    <span class="add-on">
      <i data-time-icon="fa fa-calendar icon-time" data-date-icon="fa fa-calendar icon-calendar">
      </i>
    </span>
  </div>
  <input class="form-control btn btn-success" type="submit" name="sortir" value="Lihat">
<script type="text/javascript">
  //js buat nampilin date picker
  $(function() {
    $('#tgl_mulai').datetimepicker({
      pickTime: false
    });
  });
  $(function() {
    $('#tgl_sampai').datetimepicker({
      pickTime: false
    });
  });
</script>


<?php
$teks = ''; //deklarasi var. teks buat nyimpen teks pesan
if (isset($_POST['sortir'])) { //kalo tombol 'sortir' diklik
//ambil datanya dan gunakan isset() buat buang undefined index
  $tgl_mulai = isset($_POST['tgl_mulai'])    ?  $_POST['tgl_mulai']    : '';
    $tgl_sampai = isset($_POST['tgl_sampai'])   ?  $_POST['tgl_sampai']   : '';

    $tgl_mulai = bersihkan($tgl_mulai); //buang karakter - karakter khusus
  $tgl_sampai = bersihkan($tgl_sampai); //sama

  if (empty($tgl_mulai) || empty($tgl_sampai)) { //kalo tanggalnya dikosongin
    $teks = info('success', 'Rentang tanggal dikosongkan, Menampilkan semua data.'); //kasih pesan ini
    $q = mysql_query('select * from pelaporan inner join anggota on pelaporan.id_pelapor = anggota.id order by pelaporan.tanggal_lapor desc'); //ambil semua data di tabel pelaporan
  } else { //kalo rentang tanggalnya diisi
    $teks = info('success', 'Menampilkan data dari '.$tgl_mulai.' sampai '.$tgl_sampai); //sda
    //ambil data yang rentang 'tanggal_lapor'-nya diantara $tgl_mulai dan $tgl_sampai
    $q = mysql_query("select * from pelaporan inner join anggota on pelaporan.id_pelapor = anggota.id where (pelaporan.tanggal_lapor >= '".$tgl_mulai."' and pelaporan.tanggal_lapor <= '".$tgl_sampai."') or (pelaporan.tanggal_hilang >= '".$tgl_mulai."' and pelaporan.tanggal_hilang <= '".$tgl_sampai."') order by pelaporan.tanggal_lapor desc");
  }
}

    ?>
 <div class="clearfix"> </div>
</form>
<?php
  //nampilin isi var. teks
  echo $teks;
    ?>
  <table class="table table-hover">
    <thead>
      <tr>
        <th class="text text-info">Foto</th>
        <th class="text text-info">Nama</th>
        <th class="text text-info">J/K</th>
        <th class="text text-info">Lokasi</th>
        <th class="text text-info">Hilang</th>
        <th class="text text-info">Ciri Khusus</th>
        <th class="text text-info">Pelapor</th>
        <th class="text text-info">Dilaporkan</th>
        <th class="text text-info">CP</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $ada = mysql_num_rows($q); //cek berapa data hasil query $q yang cocok
        if ($ada > 0) { //kalo ada yang cocok ($ada lebih besar dari nol)
          $i = 1; //buat nomor baris di tabel
          while ($data = mysql_fetch_array($q)) { //ambil data datanya
            echo '
           <tr>
             <td><img src="'.$data['foto_lpr'].'" alt="foto laporan" width="100px" height="100px"/></td>
             <td>'.$data['nama'].'</td>
             <td>'.ucfirst($data['jenis_kelamin']).'</td>
             <td>'.$data['lokasi_hilang'].'</td>
             <td>'.$data['tanggal_hilang'].'</td>
             <td>'.$data['ciri_khusus'].'</td>
             <td>'.$data['nama_asli'].'</td>
             <td>'.substr($data['tanggal_lapor'], 0, 10).'</td>
             <td>'.$data['contact_person'].'</td>
           </tr>';
              ++$data;
          }
            echo '</tbody>';
        } else { //kalo nggak ada yang cocok
          echo '<br><br>';
            pesan('Error!', 'Tidak ditemukan data pada rentang tanggal ini.', 'error'); //kasih pesan ini
          echo '<br><br><br><br><br><br><br><br><br><br><br><br>';
        }
    ?>

  </table>
</div>

</div>
 <?php
require_once 'inc/sistem/kaki.php'; //kaki
} else { //kalo dia bukan admin atau anggota
  require_once 'keluar.php'; //keluar
}
  ?>
