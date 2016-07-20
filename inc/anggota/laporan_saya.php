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
    <span>Laporan Saya</span>
  </h2>
</div>



<div class="validation-system">
  <div class="validation-form">

      <?php
      //ambil semua laporan milik user ini, urutkan hasilnya berdasarkan tanggal lapornya
        $q = mysql_query("select * from pelaporan where id_pelapor='".$_SESSION['id']."' order by tanggal_lapor desc");
    $ada = mysql_num_rows($q); //cek ada nggak data yang cocok
        if ($ada > 0) { //kalo ada yang cocok
          echo '
          <table class="table table-hover">
            <thead>
              <tr>
                <th class="text text-info">Foto</th>
                <th class="text text-info">Nama</th>
                <th class="text text-info">Lokasi</th>
                <th class="text text-info">Hilang</th>
                <th class="text text-info">Ciri Khusus</th>
                <th class="text text-info">Dilaporkan</th>
                <th class="text text-info">CP</th>
                <th class="text text-info">Status</th>
                <th class="text text-info">Kelola</th>
              </tr>
            </thead>
            <tbody>';
            while ($data = mysql_fetch_array($q)) { //keluarin data - datanya

            if ($data['tipe_pelaporan'] == 'hilang') {
                $tipe = '<font color="red">Hilang</font>';
            } //kasih warna merah kalo hilang
            elseif ($data['tipe_pelaporan'] == 'ditemukan') {
                $tipe = '<font color="lime">Ditemukan</font>';
            } //kasih warna ijo muda kalo ditemukan

            echo '
           <tr>
             <td><img src="'.$data['foto_lpr'].'" alt="foto" width="100px" height="100px"/></td>
             <td>'.$data['nama'].' ('.ucfirst($data['jenis_kelamin']).')</td>
             <td>'.$data['lokasi_hilang'].'</td>
             <td>'.substr($data['tanggal_hilang'], 0, 10).'</td>
             <td>'.$data['ciri_khusus'].'</td>
             <td>'.substr($data['tanggal_lapor'], 0, 10).'</td>
             <td>'.$data['contact_person'].'</td>
             <td>'.$tipe.'</td>
             <td>
             <div class="float-right">
             <div class="dropdown">
                 <a href="#" title="" class="btn btn-primary" data-toggle="dropdown" aria-expanded="false">
                     Aksi
                     <i class="fa fa-chevron-down icon_8"></i>
                 <div class="ripple-wrapper"></div></a>
                 <ul class="dropdown-menu float-right">
                     <li>
                         <a href="kelola.php?aksi=lap_edit&amp;lap_id='.$data['id'].'" title="edit data ini"><i class="fa fa-pencil-square-o icon_9"></i>Edit</a>
                     </li>
                     <li>
                         <a href="kelola.php?aksi=lap_hapus&amp;lap_id='.$data['id'].'" title="hapus data ini"><i class="fa fa-trash-o icon_9"></i>Hapus</a>
                     </li>
                 </ul>
               </div>
             </div>
             </td>
           </tr>';
                ++$data;
            }
        } else { //kalo nggak ada data yang cocok
          info('danger', 'Belum ada laporan yang dibuat. Klik <a class="btn btn-danger btn-xs" href="kelola.php?aksi=buat_laporan_kehilangan">disini</a> untuk membuat laporan.'); //kasih pesan ini
          echo '<br><br><br><br><br><br><br><br><br><br><br><br>';
        }
    ?>
      </tbody>
  </table>
</div>

</div>
 <?php
require_once 'inc/sistem/kaki.php'; //sda
} else { //kalo dia bukan admin atau anggota
  require_once 'keluar.php'; //keluar sana!
}
  ?>
