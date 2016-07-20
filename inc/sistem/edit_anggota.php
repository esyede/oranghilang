<?php
ob_start(); //sda
require_once 'inc/sistem/konek.php'; //sda
require_once 'inc/sistem/fungsi.php'; //sda

if (dia_admin()) { //biar hanya admin yang boleh ngakses halaman ini
  require_once 'inc/sistem/kepala.php'; //sda
  require_once 'inc/sistem/nav_anggota.php'; //sda

  $_SESSION['agt_id'] = isset($_GET['agt_id']) ? $_GET['agt_id'] : null;//tangkap isi variabel 'agt_id' di url, lalu simpan sebagai sesi biar datanya nggak ilang waktu halaman di refresh
  //ambil data anggota yang 'id'-nya sesuai dengan $_SESSION['agt_id']
  $q = mysql_query("select * from anggota where id = '".$_SESSION['agt_id']."'");
    if (mysql_num_rows($q) > 0) { //kalo jumlah data yang ketemu lebih besar dari nol (berarti datanya ada/ketemu)
    while ($data = mysql_fetch_array($q)) { //keluarin data - datanya
      $ft = $data['foto']; //url foto
      $nm = $data['nama_asli']; //nama
      $jk = $data['jenis_kelamin']; //jenis kelamin
      $al = $data['alamat']; //alamat
      $tlp = $data['no_telp']; //nomor telp
      $lvl = $data['level']; //level (tipe user --> admin atau anggota biasa)
      ++$data; //sda
    }
        if ($lvl == 'admin') { //kalo levelnya admin
      $opsi_lvl = '<option value="admin" selected>Administrator</option>
       <option value="angota">Anggota</option>'; //opsi yang terpilih adalah 'Administrator'
        } elseif ($lvl == 'anggota') { //kalo levelnya anggota
      $opsi_lvl = '<option value="admin">Administrator</option>
       <option value="anggota" selected>Anggota</option>'; //opsi yang terpilih adalah 'Anggota'
        }

        if ($jk == 'pria') { //kalo jenis kelaminnya pria
      $opsi_jk = '<option value="pria" selected>Pria</option>
       <option value="wanita">Wanita</option>'; //opsi yang terpilih adalah 'Pria'
        } elseif ($jk == 'wanita') { //kalo jenis kelaminnya wanita
      $opsi_jk = '<option value="pria">Pria</option>
       <option value="wanita" selected>Wanita</option>'; //opsi yang terpilih adalah 'Wanita'
        }
    }
    ?>

<div class="banner">
  <h2>
    <a href="<?php echo $index;
    ?>">Beranda</a> &raquo;
    <a href="admin.php?aksi=kelola_anggota">Kelola ANggota</a> &raquo;
    <span>Edit Anggota</span>
  </h2>
</div>


<div class=" profile">

		<div class="profile-bottom">
			<h3><i class="fa fa-user"></i>Edit Anggota</h3>
			<div class="profile-bottom-top">
			<div class="col-md-4 profile-bottom-img">
				<img src="<?php echo $ft ?>" width="150px" height="150px" alt="Foto <?php echo $nm;
    ?>">
			</div>
			<div class="col-md-8 profile-text">
        <form action="admin.php?aksi=edit_anggota&amp;agt_id=2" method="post">
			<table>
				<tbody>
          <tr>
            <td>Nama Lengkap</td>
  				  <td>:</td>
  				  <td> <input type="text" name="e_nama_asli" value="<?php echo $nm;
    ?>"></td>
          </tr>

          <tr>
            <td>Jenis Kelamin</td>
  				  <td>:</td>
  				  <td>
              <select name="e_jenis_kelamin">
                <?php echo $opsi_jk;
    ?>
              </select>
            </td>
          </tr>

  				<tr>
  				  <td>Alamat</td>
  				  <td> :</td>
  				  <td> <textarea name="e_alamat"><?php echo $al;
    ?></textarea></td>
  				</tr>

  				<tr>
  				  <td>Nomor Telepon </td>
  				  <td>:</td>
  				  <td> <input type="text" name="e_no_telp" value="<?php echo $tlp;
    ?>"></td>
  				</tr>

          <tr>
            <td>Level User</td>
            <td>:</td>
            <td>
              <select name="e_level">
                <?php echo $opsi_lvl;
    ?>
              </select><br>
              <i class="teks-merah small">(Gunakan dengan hati - hati!)</i>
            </td>
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
				<button class="btn btn-info btn-block hvr-shutter-in-horizontal" name="edit"><i class="fa fa-save"></i> Simpan</button>
			</div>
			<div class="clearfix"></div>

      <?php

      if (isset($_POST['edit'])) { //kalo tombol edit diklik
        //ambil data - data inputan
        $e_nama_asli = isset($_POST['e_nama_asli'])     ? $_POST['e_nama_asli']     : null;
          $e_jenis_kelamin = isset($_POST['e_jenis_kelamin']) ? $_POST['e_jenis_kelamin'] : null;
          $e_level = isset($_POST['e_level'])         ? $_POST['e_level']         : null;
          $e_alamat = isset($_POST['e_alamat'])        ? $_POST['e_alamat']        : null;
          $e_no_telp = isset($_POST['e_no_telp'])       ? $_POST['e_no_telp']       : null;

        //cek datanya diisi semua atau nggak
        if (empty($e_nama_asli) || empty($e_alamat) || empty($e_no_telp) || empty($e_jenis_kelamin) || empty($e_level)) { //kalo formulir ada yang nggak diisi
          pesan('Error!', 'Harap isi semua formulir.', 'error'); //kasih pesan ini
        } else { //kalo formulirnya diisi semua
          //update data - data user ini di databese
          $q1 = "update anggota set nama_asli       = '".bersihkan($e_nama_asli)."' where id=".$_SESSION['agt_id'].';';
            $q2 = "update anggota set alamat          = '".bersihkan($e_alamat)."' where id=".$_SESSION['agt_id'].';';
            $q3 = "update anggota set no_telp         = '".bersihkan($e_no_telp)."' where id=".$_SESSION['agt_id'].';';
            $q4 = "update anggota set jenis_kelamin   = '".bersihkan($e_jenis_kelamin)."' where id=".$_SESSION['agt_id'].';';
            $q5 = "update anggota set level           = '".bersihkan($e_level)."' where id=".$_SESSION['agt_id'].';';

          //jalanin masing - masing kueri updatenya
          $sql = mysql_query($q1);
            $sql .= mysql_query($q2);
            $sql .= mysql_query($q3);
            $sql .= mysql_query($q4);
            $sql .= mysql_query($q5);
          //cek berhasil nggak kuerinya
          if ($sql) {  //kalo berhasil
            $_SESSION['nama_asli'] = bersihkan($e_nama_asli); //update juga sesi namanya biar nama di pojok kanan atas halaman ikut terupdate
            pesan('Berhasil!', 'Profil anggota telah diperbarui.', 'success'); //lalu kasih pesan ini
          } else { //kalo kuerinya gagal
            pesan('Error!', 'Gagal memperbarui profil.', 'error'); //kasih pesan ini
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
} else { //kalo dia bukan admin
  require_once 'keluar.php'; //keluar sana!
}
ob_end_flush();
  ?>
