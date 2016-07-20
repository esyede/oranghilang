<?php
/*
File ini keluar.php
File ini buat destroy sesi user
*/
session_start();
unset($_SESSION['username']); //batalkan sesi username
unset($_SESSION['password']); //batalkan sesi password
unset($_SESSION['level']); //batalkan sesi level
unset($_SESSION['nama_asli']); //batalkan sesi nama_asli
unset($_SESSION['foto']); //batalkan sesi foto
unset($_SESSION['alamat']); //batalkan sesi alamat
session_destroy(); //hapus sesinya
ob_flush(); //bersihin output buffernya
header('location: masuk.php'); //lalu lempar ke halaman login
;
