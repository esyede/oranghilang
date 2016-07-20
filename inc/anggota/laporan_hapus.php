<?php
ob_start(); //mulai output buffer
require_once 'inc/sistem/konek.php'; //sda
require_once 'inc/sistem/fungsi.php'; //sda

if (dia_admin() || dia_anggota()) { //biar cuma admin dan anggota yang bisa akses
  require_once 'inc/sistem/kepala.php'; //sda
  require_once 'inc/sistem/nav_anggota.php'; //sda

  $_SESSION['lap_id'] = isset($_GET['lap_id']) ? $_GET['lap_id'] : null; //tangkap isi variabel 'lap_id' di url, lalu simpan sebagai sesi biar datanya nggak ilang waktu halaman di refresh

  //ambil data pelaporan yang 'id'-nya sesuai dengan $_SESSION['lap_id']
  $q = mysql_query("select * from pelaporan where id = '".$_SESSION['lap_id']."'");
    if (mysql_num_rows($q) > 0) { //kalo datanya ketemu
      while ($data = mysql_fetch_array($q)) { //keluarin data - datanya
        $nm = $data['nama']; //nama
        $jk = $data['jenis_kelamin']; //jenis kelamin
        $lh = $data['lokasi_hilang']; //lokasi hilang
        $ck = $data['ciri_khusus']; //ciri khusus
        $ft = $data['foto_lpr']; //url foto
        $cp = $data['contact_person']; //kontak person
        $id_pelapor = $data['id_pelapor']; //id pelapor
      ++$data; //sda
      }
    }

  //Disini kami coba menyeting supaya yang bisa menghapus data hanya anggota yang melaporkan korban atau admin. selain itu tidak boleh. caranya:
  if (dia_admin() || (dia_anggota() && $_SESSION['id'] == $id_pelapor)) { //jika dia admin atau dia-anggota-dan-id-anggotanya sama dengan id pelapor maka bolehkan dia mengakses formulir penghapusan
    ?>
  <div class="banner">
    <h2>
      <a href="<?php echo $index;
      ?>">Beranda</a> &raquo;
      <a href="kelola.php?aksi=laporan_saya">Data Pelaporan</a> &raquo;
      <span>Hapus Laporan</span>
    </h2>
  </div>


  <div class=" profile">

  		<div class="profile-bottom">
  			<h3><i class="fa fa-user"></i>Menghapus Laporan</h3>
  			<div class="profile-bottom-top">
  			<div class="col-md-4 profile-bottom-img">
  				<img src="<?php echo $ft ?>" width="150px" height="150px" alt="<?php echo $nm;
      ?>">
  			</div>
  			<div class="col-md-8 profile-text">
          <form action="" method="post">
  			<table>
  				<tbody>
            <tr>
              <td>Nama Lengkap</td>
    				  <td>:</td>
    				  <td> <?php echo $nm;
      ?></td>
            </tr>

    				<tr>
    				  <td>Jenis Kelamin</td>
    				  <td> :</td>
    				  <td> <?php echo ucfirst($jk);
      ?></td>
    				</tr>

    				<tr>
    				  <td>Lokasi Hilang</td>
    				  <td>:</td>
    				  <td> <?php echo $lh;
      ?></td>
    				</tr>

            <tr>
    				  <td>Contact Person</td>
    				  <td>:</td>
    				  <td> <?php echo $cp;
      ?></td>
    				</tr>
  				</tbody>
        </table>
  			</div>

  			<div class="clearfix"></div>
  			</div>
  			<div class="profile-bottom-bottom">
  			<div class="col-md-4 profile-fo">
  			</div>
  			<div class="col-md-4 profile-fo">
  				<button class="btn btn-info btn-block hvr-shutter-in-horizontal" name="hapus"><i class="fa fa-trash"></i> Hapus</button>
  			</div>
  			<div class="clearfix"></div>

        <?php

        if (isset($_POST['hapus'])) { //kalo tombol hapus diklik
          //hapus data pelaporan yang id-nya sama dengan $_SESSION['lap_id']
          $q = mysql_query("delete from pelaporan where id = '".$_SESSION['lap_id']."'");
            if ($q) { //kalo kuerinya berhasil
              if (dia_admin()) {
                  header('Location: kelola.php?aksi=semua_laporan');
              } //kalo dia administrator, langsung balikin ke halaman semua laporan
              elseif (dia_anggota()) {
                  header('Location: kelola.php?aksi=laporan_saya');
              } //kalo dia anggota, langsung balikin ke halaman laporan dia
            } else { //kalo kuerinya gagal
            pesan('Error!', 'Gagal menghapus data pelaporan. Pesan: '.mysql_error(), 'error'); //kasih pesan ini
            }
        }
      ?>

    </form>
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
  } else { //kalo dia bukan admin atau user pelapor korban
    header('Location: kelola.php?aksi=laporan_saya'); //balikin ke halaman daftar laporan dia
  }
} else { //kalo dia bukan admin atau anggota
  require_once 'keluar.php'; //keluar sana!
}
ob_end_flush(); //bersihin output buffernya
  ?>
