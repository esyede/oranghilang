<?php
ob_start(); //sda
require_once 'inc/sistem/konek.php'; //sda
require_once 'inc/sistem/fungsi.php'; //sda

if (dia_admin() || dia_anggota()) { //biar yang bisa akses cuma admin dan anggota saja
  require_once 'inc/sistem/kepala.php'; //sda
  require_once 'inc/sistem/nav_anggota.php'; //sda

  $_SESSION['lap_id'] = isset($_GET['id']) ? $_GET['id'] : ''; //tangkap isi variabel 'lap_id' di url, lalu simpan sebagai sesi biar datanya nggak ilang waktu halaman di refresh

  //ambil semua data orang hilang yang 'id'-nya sesuai dengan $_SESSION['lap_id']
  $q = mysql_query("select * from pelaporan where id = '".$_SESSION['lap_id']."'");
    if (mysql_num_rows($q) > 0) { //kalo datanya ketemu
    while ($dt = mysql_fetch_array($q)) { //keluarin data - datanya
      $_SESSION['foto_korban'] = $dt['foto_lpr']; //url foto korban
      $_SESSION['nama_korban'] = $dt['nama']; //nama
      $_SESSION['contact_person'] = $dt['contact_person']; //kontak
      ++$dt; //increment biar nggak infinite loop
    }
    }
    ?>

<div class="banner">
  <h2>
    <a href="<?php echo $index;
    ?>">Beranda</a> &raquo;
    <a href="kelola.php?aksi=buat_laporan_ditemukan">Laporan Ditekuman</a> &raquo;
    <span>Verifikasi Data</span>
  </h2>
</div>


<div class=" profile">

		<div class="profile-bottom">
			<h3><i class="fa fa-user"></i>Verifikasi Penemuan Orang</h3>
			<div class="profile-bottom-top">
			<div class="col-md-4 profile-bottom-img">
				<img src="<?php echo $_SESSION['foto_korban'];
    ?>" width="150px" height="150px" alt="Foto Korban">
			</div>
			<div class="col-md-8 profile-text">
        <form action="" method="post">
			<table>
				<tbody>
          <tr>
          <?php
          //banner informasi
          info('info', 'Data penemu diambil dari data akun anda.');
    ?>
            <td>Nama Korban</td>
  				  <td>:</td>
  				  <td> <input type="text" value="<?php echo $_SESSION['nama_korban'];
    ?>" disabled=""></td>
          </tr>

  				<tr>
  				  <td>Kontak Keluarga Korban</td>
  				  <td>:</td>
  				  <td> <input type="text" value="<?php echo $_SESSION['contact_person'];
    ?>" disabled=""></td>
  				</tr>

  				<tr>
  				  <td>Lokasi Penemuan Korban</td>
  				  <td> :</td>
  				  <td> <textarea name="lokasi_ketemu" placeholder="lokasi penemuan korban.." required="" autofocus></textarea></td>
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
				<button class="btn btn-info btn-block hvr-shutter-in-horizontal" name="verifikasi"><i class="fa fa-key"></i> Verifikasi</button>
			</div>
			<div class="clearfix"></div>

      <?php

      if (isset($_POST['verifikasi'])) { //kalo tombol verifikasi diklik
        $lokasi_ketemu = isset($_POST['lokasi_ketemu']) ? $_POST['lokasi_ketemu'] : null; //ambil inputan lokasi_ketemu
        $tanggal_skrg = date('Y-m-d H:i:s'); //ambil tanggal saat ini
        $id_penemu = $_SESSION['id']; //ambil id dari sesi id-kita. Jadi konsepnya, jika anda melaporkan verifikasi penemuan orang. maka anda adalah pelapornya

        if (empty($lokasi_ketemu)) { //kalo inputan lokasi ketemu dikosongin
          pesan('Error!', 'Harap isi lokasi ditemukan. Data yang lain menyesuaikan data akun anda.', 'error'); //kasih pesan ini
        } else { //kalo ada isinya
          //update data di database
          $q = "update pelaporan set lokasi_ketemu = '".mysql_real_escape_string($lokasi_ketemu)."',
                 tanggal_ketemu    = '".mysql_real_escape_string($tanggal_skrg)."',
                 id_penemu   = '".mysql_real_escape_string($id_penemu)."',
                 tipe_pelaporan   = 'ditemukan' where id = '".$_SESSION['lap_id']."';";

            $sql = mysql_query($q); //jalanin updatenya
          if ($sql) { //kalo updatenya berhasil
            pesan('Berhasil!', 'Anda telah mem-verifikasi laporan penemuan', 'success'); //kasih pesan ini
          } else { //kalo gagal
            pesan('Error!', 'Gagal mem-verifikasi laporan penemuan'.mysql_error(), 'error'); //kasih pesan ini
          }
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
} else { //kalo bukan admin atau anggota
  require_once 'keluar.php'; //sda
}
ob_end_flush(); //sda
  ?>
