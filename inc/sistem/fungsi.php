<?php

require_once 'konek.php'; //sda

/**
 * Fungsi set_judul_halaman()
 * fungsi ini dipake buat ngeganti judul halamnan dengan isi konten pada tag <h2> paling pertama di setiap halaman
 * caranya pake3 javascript.
 **/
function set_judul_halaman()
{
    echo '<script type="text/javascript">
        $(document).ready(function() { //pas dokumen html udah ter-load semua
            document.title = $(\'h2:first\').text(); //ganti document.title dengan h2:first text (teks di tag <h2> pertama)
        });
    </script>';
}

/**
 * Fungsi bersihkan()
 * fungsi ini dipake buat bersihin karakter - karakter yang nggak diperlukan dalam inputan user, seperti spasi, tag - tag html dll
 * caranya pake javascript.
 **/
function bersihkan($query)
{
    $query = trim(htmlentities(stripslashes(mysql_real_escape_string($query))));

    return $query;
}

/**
 * Fungsi dia_admin()
 * fungsi ini dipake buat ngecek apakah dia admin atau bukan, kalo YA returnnya TRUE, kalo NGGAK returnnya FALSE
 * caranya dengan ngebandingin sesi 'level' milik user yang bersangkutan
 * sesi 'level' ini sebelumnya sudah dicatat ketika user login.
 **/
function dia_admin()
{
    $level = isset($_SESSION['level']) ? $_SESSION['level'] : null;
    if ($level == 'admin') {
        return true;
    } else {
        return false;
    }
}

/**
 * Fungsi dia_anggota()
 * fungsi ini kegunaan dan cara kerjanya sama dengan fungsi dia_admin() hanya 'level'-nya saja yang diubah.
 **/
function dia_anggota()
{
    $level = isset($_SESSION['level']) ? $_SESSION['level'] : null;
    if ($level == 'anggota') {
        return true;
    } else {
        return false;
    }
}

/**
 * Fungsi info()
 * fungsi ini dipake buat nampilin bootstrap alert. agar lebih dinamis, ditambahkan 2 parameter yaitu $alert dan $pesan
 * parameter $alert bisa diisi dengan 'success', 'warning' atau 'danger' (mengikuti alert typew yang disediakan bootstrap)
 * sedangkan parameter $pesan bisa diisi dengan teks yang ingin ditampilkan pada alert tersebut.
 **/
function info($alert, $pesan)
{
    echo '<div class="alert alert-'.$alert.' alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Tutup">
        <span aria-hidden="true">&times;</span></button>
        '.$pesan.'
        </div>';
}

/**
 * Fungsi pesan()
 * fungsi ini dipake buat nampilin prompt SweetAlert.js. agar lebih dinamis, ditambahkan 3 parameter yaitu $teks, $pesan dan $tipe
 * dimana parameter $teks bisa diisi dengan judul alaert yang kita inginkan
 * parameter $pesan bisa diisi dengan pesan dibawah judul alaert tadi
 * sedangkan parameter $tipe bisa diisi dengan 'error' atau 'success' mengikuti format yang telah diberikan oleh SweetAlert.js
 * Sebagai referensi teman - teman bisa baca dokumentasinya di: http://t4t5.github.io/sweetalert/.
 **/
function pesan($teks, $pesan, $tipe)
{
    echo '<script type="text/javascript">
          swal("'.$teks.'", "'.$pesan.'", "'.$tipe.'");
        </script>';
}

/**
 * Fungsi bulatkan()
 * fungsi ini gunanya untuk membulatkan ukuran file upload agar lebih mudah dibaca. Kenapa harus dibulatkan?
 * karena ukuran file default milik php adalah dalam format byte.
 * Cara kerjanya dengan membagi ukuran file dengan 1024 dan mengambil 2 angka di belakang koma jika ada modulusnya
 * Untuk catatan, 1 gb = 1073741824 bytes, 1 MB = 1048576 bytes dan 1 KB = 1024 bytes.
 **/
function bulatkan($ukuran)
{
    if ($ukuran >= 1073741824) {
        $ukuran = number_format($ukuran / 1073741824, 2).' GB';
    } elseif ($ukuran >= 1048576) {
        $ukuran = number_format($ukuran / 1048576, 2).' MB';
    } elseif ($ukuran >= 1024) {
        $ukuran = number_format($ukuran / 1024, 2).' KB';
    } elseif ($ukuran > 1) {
        $ukuran = $ukuran.' bytes';
    } elseif ($ukuran == 1) {
        $ukuran = $ukuran.' byte';
    } else {
        $ukuran = '0 bytes';
    }

    return $ukuran;
}
