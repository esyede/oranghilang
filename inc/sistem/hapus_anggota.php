<?php
ob_start(); //sda
require_once 'inc/sistem/konek.php'; //sda
require_once 'inc/sistem/fungsi.php'; //sda

if (dia_admin()) { //biar cuma admin yang bisa ngakses halaman ini
  require_once 'inc/sistem/kepala.php'; //sda
  require_once 'inc/sistem/nav_anggota.php'; //sda

  $_SESSION['agt_id'] = isset($_GET['agt_id']) ? $_GET['agt_id'] : null;//tangkap isi variabel 'lap_id' di url, lalu simpan sebagai sesi biar datanya nggak ilang waktu halaman di refresh

  //ambil semua data tabel anggota yang 'id'-nya sesuai dengan $_SESSION['lap_id']
  $q = mysql_query("select * from anggota where id = '".$_SESSION['agt_id']."'");
    if (mysql_num_rows($q) > 0) { //kalo datanya ketemu
    while ($data = mysql_fetch_array($q)) { //keluarin data - datanya
      $ft = $data['foto']; //url foto
      $nm = $data['nama_asli']; //nama
      $jk = $data['jenis_kelamin']; //jenis kelamin
      $al = $data['alamat']; //alamat
      $tlp = $data['no_telp']; //nomor telp
      $lvl = $data['level']; //level (tipe user --> admin atau anggota biasa)
      ++$data;
    }
    }
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
  				<img src="<?php echo $ft ?>" width="150px" height="150px" alt="Foto <?php echo $nm;
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
    				  <td> <?php echo $jk;
    ?></td>
    				</tr>

    				<tr>
    				  <td>Alamat</td>
    				  <td>:</td>
    				  <td> <?php echo $al;
    ?></td>
    				</tr>

            <tr>
    				  <td>No. Telp</td>
    				  <td>:</td>
    				  <td> <?php echo $tlp;
    ?></td>
    				</tr>

            <tr>
    				  <td>Level</td>
    				  <td>:</td>
    				  <td> <?php echo ucfirst($lvl);
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
  				<button class="btn btn-info btn-block hvr-shutter-in-horizontal" name="hapus"><i class="fa fa-trash"></i> Hapus Anggota</button>
  			</div>
  			<div class="clearfix"></div>

        <?php

        if (isset($_POST['hapus'])) { //kalo tombol hapus diklik
          $q = mysql_query("delete from anggota where id = '".$_SESSION['agt_id']."'"); //hapus data anggota yang id-nya sama dengan yang kita catat di sesi agt_id tadi
          if ($q) { //kalo kuerinya berhasil
            header('Location: admin.php?aksi=kelola_anggota'); //langsung balikin ke halaman kelola anggota
          } else { //kalo kuerinya gagal
            pesan('Error!', 'Gagal menghapus data pelaporan.', 'error'); //kasih pesan ini
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
} else { //kalo dia bukan admin
  require_once 'keluar.php'; //keluar sana!
}
ob_end_flush();
  ?>
