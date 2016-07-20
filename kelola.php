<?php
/*
Ini file kontroller url buat halaman anggota
Fungsinya buat ngarahin halaman sesuai url di urlbar
pake method GET
*/
session_start(); //sda
require_once 'inc/sistem/konek.php'; //sda
require_once 'inc/sistem/fungsi.php'; //sda

if (dia_admin() || dia_anggota()) { //biar admin sama anggota aja yang bisa akses
  //ini metodenya sama dengan file admin.php. lihat admin.php sebagai referensi
  $aksi = isset($_GET['aksi']) ? $_GET['aksi'] : null; //sda
  switch ($aksi) {
    case 'lihat_profil':
      include_once 'inc/anggota/lihat_profil.php';
      break;
    case 'edit_profil':
      include_once 'inc/anggota/edit_profil.php';
      break;
    case 'ganti_sandi':
      include_once 'inc/anggota/ganti_sandi.php';
      break;
    case 'ganti_foto':
      include_once 'inc/anggota/ganti_foto.php';
      break;
      //Laporan ditemukan
      case 'buat_laporan_ditemukan':
        include_once 'inc/anggota/laporan.ditemukan.buat.php';
        break;
      case 'laporan_ditemukan_cari_form':
        include_once 'inc/anggota/lapor.ditemukan.cari_form.php';
        break;
      case 'lapor_ditemukan_verifikasi':
        include_once 'inc/anggota/lapor.ditemukan.verifikasi.php';
        break;
    //Laporan kehilangan
    case 'buat_laporan_kehilangan':
      include_once 'inc/anggota/laporan.kehilangan.buat.php';
      break;
    case 'edit_laporan_kehilangan':
      include_once 'inc/anggota/laporan.kehilangan.edit.php';
      break;
    case 'hapus_laporan_kehilangan': //admin
      include_once 'inc/anggota/laporan.kehilangan.hapus.php';
      break;
    case 'cari_nama':
      include_once 'inc/anggota/cari.nama.php';
      break;
    case 'cari_form':
      include_once 'inc/anggota/cari.nama_form.php';
      break;
    case 'cari_tanggal':
      include_once 'inc/anggota/cari.tanggal.php';
      break;

    case 'laporan_saya': //admin
      include_once 'inc/anggota/laporan_saya.php';
      break;
    case 'semua_laporan': //admin
      include_once 'inc/anggota/semua_laporan.php';
      break;
    case 'lap_edit':
      include_once 'inc/anggota/laporan_edit.php';
      break;
    case 'lap_hapus':
      include_once 'inc/anggota/laporan_hapus.php';
      break;

    case 'hubungi_kami': //admin
      include_once 'inc/anggota/hubungi_kami.php';
      break;
    default:
      include_once 'inc/sistem/404.php';
      break;
  }
} else { //kalo bukan admin atau anggota
  $aksi = isset($_GET['aksi']) ? $_GET['aksi'] : null;
    switch ($aksi) {
    case 'hubungi_kami' :
      include_once 'inc/anggota/hubungi_kami.php';
      break;
    default:
      include_once 'inc/sistem/404.php';
      break;
  }
}
