CREATE TABLE IF NOT EXISTS `anggota` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama_asli` varchar(50) NOT NULL,
  `jenis_kelamin` enum('pria', 'wanita') NOT NULL DEFAULT 'pria',
  `foto` varchar(100) NOT NULL DEFAULT 'assets/images/avatar.png',
  `alamat` text NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `level` enum('anggota', 'admin') NOT NULL DEFAULT 'anggota',
PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `anggota` values (1, 'admin', '202cb962ac59075b964b07152d234b70', 'Administrator', 'pria', 'assets/images/avatar.png', 'Sebelah sana', '081234567890', 'admin');
INSERT INTO `anggota` values (2, 'anggota', '202cb962ac59075b964b07152d234b70', 'Contoh Anggota', 'pria', 'assets/images/avatar.png', 'Sebelah sini', '085443322110', 'anggota');



CREATE TABLE IF NOT EXISTS `pelaporan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('pria','wanita') NOT NULL DEFAULT 'pria',
  `lokasi_hilang` varchar(200) NOT NULL,
  `tanggal_hilang` varchar(50) NOT NULL,
  `ciri_khusus` text NOT NULL,
  `foto_lpr` varchar(200) NOT NULL,
  `contact_person` varchar(50) NOT NULL,
  `tipe_pelaporan` enum('hilang','ditemukan') NOT NULL DEFAULT 'hilang',
  `id_pelapor` int(11) NOT NULL,
  `tanggal_lapor` varchar(50) NOT NULL,
  `id_penemu` int(11) NULL,
  `tanggal_ketemu` varchar(50) NULL,
  `lokasi_ketemu` varchar(200) NULL,
PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `pelaporan` (`nama`, `jenis_kelamin`, `lokasi_hilang`, `tanggal_hilang`, `ciri_khusus`,
                        `foto_lpr`, `contact_person`, `tipe_pelaporan`, `id_pelapor`, `tanggal_lapor`, `id_penemu`,
                        `tanggal_ketemu`, `lokasi_ketemu`) values

                        ('Ardiyanto', 'pria', 'Jln. Anggadita No. 11', '2016-02-02', 'Muka Jelek, Tua, Sok Ganteng :D',
                          'assets/images/avatar.png', '081234567890', 'hilang', 2, '2016-05-12', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),

                        ('Irwan Depi Juliana', 'pria', 'Jln. Tuparev No. 33', '2015-11-12', 'Rambut ikal, berkacamata, berkumis :D',
                          'assets/images/avatar.png', '081234567890', 'hilang', 2, '2015-05-06', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),

                        ('Arif Aulia Rachman', 'pria', 'Jln. Bebas Hambatan No. 21', '2016-07-22', 'Ini adalah ciri - ciri orang hilang',
                          'assets/images/avatar.png', '081234567890', 'hilang', 2, '2016-05-12', null, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
