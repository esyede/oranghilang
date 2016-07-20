<?php
require_once 'inc/sistem/konek.php'; //sda
require_once 'inc/sistem/fungsi.php'; //sda

if (dia_admin() || dia_anggota()) { //biar cuma admin dan anggota yang bisa akses
  require_once 'inc/sistem/kepala.php'; //sda
  require_once 'inc/sistem/nav_anggota.php'; //sda

  //hitung jumlah laporan milik user ini
  $q = mysql_query("select count(*) as jumlah from pelaporan where id_pelapor='".$_SESSION['id']."'");
    $dt = mysql_fetch_assoc($q); //ambil hasilnya

  //ambil data - data profil milik anggota ini
  $q = mysql_query("select * from anggota where id='".$_SESSION['id']."'");
    if (mysql_num_rows($q) > 0) { //kalo datanya ada (lebih besar dari nol)
    while ($data = mysql_fetch_array($q)) { //keluarin data - datanya
      $url_foto = $data['foto']; //url foto
      $nama_asli = $data['nama_asli']; //nama
      $username = $data['username']; //username
      $jenis_kelamin = $data['jenis_kelamin']; //jenis kelamin
      $level = $data['level']; //level (tipe user --> admin atau anggota biasa)
      $alamat = $data['alamat']; //alamat
      $no_telp = $data['no_telp']; //nomor telepon
      ++$data; //increment biat nggak infinite loop
    }
    }

    ?>

   <div class="banner">
     <h2>
       <a href="<?php echo $index;
    ?>">Beranda</a>
       &raquo;
       <span>Profil Saya</span>
     </h2>
   </div>



  <div class=" profile">

  		<div class="profile-bottom">
  			<h3><i class="fa fa-user"></i>Profil Anggota</h3>
  			<div class="profile-bottom-top">
  			<div class="col-md-4 profile-bottom-img">
  				<a href="kelola.php?aksi=ganti_foto" data-toggle="tooltip" title="Klik untuk mengganti foto"><img src="<?php echo $url_foto ?>" width="150px" height="150px" alt="Foto Profil"></a>
  			</div>
  			<div class="col-md-8 profile-text">
  				<h6><?php echo $nama_asli;
    ?></h6>
  				<table>
  				<tbody><tr><td>Nama Pengguna</td>
  				<td>:</td>
  				<td><?php echo $username;
    ?></td></tr>
          <tr>
  				<td>Jenis Kelamin</td>
  				<td> :</td>
  				<td><?php echo ucfirst($jenis_kelamin);
    ?>
  				</tr>
  				<tr>
  				<td>Level</td>
  				<td> :</td>
  				<td><?php echo ucfirst($level);
    ?>
  				</tr>
  				<tr>
  				<td>Alamat</td>
  				<td> :</td>
  				<td> <?php echo $alamat;
    ?></td>
  				</tr>
  				<tr>
  				<td>Nomor Telepon </td>
  				<td>:</td>
  				<td><?php echo $no_telp;
    ?></td>
  				</tr>
  				<tr>
  				<td>Jumlah Laporan </td>
  				<td>:</td>
  				<td><a href="kelola.php?aksi=laporan_saya"><?php echo $dt['jumlah'];
    ?> Kali</a></td>
  				</tr>
  				</tbody></table>
  			</div>
  			<div class="clearfix"></div>
  			</div>
  			<div class="profile-bottom-bottom">
  			<div class="col-md-4 profile-fo">
  			</div>
  			<div class="col-md-4 profile-fo">
  				<a href="kelola.php?aksi=edit_profil&amp;id=<?php echo $_SESSION['id'];
    ?>" class="pro1"><i class="fa fa-wrench"></i>Edit Profil</a>
  			</div>
  			<div class="col-md-4 profile-fo">
  				<a href="kelola.php?aksi=ganti_sandi"><i class="fa fa-cog"></i>Ganti Sandi</a>
  			</div>
  			<div class="clearfix"></div>
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
} else { //kalo dia bukan admin atau anggota
    require_once 'keluar.php'; //keluar sana!
}
   ?>
