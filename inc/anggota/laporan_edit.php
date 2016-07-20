<?php
ob_start(); //sda
require_once 'inc/sistem/konek.php'; //sda
require_once 'inc/sistem/fungsi.php'; //sda

if (dia_admin() || dia_anggota()) { //biar cuma admin dan anggota yang bisa akses
  require_once 'inc/sistem/kepala.php'; //sda
  require_once 'inc/sistem/nav_anggota.php'; //sda

  $pesan = ''; //var pesan buat nampilin pesan

  $_SESSION['lap_id'] = isset($_GET['lap_id']) ? $_GET['lap_id'] : null; //tangkap isi variabel 'lap_id' di url, lalu simpan sebagai sesi biar datanya nggak ilang waktu halaman di refresh

  //ambil data pelaporan yang 'id'-nya sesuai dengan $_SESSION['lap_id']
  $q = mysql_query("select * from pelaporan where id = '".$_SESSION['lap_id']."'");
    if (mysql_num_rows($q) > 0) { //kalo datanya ketemu
    while ($data = mysql_fetch_array($q)) { //keluarin data - datanya
      $nm = $data['nama']; //nama
      $jk = $data['jenis_kelamin']; //jenis kelamin
      $lh = $data['lokasi_hilang']; //lokasi hilang
      $ck = $data['ciri_khusus']; //ciri khusus
      $ft = $data['foto_lpr']; //url foto korban
      $cp = $data['contact_person']; //kontak
      $id_pelapor = $data['id_pelapor']; //id pelapor
      ++$data; //sda
    }
        if ($jk == 'pria') { //kalo jenis nkelaminnya 'pria'
      $opsi = '<option value="pria" selected>Pria</option>
       <option value="wanita">Wanita</option>'; //opsinya yang terpilih yang 'pria'
        } elseif ($jk == 'wanita') { //kalo jenis nkelaminnya 'wanita'
      $opsi = '<option value="pria">Pria</option>
       <option value="wanita" selected>Wanita</option>'; //opsinya yang terpilih yang 'wanita'
        }
    }

//ini buat ngatur hak akses editing data pelaporan.  Kami set agar yang bisa melakukan editing data HANYA orang yang melaporkan korban saja
//admin dan user lain tidak diperbolehkan
if ($_SESSION['id'] == $id_pelapor) { //kalo dia yang ngelaporin korban ini, bolehin di ngedit data korban
  //dibawah ini formulir buat ngedit data korban

  if (isset($_POST['edit'])) { //kalo tombol 'edit' di klik
   //ambil data - data inputannya
   $nama_korban = isset($_POST['nama_korban'])    ? $_POST['nama_korban']     : ''; //nama korban
   $contact_person = isset($_POST['contact_person']) ? $_POST['contact_person']  : ''; //kontak person
   $jenis_kelamin = isset($_POST['jenis_kelamin'])  ? $_POST['jenis_kelamin']   : ''; //jenis kelamin korban
   $lokasi_hilang = isset($_POST['lokasi_hilang'])  ? $_POST['lokasi_hilang']   : ''; //lokasi hilang korban
   $ciri_khusus = isset($_POST['ciri_khusus'])    ? $_POST['ciri_khusus']     : ''; //ciri khusus korban

   //UNTUK PANDUAN KOMENTAR, LIHAT FILE /inc/anggota/ganti_foto.php. LANGKAHNYA SAMA
   //SELANJUTNYA LANGKAH - LANGKAH YANG SAMA AKAN DITULIS DENGAN '//sda'

   if ($_FILES['foto_korban']['size'] > 1024 && $_FILES['foto_korban']['size'] < 1048576) { // kalo file foto lebih besar dari 1024 byte (1 KB) dan kurang dari 1048576 byte (1 MB). upload OK!
       //cek inputanya diisi semua atau nggak
       if (!empty($nama_korban) || !empty($contact_person) || !empty($jenis_kelamin) || !empty($lokasi_hilang) || !empty($ciri_khusus)) { //kalo diisi semua
         //inputan file
         $f_nama = $_FILES['foto_korban']['name'];
           $f_nm_tmp = $_FILES['foto_korban']['tmp_name']; //nama sementara filenya. karena defaultnya, di server file upload sebelum dipindahkan akan ditaruh di folder /tmp/ (linux/unix) dengan session id sebagai nama defaultnya (sesi ini otomatis digenerate oleh si php)
         $f_ukuran = $_FILES['foto_korban']['size']; //ukuran
         $f_tipe = pathinfo($f_nama, PATHINFO_EXTENSION); //ekstensi (tipe filenya)
         $f_tipe = (get_magic_quotes_gpc() == 0 ? mysql_real_escape_string(pathinfo($f_nama, PATHINFO_EXTENSION)) : mysql_real_escape_string(stripslashes($_FILES['foto_korban'])));

         //tipe diizinkan
         $tipe_ok = array('jpg', 'png', 'gif');

         //inputan string, bersihkan
         $nama_korban = bersihkan($nama_korban); //sda
         $contact_person = bersihkan($contact_person); //sda
         $jenis_kelamin = bersihkan($jenis_kelamin); //sda
         $lokasi_hilang = bersihkan($lokasi_hilang); //sda
         $ciri_khusus = bersihkan($ciri_khusus); //sda

         if (!get_magic_quotes_gpc()) {
             $f_nama = addslashes($f_nama);
         } //sda

         if (in_array($f_tipe, $tipe_ok)) { //jika tipenya diijinkan
           $f_nama = str_replace(' ', '_', $f_nama); //sda
           $f_nama = preg_replace('/[^a-zA-Z0-9_.-]/', '', $f_nama); //sda
           $f_nama = bersihkan($f_nama); //sda
           $acak = rand(0, 99999); //ini buat ngacak nonor. hasilnya 5 digit angka antara 0 sampai 99999. misal hasilnya '674552'. Ini nanti akan ditempel ke nama file foto laporan korban
           $url = 'foto/agt-'.$_SESSION['id'].'/Lap_'.$acak.'.'.$f_tipe; //misal id usernya '1' dan angka acaknya '674552' maka urlnya menjadi 'foto/agt-1/Lap_674552.ekstensi (jpg/png/gif)'
           $pndh = move_uploaded_file($f_nm_tmp, $url); //sda
           chmod($url, 0666); //sda

           if (file_exists($ft)) { //kalo ternyata file foto sudah ada sebelumnya
             unlink($ft); //hapus dulu file foto yang lama
           }

             if ($pndh) { //coba pindahin filenya, dan kalo Berhasil..
             //lanjutin ndengan mengupdate data di databasenya
             $sql1 = "update pelaporan set foto_lpr           = '".$url."'             where id = ".$_SESSION['lap_id'].';';
                 $sql2 = "update pelaporan set nama           = '".$nama_korban."'     where id = ".$_SESSION['lap_id'].';';
                 $sql3 = "update pelaporan set jenis_kelamin  = '".$jenis_kelamin."'   where id = ".$_SESSION['lap_id'].';';
                 $sql4 = "update pelaporan set contact_person = '".$contact_person."'  where id = ".$_SESSION['lap_id'].';';
                 $sql5 = "update pelaporan set lokasi_hilang  = '".$lokasi_hilang."'   where id = ".$_SESSION['lap_id'].';';
                 $sql6 = "update pelaporan set ciri_khusus    = '".$ciri_khusus."'     where id = ".$_SESSION['lap_id'].';';

             //jalanin masing - masing perintah updatenya (sql1 sampai 6)
             $q   = mysql_query($sql1);
             $q  .= mysql_query($sql2);
             $q  .= mysql_query($sql3);
             $q  .= mysql_query($sql4);
             $q  .= mysql_query($sql5);
             $q  .= mysql_query($sql6);

                 if ($q) { //kalo kuerinya berhasil
               $pesan = pesan('Berhasil!', 'Data anda telah disimpan..', 'success'); //kasih pesan ini
                 } else { //kalo kuerinya gagal
               $pesan = pesan('Error!', 'Upload gagal. Kesalalahn query ke database.', 'error'); //kasih pesan ini
               //karena kuerinya gagal, hapus lagi file foto yang udah diupload tadi biar hemat hardisk. caranya:
               if (file_exists($url)) { //cek ada nggak filenya. kalo ada..
                 unlink($url); //hapus filenya
               }
                 }
             } else { //kalo filenya gagal dipindahin
             $pesan = pesan('Error!', 'Gagal memindahkan berkas. cek hak akses di server', 'error'); //kasih pesan ini
             }
         } else { //kalo formatnya bukan jpg, png atau gif
             $pesan = pesan('Error!', 'Berkas tipe ini tidak diijinkan. Yang diijinkan hanya JPG, PNG dan GIF.', 'error'); //kasih pesan ini
         }
       } else { //kalo formulir nggak diisi semua
         $pesan = pesan('Error!', 'Harap isi semua formulir!', 'error'); //kasih pesan ini
       }
   } else { //kalo ukuran foto kurang dari 1 KB atau lebih dari 1 MB
     $pesan = pesan('Error!', 'Ukuran berkas minimal 1 KB dan maksimal 1 MB.', 'error');
   }
  }
    ?>

    <div class="banner">
      <h2>
        <a href="<?php echo $index;
    ?>">Beranda</a>
        &raquo;
        <a href="kelola.php?aksi=laporan_saya">Data Pelaporan</a>
        &raquo;
        <span>Edit Laporan (<?php echo $nm;
    ?>)</span>
      </h2>
    </div>

    <div class="validation-system">

     		<div class="validation-form">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="col-md-12 form-group1 group-mail">

                  <label class="control-label">Foto Korban</label>
                  <input name="foto_korban" placeholder="Foto korban" required="" type="file" class="custom-file-input">
                </div>
                 <div class="clearfix"> </div>

                <div class="vali-form">
                <div class="col-md-6 form-group1">
                  <label class="control-label">Nama Korban</label>
                  <input name="nama_korban" placeholder="Nama lengkap korban" required="" type="text" value="<?php echo $nm;
    ?>">
                </div>
                <div class="col-md-6 form-group1 form-last">
                  <label class="control-label">Contact Person</label>
                  <input name="contact_person" placeholder="Contact person" required="" type="text"  value="<?php echo $cp;
    ?>">
                </div>
                <div class="clearfix"> </div>
                </div>

                  <div class="col-md-12 form-group2 group-mail">
                   <label class="control-label">Jenis Kelamin</label>
                 <select name="jenis_kelamin">
                   <?php echo $opsi;
    ?>
                 </select>
                 </div>
                  <div class="clearfix"> </div>

                <div class="col-md-12 form-group1 ">
                  <label class="control-label">Lokasi Hilang</label>
                  <textarea name="lokasi_hilang" placeholder="Lokasi hilang korban" required=""><?php echo $lh;
    ?></textarea>
                </div>
                 <div class="clearfix"> </div>

                 <div class="col-md-12 form-group1 ">
                   <label class="control-label">Ciri Khusus Korban </label> <i class="text text-muted small">(Pisahkan dengan koma)</i>
                   <textarea name="ciri_khusus" placeholder="Ciri khusus korban" required=""><?php echo $ck;
    ?></textarea>
                 </div>
                  <div class="clearfix"> </div>

                <div class="col-md-12 form-group">
                  <button name="edit" class="btn btn-primary hvr-shutter-in-horizontal">Edit Data</button>
                </div>
              <div class="clearfix"> </div>
            </form>

     </div>

  </div>
  </div>
   <?php
  echo $pesan; //print pesan ke browser
  require_once 'inc/sistem/kaki.php'; //sda
} else { //kalo dia bukan yang ngelaporin korban
    header('Location: kelola.php?aksi=laporan_saya'); //lempar ke halaman ini
}
} else { //kalo dia bukan admin atau anggota
  require_once 'keluar.php'; //keluar sana!
}
ob_end_flush(); //bersihkan output buffer
  ?>
