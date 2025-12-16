CREATE TABLE IF NOT EXISTS `users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','alumni') NOT NULL DEFAULT 'alumni',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `alumni` (
  `id_alumni` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `npm` varchar(20) NOT NULL,
  `angkatan` year(4) NOT NULL,
  `program_studi` varchar(50) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `alamat` text,
  `no_hp` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_alumni`),
  UNIQUE KEY `npm` (`npm`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `fk_alumni_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `tracer_study` (
  `id_tracer` int(11) NOT NULL AUTO_INCREMENT,
  `id_alumni` int(11) NOT NULL,
  `status_kerja` enum('Bekerja','Wiraswasta','Lanjut Studi','Belum Bekerja') NOT NULL,
  `instansi` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `tahun_mulai_kerja` year(4) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_tracer`),
  KEY `id_alumni` (`id_alumni`),
  CONSTRAINT `fk_tracer_alumni` FOREIGN KEY (`id_alumni`) REFERENCES `alumni` (`id_alumni`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert Default Admin
-- Password: admin (hashed with BCRYPT)
INSERT INTO `users` (`nama`, `email`, `password`, `role`) VALUES
('Administrator', 'admin@alumni.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
