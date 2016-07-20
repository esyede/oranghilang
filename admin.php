<?php
/*
Ini file kontroller url buat halaman admin
Fungsinya buat ngarahin halaman sesuai url di urlbar
pake method GET
*/
session_start(); //ini buat mulai sesi
ob_start(); //ini buat mulai output buffer
require_once 'inc/sistem/konek.php'; //sda
require_once 'inc/sistem/fungsi.php'; //sda

if (dia_admin()) { //kalo di admin
  $aksi = isset($_GET['aksi']) ? $_GET['aksi'] : null; //cek getter url udah ada blm, kalo udah, ambil datanya
  switch ($aksi) {
    case 'kelola_anggota' : //kalo urlnya 'kelola_anggota'
      include_once 'inc/sistem/kelola_anggota.php'; //include ini
      break;
      //ini kebawah sama seperti diatas ya...
    case 'hapus_anggota' :
      include_once 'inc/sistem/hapus_anggota.php';
      break;
    case 'edit_anggota' :
      include_once 'inc/sistem/edit_anggota.php';
      break;
    default :
      header('Location: index.php');
  }
} elseif (dia_anggota()) { //kalo dia anggota
  header('Location: dasbor.php'); //lempar ke dasbor.php
} else { //kalo dia bukan anggota atau admin
  include_once 'keluar.php'; //lempar ke halaman login
}
ob_end_flush(); //bersihin output buffernya biar fungsi header() bisa dipake ulang
//kenapa butuh ob_start() dan ob_end_flush() ?
//karena kita pake fungsi header() yang memodifikasi header file html kita. dan itu tersimpan di buffer i/o
//output buffer hanya bisa diisi 1 kali, jadi harus dihapus kalo mau diisi ulang
;
