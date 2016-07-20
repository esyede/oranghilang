<?php

date_default_timezone_set('Asia/Jakarta'); //set zona waktu default

$db = array( //array database
  'host' => 'localhost', //host database
  'user' => 'root',      //username database
  'pass' => '',          //password database
  'db' => 'orang_hilang'    //nama databasenya
);

$kon = mysql_connect($db['host'], $db['user'], $db['pass']); //konek
if ($kon) { //jika konek
  mysql_select_db($db['db'], $kon) or die('<h2>Gagal memilih database!</h2>
  Pesan: '.mysql_error()); //pilih dbnya, kalo gagal tampilkan pesan error
} else { //jika tidak konek
  die('<h2>Gagal konek ke database!</h2>
  Pesan: '.mysql_error()); //kasih pesan error dan print error di mesqlnya buat debugging
}
