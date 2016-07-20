<?php

$keyword = $_POST['keyword']; //ambil data POST 'keyword' dari file 'cari.nama.php'
if (empty($keyword)) { //kalo keyword kosong
    echo ''; //nggak usah ngapa - ngapain
} else { //kalo ada inputan di form pencarian, kode ini akan di eksekusi setiap ada perubahan inputan di form pencarian
  echo "<div id='tempat_hasil'>"; //ini div buat nampung tampilan hasil pencarian
  //kalo ada teks di form input nama, js CariData() akan mengubah isi div ini sesuai data yang ketemu saat pencarian
  //dan hasilnya akan berubah ubah setuap inputannya diubah

  //ini kueri buat nyari datanya di database
  $q = mysql_query(" select * from pelaporan  where nama like '".$keyword."%'"); //cari dan ambil data dari tabel 'pelaporan' yang kolom 'nama'-nya diawali dengan isi variabel $keyword

  echo '<table class="table table-hover">
  <thead>
        <tr>
          <th class="text text-info">Foto</th>
          <th class="text text-info">Nama</th>
          <th class="text text-info">J/K</th>
          <th class="text text-info">Lokasi</th>
          <th class="text text-info">Hilang</th>
          <th class="text text-info">Ciri Khusus</th>
          <th class="text text-info">Dilaporkan</th>
          <th class="text text-info">CP</th>
      </thead>';

    echo '<tbody>';
    while ($data = mysql_fetch_array($q)) { //tampilin data - datanya
    echo '
   <tr>
     <td><img src="'.$data['foto_lpr'].'" alt="foto" width="100px" height="100px"/></td>
     <td>'.$data['nama'].'</td>
     <td>'.ucfirst($data['jenis_kelamin']).'</td>
     <td>'.$data['lokasi_hilang'].'</td>
     <td>'.$data['tanggal_hilang'].'</td>
     <td>'.$data['ciri_khusus'].'</td>
     <td>'.substr($data['tanggal_lapor'], 0, 10).'</td>
     <td>'.$data['contact_person'].'</td>
   </tr>';
        ++$data;
    }
    echo '</div>';
}
