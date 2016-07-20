<?php
require_once 'inc/sistem/konek.php'; //sda
require_once 'inc/sistem/fungsi.php'; //sda
if (!isset($_SESSION)) { //sda
  session_start(); //sda
}

if (dia_admin()) { //biar cuma admin yang bisa ngakses halaman ini
  require_once 'inc/sistem/kepala.php'; //sda
  require_once 'inc/sistem/nav_anggota.php'; //sda
?>

<div class="banner">
  <h2>
    <a href="<?php echo $index;
    ?>">Beranda</a>
    &raquo;
    <a href="#">Menu Admin</a>
    &raquo;
    <span>Kelola Anggota</span>
  </h2>
</div>



<div class="validation-system">
  <div class="validation-form">
  <table class="table table-hover">
    <thead>
      <tr>
        <th class="text text-info">Foto</th>
        <th class="text text-info">Nama</th>
        <th class="text text-info">J/K</th>
        <th class="text text-info">Alamat</th>
        <th class="text text-info">No. Telp.</th>
        <th class="text text-info">Username</th>
        <th class="text text-info">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php
      //ambil semua data di tabel anggota yang levelnya 'anggota'
        $q = mysql_query("select * from anggota where level = 'anggota' order by id desc");
    $ada = mysql_num_rows($q); //cek berapa data yang ketemu
        if ($ada > 0) { //kalo yang ketemu lebih besar dari nol (berarti datanya ada)
          $i = 1; //buat nomor baris di tabel html kita
          while ($data = mysql_fetch_array($q)) { //keluarin data - datanya
            echo '
           <tr>
             <td><img src="'.$data['foto'].'" alt="foto anggota" width="100px" height="100px"/></td>
             <td>'.$data['nama_asli'].'</td>
             <td>'.ucfirst($data['jenis_kelamin']).'</td>
             <td>'.$data['alamat'].'</td>
             <td>'.$data['no_telp'].'</td>
             <td>'.$data['username'].'</td>
             <td>
             <div class="float-right">
             <div class="dropdown">
                 <a href="#" title="" class="btn btn-primary" data-toggle="dropdown" aria-expanded="false">
                     Aksi
                     <i class="fa fa-chevron-down icon_8"></i>
                 <div class="ripple-wrapper"></div></a>
                 <ul class="dropdown-menu float-right">
                     <li>
                         <a href="admin.php?aksi=edit_anggota&amp;agt_id='.$data['id'].'" title="edit data ini"><i class="fa fa-pencil-square-o icon_9"></i>Edit</a>
                     </li>
                     <li>
                         <a href="admin.php?aksi=hapus_anggota&amp;agt_id='.$data['id'].'" title="hapus data ini"><i class="fa fa-trash-o icon_9"></i>Hapus</a>
                     </li>
                 </ul>
               </div>
             </div>
           </tr>';
              ++$data;
          }
            echo '</tbody>';
        } else { //kalo nggak ada data yang cocok
          info('danger', 'Belum ada anggota yang terdaftar.');
            echo '<br><br><br><br><br><br><br><br><br><br><br><br>';
        }
    ?>

  </table>
</div>

</div>
 <?php
require_once 'inc/sistem/kaki.php'; //sda
} else { //kalo bukan admin
  require_once 'keluar.php'; //keluar sana!
}
  ?>
