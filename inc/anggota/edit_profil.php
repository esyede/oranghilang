<?php
require_once 'inc/sistem/konek.php'; //sda
require_once 'inc/sistem/fungsi.php'; //sda

if (dia_admin() || dia_anggota()) { //biar cuma admin dan anggota yang bisa akses
  require_once 'inc/sistem/kepala.php'; //sda
  require_once 'inc/sistem/nav_anggota.php'; //sda

  ?>

<div class="banner">
  <h2>
    <a href="<?php echo $index;
    ?>">Beranda</a> &raquo;
    <a href="kelola.php?aksi=lihat_profil">Profil</a> &raquo;
    <span>Edit Profil</span>
  </h2>
</div>


<div class=" profile">

		<div class="profile-bottom">
			<h3><i class="fa fa-user"></i>Edit Profil</h3>
			<div class="profile-bottom-top">
			<div class="col-md-4 profile-bottom-img">
				<a href="kelola.php?aksi=ganti_foto" data-toggle="tooltip" title="Klik untuk mengganti foto"><img src="<?php echo $url_foto ?>" width="150px" height="150px" alt="Foto Profil"></a>
			</div>
			<div class="col-md-8 profile-text">
        <form action="kelola.php?aksi=edit_profil" method="post">
			<table>
				<tbody>
          <?php
          $q = mysql_query("select * from anggota where id = '".$_SESSION['id']."'"); //ambil data user ini (data kamu) dari tabel anggota
          while ($data = mysql_fetch_array($q)) { //keluarin data - datanya
           ?>
          <tr>
            <td>Nama Lengkap</td>
  				  <td>:</td>
  				  <td> <input type="text" name="e_nama_asli" value="<?php echo $data['nama_asli'];
              ?>"></td>
          </tr>

  				<tr>
  				  <td>Alamat</td>
  				  <td> :</td>
  				  <td> <textarea name="e_alamat"><?php echo $data['alamat'];
              ?></textarea></td>
  				</tr>

  				<tr>
  				  <td>Nomor Telepon </td>
  				  <td>:</td>
  				  <td> <input type="text" name="e_no_telp" value="<?php echo $data['no_telp'];
              ?>"></td>
  				</tr>
        <?php
        ++$data;
          }
    ?>
				</tbody>
      </table>
			</div>

			<div class="clearfix"></div>
			</div>
			<div class="profile-bottom-bottom">
			<div class="col-md-4 profile-fo">
			</div>
			<div class="col-md-4 profile-fo">
				<button class="btn btn-info btn-block hvr-shutter-in-horizontal" name="edit"><i class="fa fa-save"></i> Simpan</button>
			</div>
			<div class="clearfix"></div>

      <?php

      if (isset($_POST['edit'])) { //kalo tombol edit diklik
        $e_nama_asli = isset($_POST['e_nama_asli']) ? $_POST['e_nama_asli'] : null; //sda
        $e_alamat = isset($_POST['e_alamat'])    ? $_POST['e_alamat']    : null; //sda
        $e_no_telp = isset($_POST['e_no_telp'])   ? $_POST['e_no_telp']   : null; //sda

        if (empty($e_nama_asli) || empty($e_alamat) || empty($e_no_telp)) { //kalo inputannya kosong
          pesan('Error!', 'Harap isi semua formulir.', 'error'); //kasih pesan ini
        } else { //kalo nggak kosong
          //update data di database sesuai data inputan tadi. sesi 'id'-nya dipake buat nunjuk data yang mana yang akan diupdate
          $q1 = "update anggota set nama_asli = '".bersihkan($e_nama_asli)."' where id=".$_SESSION['id'].';';
            $q2 = "update anggota set alamat    = '".bersihkan($e_alamat)."' where id=".$_SESSION['id'].';';
            $q3 = "update anggota set no_telp   = '".bersihkan($e_no_telp)."' where id=".$_SESSION['id'].';';

          //jalanin kuerinya
          $sql = mysql_query($q1);
            $sql .= mysql_query($q2);
            $sql .= mysql_query($q3);
            if ($sql) { //kalo kuerinya berhasil
            $_SESSION['nama_asli'] = bersihkan($e_nama_asli); //ganti sesi 'nama' lama dgn yang baru. biar nama di pojok kanan atas ikut terupdate
            pesan('Berhasil!', 'Profil anda telah diperbarui.', 'success'); //kasih pesan
            } else { //kalo gagal
            pesan('Error!', 'Gagal memperbarui profil.', 'error'); //kasih pesan
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
} else { //sda
  require_once 'keluar.php'; //sda
}
  ?>
