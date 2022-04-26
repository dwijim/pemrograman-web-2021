-- MySQL dump 10.19  Distrib 10.3.34-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: latihan
-- ------------------------------------------------------
-- Server version	10.3.34-MariaDB-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Current Database: `latihan`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `latihan` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `latihan`;

--
-- Table structure for table `kode_golongan_darah`
--

DROP TABLE IF EXISTS `kode_golongan_darah`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kode_golongan_darah` (
  `kode` int(1) NOT NULL,
  `keterangan` char(2) NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kode_golongan_darah`
--

LOCK TABLES `kode_golongan_darah` WRITE;
/*!40000 ALTER TABLE `kode_golongan_darah` DISABLE KEYS */;
INSERT INTO `kode_golongan_darah` VALUES (1,'A'),(2,'B'),(3,'AB'),(4,'0'),(5,'-');
/*!40000 ALTER TABLE `kode_golongan_darah` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kode_keahlian`
--

DROP TABLE IF EXISTS `kode_keahlian`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kode_keahlian` (
  `Kode` int(5) NOT NULL AUTO_INCREMENT,
  `Keterangan` char(46) NOT NULL,
  PRIMARY KEY (`Kode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kode_keahlian`
--

LOCK TABLES `kode_keahlian` WRITE;
/*!40000 ALTER TABLE `kode_keahlian` DISABLE KEYS */;
/*!40000 ALTER TABLE `kode_keahlian` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kode_kecamatan`
--

DROP TABLE IF EXISTS `kode_kecamatan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kode_kecamatan` (
  `kode_propinsi` char(2) NOT NULL DEFAULT '',
  `kode_kabupaten` char(2) NOT NULL DEFAULT '',
  `kode` char(3) NOT NULL DEFAULT '',
  `keterangan` char(27) NOT NULL DEFAULT '',
  PRIMARY KEY (`kode_propinsi`,`kode_kabupaten`,`kode`),
  KEY `kode_propinsi` (`kode_propinsi`,`kode_kabupaten`,`kode`),
  KEY `keterangan` (`keterangan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kode_kecamatan`
--

LOCK TABLES `kode_kecamatan` WRITE;
/*!40000 ALTER TABLE `kode_kecamatan` DISABLE KEYS */;
INSERT INTO `kode_kecamatan` VALUES ('16','01','11','Serang'),('16','01','01','Cibeber'),('16','01','02','Cilegon'),('16','01','03','Pulomerak'),('16','01','04','Ciwandan'),('16','01','05','Jombang'),('16','01','06','Gerogol'),('16','01','08','Citangkil');
/*!40000 ALTER TABLE `kode_kecamatan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kode_kelurahan`
--

DROP TABLE IF EXISTS `kode_kelurahan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kode_kelurahan` (
  `kode_propinsi` char(2) NOT NULL DEFAULT '',
  `kode_kabupaten` char(2) NOT NULL DEFAULT '',
  `kode_kecamatan` char(3) NOT NULL DEFAULT '',
  `kode` int(5) NOT NULL AUTO_INCREMENT,
  `keterangan` char(27) NOT NULL DEFAULT '',
  `kode_gabung` char(11) NOT NULL,
  PRIMARY KEY (`kode`),
  KEY `kode_propinsi` (`kode_propinsi`,`kode_kabupaten`,`kode_kecamatan`,`kode`),
  KEY `keterangan` (`keterangan`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kode_kelurahan`
--

LOCK TABLES `kode_kelurahan` WRITE;
/*!40000 ALTER TABLE `kode_kelurahan` DISABLE KEYS */;
INSERT INTO `kode_kelurahan` VALUES ('16','01','01',1,'Desa Kedaleman','01'),('16','01','01',2,'Cibeber','02'),('16','01','01',3,'Kalitimbang','03'),('16','01','01',4,'Karangasem','04'),('16','01','01',5,'Bulakan','05'),('16','01','01',6,'Cikerai','06'),('16','01','02',7,'Ciwaduk','07'),('16','01','02',8,'Ketileng','08'),('16','01','02',9,'Bendungan','09'),('16','01','02',10,'Ciwedus','10'),('16','01','02',11,'Bagendung','11'),('16','01','08',12,'Citangkil','12'),('16','01','08',13,'Tamanbaru','13'),('16','01','08',14,'Kebonsari','14'),('16','01','08',15,'Lebakdenok','15'),('16','01','08',16,'samangraya','16'),('16','01','08',17,'Warnasari','17'),('16','01','08',18,'Deringo','18'),('16','01','04',19,'Banjar Negara','19'),('16','01','04',20,'Kubangsari','20'),('16','01','04',21,'Tegalratu','21'),('16','01','04',22,'Kepuh','22'),('16','01','04',23,'Randakari','23'),('16','01','04',24,'Gunungsugih','24'),('16','01','06',25,'Grogol','25'),('16','01','06',26,'Kotasari','26'),('16','01','06',27,'Rawa Arum','27'),('16','01','06',28,'Gerem','28'),('16','01','05',29,'Jombang Wetan','29'),('16','01','05',30,'Panggung Rawi','30'),('16','01','05',31,'Gedong Dalem','31'),('16','01','05',32,'Masigit','32'),('16','01','05',33,'Sukmajaya','33'),('16','01','03',34,'Lebak Gede','34'),('16','01','03',35,'Mekarsari','35'),('16','01','03',36,'Tamansari','36'),('16','01','03',37,'Suralaya','37'),('16','01','07',38,'Ramanuju','38'),('16','01','07',39,'Kebondalem','39'),('16','01','07',40,'Kotabumi','40'),('16','01','07',41,'Pabean','41'),('16','01','07',42,'Purwakarta','42'),('16','01','07',43,'Tegal Bunder','43'),('16','01','11',44,'Kramatwatu','44');
/*!40000 ALTER TABLE `kode_kelurahan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kode_kepakaran`
--

DROP TABLE IF EXISTS `kode_kepakaran`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kode_kepakaran` (
  `kode` varchar(3) NOT NULL,
  `keterangan` char(53) NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kode_kepakaran`
--

LOCK TABLES `kode_kepakaran` WRITE;
/*!40000 ALTER TABLE `kode_kepakaran` DISABLE KEYS */;
INSERT INTO `kode_kepakaran` VALUES ('a',' Kedokteran\n'),('aa',' Ilmu Biologi\n'),('ab',' Fisika Medis\n'),('ac',' Anatomik\n'),('ad',' Histologi\n'),('ae',' Ilmu Faal\n'),('af',' Biokimia\n'),('ag',' Patologi\n'),('ah',' Mikrobiologi Kedokteran\n'),('ai',' Parasitologi\n'),('aj',' Kedokteran Komunitas\n'),('ak',' Penyakit Dalam\n'),('al',' Bedah\n'),('am',' Obstetri dan Ginekologi\n'),('an',' Kesehatan Anak\n'),('ao',' Penyakit Syaraf\n'),('ap',' Kedokteran Jiwa\n'),('aq',' Ilmu Penyakit THT\n'),('ar',' Ilmu Penyakit Mata\n'),('as',' Kardiologi\n'),('at',' Radiologi\n'),('au',' Dermatologi\n'),('av',' Anestesiologi\n'),('aw',' Pulmonologi\n'),('ax',' Kedokteran Forensik\n'),('ay',' Bedah Syaraf\n'),('az',' Kedokteran Lainnya\n'),('b',' Kedokteran Gigi\n'),('ba',' Bedah Mulut\n'),('bb',' Kesehatan Gigi Anak\n'),('bc',' Kesehatan Gigi Masyarakat & Pencegahan\n'),('bd',' Orthodonsia\n'),('be',' Konservasi Gigi\n'),('bf',' Penyakit Mulut\n'),('bg',' Periodonsia\n'),('bz',' Kedokteran Gigi Lainnya\n'),('c',' Kesehatan Masyarakat\n'),('ca',' Administrasi Kebijakan Kesehatan\n'),('cb',' Studi Kebijakan\n'),('cc',' Epidemiologi\n'),('cd',' Gizi dan Kesehatan Masyarakat\n'),('ce',' Ilmu Kependudukan dan Biostatistik\n'),('cf',' Kesehatan Lingkungan\n'),('cg',' Pendidikan Kesehatan dan Ilmu Perilaku\n'),('cz',' Kesehatan Masyarakat Lainnya\n'),('d',' Ilmu Keperawatan\n'),('da',' Dasar Keperawatan dan Keperawatan Dasar\n'),('db',' Keperawatan Medikal Bedah\n'),('dc',' Keperawatan Anak\n'),('dd',' Keperawatan Maternitas\n'),('de',' Keperawatan Jiwa\n'),('df',' Keperawatan Komunitas\n'),('dz',' Keperawatan Lainnya\n'),('e',' MIPA\n'),('ea',' Matematika\n'),('eb',' Fisika\n'),('ec',' Kimia\n'),('ed',' Biologi\n'),('ee',' Farmasi\n'),('ef',' Geografi\n'),('eg',' Statistika\n'),('eh',' Geofisika\n'),('ei',' Elektronika & Instrumentasi\n'),('ez',' MIPA Lainnya\n'),('f',' Teknik\n'),('fa',' Teknik Sipil\n'),('fb',' Teknik Mesin\n'),('fc',' Teknik Elektro\n'),('fd',' Teknik Metalurgi dan Material\n'),('fe',' Teknik Kimia\n'),('ff',' Teknik Arsitektur\n'),('fg',' Teknik Industri\n'),('fh',' Teknik Perkapalan\n'),('fi',' Teknik Geodesi\n'),('fj',' Teknik Geologi\n'),('fk',' Teknik Nuklir\n'),('fl',' Fisika Teknik\n'),('fm',' Perencanaan Kota dan Daerah\n'),('fn',' Teknik Pertanian\n'),('fo',' Teknik Pertambangan\n'),('fp',' Teknik Perminyakan\n'),('fq',' Teknik Penerbangan\n'),('fr',' Teknik Mineral \n'),('fz',' Teknik Lainnya \n'),('g',' Komputer \n'),('ga',' Ilmu Komputer \n'),('gb',' Teknik Komputer \n'),('gc',' Sistem Informasi \n'),('gd',' Akuntansi Komputer \n'),('gz',' Komputer Lainnya \n'),('h',' Hukum \n'),('ha',' Ilmu Hukum Dasar \n'),('hb',' Hukum Keperdataan \n'),('hc',' Hukum Pidana \n'),('hd',' Hukum Tata Negara \n'),('he',' Hukum Administrasi Negara \n'),('hf',' Hukum Internasional \n'),('hg',' Hukum dan Masyarakat \n'),('hh',' Ilmu Hukum Acara \n'),('hz',' Hukum Lainnya \n'),('i',' Ilmu Pendidikan (FIP) \n'),('iaa',' Bimbingan Konseling \n'),('iab',' Teknologi Pendidikan \n'),('iac',' Pendidikan Luar Biasa \n'),('iad',' Manajemen Pendidikan \n'),('iae',' Pendidikan Luar Sekolah \n'),('iaf',' Pendidikan Anak \n'),('iag',' Psikologi Pendidikan \n'),('ib',' Pendidikan Bahasa \n'),('ic',' Pendidikan Seni \n'),('id',' Pendidikan Ilmu Sosial (FIS) \n'),('ida',' Pendidikan Administrasi Perkantoran \n'),('idb',' Pendidikan Akuntansi \n'),('idc',' Pendidikan Ekonomi Koperasi \n'),('idd',' Pendidikan Tata Niaga \n'),('idz',' Pendidikan Ilmu Sosial Lainnya \n'),('iea',' Pendidikan Teknik Listrik \n'),('ieb',' Pendidikan Teknik Elektronika \n'),('iec',' Pendidikan Teknik Mesin \n'),('iez',' Pendidikan Teknik Lainnya \n'),('ifa',' Pendidikan Tata Boga \n'),('ifb',' Pendidikan Tata Busana \n'),('ifc',' Pendidikan Tata Rias \n'),('ifz',' Pendidikan Ilmu Kesejahteraan Keluarga Lainnya \n'),('iga',' Pendidikan Matematika \n'),('igb',' Pendidikan Fisika \n'),('igc',' Pendidikan Kimia \n'),('igd',' Pendidikan Biologi \n'),('igz',' Pendidikan MIPA Lainnya \n'),('iha',' Pendidikan Jasmani \n'),('ihb',' Pendidikan Kepelatihan\n'),('ihz',' Pendidikan Keolahragaan Lainnya\n'),('j',' Ekonomi\n'),('ja',' Ekonomi dan Studi Pembangunan\n'),('jb',' Akuntansi\n'),('jc',' Manajemen\n'),('jd',' Perpajakan\n'),('je',' Beacukai\n'),('jf',' Perbankan\n'),('jg',' Asuransi\n'),('jh',' Pegadaian\n'),('jz',' Ekonomi Lainnya\n'),('k',' Ilmu Pengetahuan Budaya\n'),('ka',' Arkeologi\n'),('kb',' Sejarah\n'),('kc',' Studi Cina\n'),('kd',' Studi Jepang\n'),('ke',' Studi Belanda\n'),('kf',' Studi Arab\n'),('kg',' Studi Jerman\n'),('kh',' Studi Inggris\n'),('ki',' Studi Perancis\n'),('kj',' Studi Asia Timur\n'),('kl',' Sastra Slavia\n'),('km',' Sastra Daerah\n'),('kn',' Filsafat\n'),('ko',' Ilmu Perpustakaan\n'),('kp',' Linguistik\n'),('kq',' Kesusasteraan\n'),('kz',' Pengetahuan Budaya Lainnya\n'),('l',' Psikologi\n'),('la',' Psikologi Industri & Organisasi\n'),('lb',' Psikologi Klinis\n'),('lc',' Psikologi Perkembangan\n'),('ld',' Psikologi Pendidikan\n'),('le',' Psikologi Sosial\n'),('lf',' Psikologi Umum dan Eksperimen\n'),('lz',' Psikologi Lainnya\n'),('m',' Ilmu Sosial dan Ilmu Politik\n'),('ma',' Antropologi\n'),('mb',' Ilmu Administrasi\n'),('mc',' Hubungan Internasional\n'),('md',' Ilmu Komunikasi\n'),('me',' Kesejahteraan Sosial\n'),('mf',' Kriminologi\n'),('mg',' Ilmu Politik\n'),('mh',' Sosiologi\n'),('mz',' ISIP Lainnya\n'),('n',' Kehutanan\n'),('na',' Manajemen Hutan\n'),('nb',' Budidaya Hutan\n'),('nc',' Teknologi Hasil Hutan\n'),('nd',' Konservasi Sumberdaya Hutan\n'),('nz',' Kehutanan lainnya\n'),('o','Pertanian'),('oa',' Agronomi\n'),('ob',' Pemuliaan Tanaman\n'),('oc',' Ekonomi Pertanian/Agrobisnis\n'),('od',' Penyuluhan dan Komunikasi Pertanian\n'),('oe',' Ilmu Tanah\n'),('of',' Ilmu Hama dan Penyakit Tumbuhan\n'),('og',' Budidaya Perikanan\n'),('oh',' Manajemen Sumberdaya Perikanan\n'),('oi',' Teknologi Hasil Perikanan\n'),('oj',' Mikrobiologi Pertanian\n'),('ok',' Teknologi hasil Pertanian\n'),('ol',' Teknologi Industri Pertanian\n'),('oz',' Pertanian Lainnya\n'),('p',' Syariah (Keagamaan)\n'),('pa',' Quran/Tafsir Quran\n'),('pb',' Hadits\n'),('pc',' Fiqh\n'),('pd',' Tarbiyah Islamiyyah\n'),('pe',' Dirasat Islamiyah (Studi Islam)\n'),('pf',' Ushuluddin\n'),('pg',' Perdata/Peradilan Islam\n'),('ph',' Perbandingan Madzhab\n'),('pi',' Komunikasi dan Penyiaran Islam\n'),('pj',' Bimbingan dan Penyuluhan Islam\n'),('pk',' Manajemen Dakwah\n'),('pl',' Pengembangan Masyarakat Islam\n'),('pz',' Syariah (keagamaan) Lainnya\n'),('q','Membuat Kue'),('qa',' Seni Rupa/Design\n'),('qb',' Seni Suara\n'),('qc','Guru Qiroati'),('qz','Mengajar Matematik'),('z','Hypnoterapis'),(' -',' -'),('a1','Akupuntur'),('rs','Rancang Bangun Sipil'),('en','Engineering & Project Management'),('pp','Production Planning Control'),('ds','Design Engineering'),('we','Metal & Electronik'),('wa','Engineer'),('lm','Bela Diri Kempo'),('ts','Tahsin'),('mm','Memasak'),('mj','Menjahit'),('bk','Berdagang'),('qq','Trainning Motivasi'),('za','Pendidikan'),('ik','Production Planning Control'),('IO','HUMAN CAPITAL INTEGRASI & ADM');
/*!40000 ALTER TABLE `kode_kepakaran` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kode_marital`
--

DROP TABLE IF EXISTS `kode_marital`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kode_marital` (
  `kode` char(1) NOT NULL,
  `keterangan` char(33) NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kode_marital`
--

LOCK TABLES `kode_marital` WRITE;
/*!40000 ALTER TABLE `kode_marital` DISABLE KEYS */;
INSERT INTO `kode_marital` VALUES ('1','Belum Menikah'),('2','Menikah'),('3','Menikah dua istri'),('4','Menikah tiga istri'),('5','Menikah empat istri'),('6','Duda/Janda');
/*!40000 ALTER TABLE `kode_marital` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kode_pekerjaan`
--

DROP TABLE IF EXISTS `kode_pekerjaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kode_pekerjaan` (
  `kode_bidang_pekerjaan` int(2) NOT NULL AUTO_INCREMENT,
  `nama_bidang_pekerjaan` varchar(127) NOT NULL,
  PRIMARY KEY (`kode_bidang_pekerjaan`)
) ENGINE=MyISAM AUTO_INCREMENT=114 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kode_pekerjaan`
--

LOCK TABLES `kode_pekerjaan` WRITE;
/*!40000 ALTER TABLE `kode_pekerjaan` DISABLE KEYS */;
INSERT INTO `kode_pekerjaan` VALUES (1,'Perkebunan deket rumah'),(2,'Lembaga keuangan'),(3,'Wedding Organiser / Dekorasi / Catering'),(4,'Jasa kemasyarakatan, sosial dan perorangan'),(5,'Angkutan, pergudangan dan komunikasi'),(6,'Pertambangan dan penggalian'),(7,'Listrik, gas dan air minum'),(8,'Industri pengolahan'),(9,'Konstruksi'),(10,'Pendidikan'),(11,'Statistika'),(12,'Percetakan, Service IT'),(13,'Bantuan Hukum dan HAM'),(14,'Perdagangan Buku Pendidikan Anak dan Parenting Skill'),(15,'Pertanian'),(16,'Perbankan'),(17,'Perawat'),(18,'Birokrat Pemda'),(19,'GURU / PNS'),(20,'Seismologi'),(21,'Peternakan'),(22,'Catring'),(23,'apoteker pengelola instalasi farmasi puskesmas'),(24,'Hardware komputer,Network,Trouble Shooting Windows'),(25,'Section head Level Staff'),(26,'Konsultan PNPM-MPd'),(27,'Kesehatan'),(28,'Kesenian'),(29,'Widyaiswara Badan Diklat'),(30,'Lingkungan Hidup'),(31,'Dosen'),(32,'Kepala Sekolah'),(33,'Wakil Kepala'),(34,'penyuluh pertanian'),(35,'pemberdayaan masyarakat'),(36,'Leasing/ Pembiayaan/ Finance'),(37,'pendidikan TPA'),(38,'Pengelola Bimbel'),(39,'Amil Zakat'),(40,'Ibu Rumah Tangga'),(41,'Agen ASURANSI'),(42,'Instruktur'),(43,'Usaha Catering Cake and Bakery'),(44,'Biro Kunsultasi Keluarga'),(45,'perdagangan'),(46,'asisten apoteker pengelola instalasi farmasi puskesmas'),(47,'perbendaharaan'),(48,'perbendaharaan'),(49,'Mengelola BMT'),(50,'perdagangan'),(51,'Guru SMA'),(52,'Guru SMP'),(53,'konsultan sipil'),(54,'Guru SD'),(55,'Pipin Engineering'),(56,'ENGINNER ( TEHNIK KIMIA )'),(57,'Praktek Dokter'),(58,'BIMBINGAN HAJI'),(59,'Medik veteriner-laboratorium'),(60,'Bidan'),(62,'Bidan'),(63,'PRODUCTION PLANING CONTROL'),(64,'HUMAN CAPITAL INTEGRASI & ADM'),(65,'Konsultan Mekanikal-Elektrikal'),(73,'Anggota DPRD Kota'),(74,'Petani'),(76,'Perencanaan Anggaran dan Kegiatan'),(77,'Perencanaan Pembangunan'),(78,'perkebunan'),(79,'Guru SMK'),(80,'Wiraswasta'),(83,'guru SMP'),(84,'Pengawas Sekolah'),(85,'Manajer / Kepala Cabang BUMN'),(86,'wira usaha'),(87,'DPRD Prop'),(88,'staf ahli fraksi dprd lamtim'),(90,'Refraksionis Optik'),(91,'PNS (Keuangan)'),(92,'lembaga Zakat'),(93,'Guru'),(94,'Guru Honor'),(95,'Operator SIMAK BMN'),(96,'Kuliah S2 Akuntansi'),(97,'Konsultan Pertambangan'),(99,'Energi dan Kelistrikan'),(100,'Peradilan'),(101,'Karyawan Swasta'),(102,'Fungsional Penyuluh Agama Islam'),(103,'Manufactury'),(104,'Project'),(105,'Enginering'),(106,'Keperawatan'),(107,'Keuangan'),(108,'Data Control Keuangan'),(109,'Asuransi'),(110,'PNS'),(111,'Dokter Gigi'),(112,'Karyawan BUMN'),(113,'PETERNAKAN');
/*!40000 ALTER TABLE `kode_pekerjaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kode_program_studi`
--

DROP TABLE IF EXISTS `kode_program_studi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kode_program_studi` (
  `kode` int(4) NOT NULL AUTO_INCREMENT,
  `nama` varchar(68) NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=MyISAM AUTO_INCREMENT=149 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kode_program_studi`
--

LOCK TABLES `kode_program_studi` WRITE;
/*!40000 ALTER TABLE `kode_program_studi` DISABLE KEYS */;
INSERT INTO `kode_program_studi` VALUES (0,'-'),(2,'Matematika Murni'),(3,'Kimia Murni'),(4,'Magister Teknologi Informasi'),(5,'Psikologi Perkembangan'),(6,'Statistika Terapan'),(7,'Magister Administrasi Publik'),(8,'Akuntansi'),(9,'Hortikultura'),(10,'Nutrisionist'),(11,'Pendidikan Matematika'),(12,'Pendidikan Matematika'),(13,'Pendidikan Matematika'),(14,'Pendidikan Matematika'),(15,'Pendidikan Matematika'),(16,'Pendidikan Matematika'),(17,'Pendidikan Matematika'),(18,'Pendidikan Matematika'),(19,'Sistem Informasi'),(115,'teknik kimia'),(22,'Ilmu Pemerintahan'),(23,'Ilmu Hukum'),(24,'Pendidikan Ekonomi'),(25,'TEKNOLOGI HASIL PERTANIAN'),(26,'Fisika Murni'),(27,'teknik sipil'),(28,'Teknik Elektro/Telekomunikasi'),(29,'ilmu manajemen'),(30,'Magister Ilmu Pemerintahan'),(31,'sosiologi'),(32,'Teknik Pertanian'),(33,'Syariah'),(34,'Ilmu Tanah'),(35,'Profesi Perawat'),(36,'Teknik Elektro/Tenaga Listrik'),(37,'Pendidikan Bahasa dan Sastra Indonesia'),(38,'Pendidikan Bahasa dan Sastra Indonesia'),(39,'Komunikasi Penyiaran Islam'),(40,'Komunikasi Penyiaran Islam'),(41,'Ilmu Komunikasi'),(42,'Fakultas Farmasi'),(43,'Administrasi Negara'),(44,'pendidikan kimia'),(45,'Bimbingan dan Konseling'),(46,'Keperawatan'),(47,'Administrasi Bisnis'),(48,'Teknik Mesin'),(49,'Teknik Mesin'),(50,'Pendidikan Olahraga'),(51,'Ekonomi Pembangunan'),(52,'Tarbiyah'),(53,'Tarbiyah'),(54,'Pendidikan Biologi'),(55,'Pendidikan Sejarah'),(56,'Pendidikan Bahasa Inggris'),(57,'Tarbiyah/Pendidikan Agama Islam'),(58,'Sastra Perancis'),(59,'Kimia Murni'),(60,'Peternakan'),(61,'Produksi Ternak'),(62,'Teknologi Aquakultur'),(63,'Agrobisnis'),(64,'pendidikan fisika'),(65,'MIPA Biologi'),(66,'tarbiyah'),(67,'Budidaya Pertanian/Agronomi'),(68,'Magister Ekonomi Pertanian/Agribisnis'),(69,'Agronomi'),(70,'sastra dan bahasa Inggris'),(71,'MIPA FISIKA'),(72,'Ilmu Hama dan Penyakit Tanaman'),(73,'Pendidikan Agama Islam'),(74,'Teknik Lingkungan'),(75,'Ilmu Managament'),(76,'Matematika Murni'),(77,'Budidaya Pertanian/Hortikultura'),(78,'Budidaya Pertanian/Hortikultura'),(79,'Kehutanan'),(80,'-'),(81,'-'),(82,'Kimia Murni'),(83,'pendidikan kimia'),(84,'pendidikan kimia'),(85,'MIPA Kimia'),(86,'Sistem Komputer'),(87,'pengembangan masyarakat islam'),(88,'pengembangan masyarakat islam'),(89,'Kehutanan'),(90,'Kedokteran Hewan'),(91,'Kedokteran Gigi'),(92,'Pendidikan Bahasa Arab'),(93,'Pendidikan Agama Islam'),(94,'manajemen proyek'),(95,'Pendidikan Guru SD'),(96,'Pendidikan kewarganegaraan'),(97,'Bidan Pendidik'),(98,'Magister Kesehatan Masyarakat'),(99,'Kedokteran Umum'),(100,'penyuluh pertanian'),(101,'penyuluh pertanian'),(102,'-'),(103,'-'),(104,'Arsitektur'),(105,'arsitektur'),(106,'Kebidanan'),(107,'Farmasi'),(108,'Kesehatan Masyarakat'),(109,'Ekonomi Manajemen'),(110,'Pendidikan Bahasa dan Sastra Indonesia'),(111,'Kedokteran Hewan'),(112,'tdk s2'),(113,'tdk s3'),(114,'Akuntansi Islam'),(116,'Budidaya Pertanian'),(117,'-'),(118,'-'),(119,'Magister Manajemen'),(120,'Ilmu Tanah'),(121,'Pemasaran (Marketting)'),(122,'ips sejarah'),(123,'ips sejarah'),(124,'ips sejarah'),(125,'ips sejarah'),(126,'Ilmu Tanah'),(127,'Pendidikan Luar Sekolah'),(128,'Ilmu Geografi'),(129,'Budidaya Perairan/ Perikanan'),(130,'Ilmu Pemerintahan'),(131,'Teknik Pertambangan'),(132,'Teknik Pertambangan'),(133,'Ilmu Lingkungan BKU. Perencanaan Pengelolaan SDA'),(134,'Teknik Pertambangan'),(135,'Ilmu Lingkngan BKU. Perencanaan Pengelolaan SDA'),(136,'Islamic Studies'),(137,'Teknologi Pangan dan Gizi'),(138,'Dakwah'),(139,'Pengembangan Masyarakat Islam'),(140,'syariah'),(141,'syariah'),(142,'Ilmu Komputer'),(143,'matematika'),(144,'Perawatan Mesin'),(145,'Teknik Industri'),(146,'Teknik Kimia'),(147,'Teknik Metalurgy'),(148,'Teknik Sipil');
/*!40000 ALTER TABLE `kode_program_studi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kode_suku`
--

DROP TABLE IF EXISTS `kode_suku`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kode_suku` (
  `kode` int(3) NOT NULL,
  `keterangan` char(27) NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kode_suku`
--

LOCK TABLES `kode_suku` WRITE;
/*!40000 ALTER TABLE `kode_suku` DISABLE KEYS */;
INSERT INTO `kode_suku` VALUES (1,'Jawa'),(5,'Madura'),(9,'Palembang'),(13,'Betawi'),(17,'Bugis'),(2,'Sunda'),(6,'Banten'),(10,'Melayu'),(14,'Kutai'),(18,'Makasar'),(3,'Bali'),(7,'India'),(11,'Ambon'),(15,'Cina'),(19,'Aceh'),(4,'Batak'),(8,'Minang'),(12,'Manado'),(16,'Lampung'),(20,'Lainnya');
/*!40000 ALTER TABLE `kode_suku` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kode_tingkat_pendidikan`
--

DROP TABLE IF EXISTS `kode_tingkat_pendidikan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kode_tingkat_pendidikan` (
  `kode` tinyint(1) NOT NULL,
  `keterangan` char(33) NOT NULL,
  PRIMARY KEY (`kode`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kode_tingkat_pendidikan`
--

LOCK TABLES `kode_tingkat_pendidikan` WRITE;
/*!40000 ALTER TABLE `kode_tingkat_pendidikan` DISABLE KEYS */;
INSERT INTO `kode_tingkat_pendidikan` VALUES (1,'Tidak Tamat SD'),(2,'SD/MI'),(3,'SMP/MTs'),(4,'SMA/MA/SMK'),(5,'Diploma'),(6,'Sarjana/S1'),(7,'Pasca Sarjana/S2'),(8,'Doktor/S3');
/*!40000 ALTER TABLE `kode_tingkat_pendidikan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manusia`
--

DROP TABLE IF EXISTS `manusia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `manusia` (
  `Nomor_Data` int(7) NOT NULL AUTO_INCREMENT,
  `Nama_Lengkap` char(68) NOT NULL DEFAULT '-',
  `Jenis_Kelamin` enum('L','P') NOT NULL,
  `Tempat_Lahir` char(46) NOT NULL DEFAULT '-',
  `Tanggal_Lahir` date NOT NULL,
  `Alamat` varchar(123) DEFAULT '-',
  `RT` char(3) DEFAULT '-',
  `RW` char(3) DEFAULT '-',
  `Kecamatan` char(3) DEFAULT '-',
  `Kelurahan` int(5) NOT NULL DEFAULT 0,
  `Status_Marital` char(1) DEFAULT NULL,
  `Suku` int(3) DEFAULT 0,
  `Tingkat_Pendidikan` tinyint(1) DEFAULT 0,
  `Program_Studi` int(4) DEFAULT 0,
  `Golongan_Darah` int(1) DEFAULT 0,
  `Telpon` char(23) DEFAULT '-',
  `Email` char(46) DEFAULT '-',
  `Pekerjaan` tinyint(2) DEFAULT 0,
  `Nama_Istri` char(68) DEFAULT '-',
  `Nama_Anak_ke_1` char(68) DEFAULT '-',
  `Tanggal_Lahir_Anak_ke_1` date DEFAULT NULL,
  `Nama_Anak_ke_2` char(68) DEFAULT '-',
  `Tanggal_Lahir_Anak_ke_2` date DEFAULT NULL,
  `Nama_Anak_ke_3` char(68) DEFAULT '-',
  `Tanggal_Lahir_Anak_ke_3` date DEFAULT NULL,
  `Nama_Anak_ke_4` char(68) DEFAULT '-',
  `Tanggal_Lahir_Anak_ke_4` date DEFAULT NULL,
  `Nama_Anak_ke_5` char(68) DEFAULT '-',
  `Tanggal_Lahir_Anak_ke_5` date DEFAULT NULL,
  `Nama_Anak_ke_6` char(68) DEFAULT '-',
  `Tanggal_Lahir_Anak_ke_6` date DEFAULT NULL,
  `Nama_Anak_ke_7` char(68) DEFAULT '-',
  `Tanggal_Lahir_Anak_ke_7` date DEFAULT NULL,
  `Organisasi_1` char(68) DEFAULT '-',
  `Organisasi_2` char(68) DEFAULT '-',
  `Organisasi_3` char(68) DEFAULT '-',
  PRIMARY KEY (`Nomor_Data`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manusia`
--

LOCK TABLES `manusia` WRITE;
/*!40000 ALTER TABLE `manusia` DISABLE KEYS */;
INSERT INTO `manusia` VALUES (3,'Parto Sunarto','P','Jogyakarta','1968-12-20','Jl. Maju Mundur','04','05','01',1,'2',6,6,48,4,'08202665016','sayur@gmail.com',101,'Nini Kartini','Udin Surudin',NULL,'Mahir Zein',NULL,'Galang Menggalang',NULL,'Kerja Bakti',NULL,'Zidan',NULL,'-',NULL,'-',NULL,'-','-','-'),(4,'Mukidi','L','Lampung','1978-09-09','Tanjung Senang','04','05','03',1,'2',1,7,135,4,'0898328704651','mukidi@yahoo.com',91,'Tri Putri Metri','Indah',NULL,'Dede',NULL,'Elvi',NULL,'-',NULL,'-',NULL,'-',NULL,'-',NULL,'-','-','-'),(6,'Mulyadi','L','Sukoharjo','1972-07-03','Perumahan Murah Meriah','-','-','01',3,'2',1,7,8,1,'0811232341234','mulyadi@yahoo.com',85,'Nini','Pulo',NULL,'Kiki',NULL,'Sarah',NULL,'-',NULL,'-',NULL,'-',NULL,'-',NULL,'-','-','-'),(7,'Dwi Sakethi','L','Pandeglang','1976-05-26','Padang Pendek','05','08','08',14,'2',2,6,108,4,'0878787878787','-',80,'Titi','Nuri',NULL,'Rhoma',NULL,'Super Dede',NULL,'-',NULL,'-',NULL,'-',NULL,'-',NULL,'-','-','-'),(8,'Nusron','L','Jakarta','1971-07-01','Taman Keputren','05','08','11',44,'2',13,6,8,4,'0819110078678','ih@gmail.com',101,'Retno','Prinsis',NULL,'Princ',NULL,'-',NULL,'-',NULL,'-',NULL,'-',NULL,'-',NULL,'-','-','-'),(9,'Soolai','P','Sorong','1982-12-20','Krakatau','01','02','02',10,'2',1,6,28,NULL,'0817038439455',NULL,62,'Siti Sutiti','Siren',NULL,'Ismail',NULL,'-',NULL,'-',NULL,'-',NULL,'-',NULL,'-',NULL,'-','-','-'),(13,'Ijul Aja','P','Jabung','0000-00-00','-','-','-','11',0,NULL,0,0,0,0,'-','-',0,'-','-',NULL,'-',NULL,'-',NULL,'-',NULL,'-',NULL,'-',NULL,'-',NULL,'-','-','-'),(14,'Amrina Rosada','P','-','0000-00-00','-','-','-','11',0,NULL,0,0,0,0,'-','-',0,'-','-',NULL,'-',NULL,'-',NULL,'-',NULL,'-',NULL,'-',NULL,'-',NULL,'-','-','-'),(15,'Dial Saks Robin','L','-','0000-00-00','-','-','-','01',0,NULL,0,0,0,0,'-','-',0,'-','-',NULL,'-',NULL,'-',NULL,'-',NULL,'-',NULL,'-',NULL,'-',NULL,'-','-','-');
/*!40000 ALTER TABLE `manusia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pemakai`
--

DROP TABLE IF EXISTS `pemakai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pemakai` (
  `username` char(11) NOT NULL,
  `password` char(11) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pemakai`
--

LOCK TABLES `pemakai` WRITE;
/*!40000 ALTER TABLE `pemakai` DISABLE KEYS */;
INSERT INTO `pemakai` VALUES ('dwijim','dwisakethi'),('pingpong','123');
/*!40000 ALTER TABLE `pemakai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rekap`
--

DROP TABLE IF EXISTS `rekap`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rekap` (
  `Kode` char(2) NOT NULL,
  `Keterangan` char(68) NOT NULL DEFAULT '-',
  `Jumlah` int(5) NOT NULL DEFAULT 0,
  PRIMARY KEY (`Kode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rekap`
--

LOCK TABLES `rekap` WRITE;
/*!40000 ALTER TABLE `rekap` DISABLE KEYS */;
INSERT INTO `rekap` VALUES ('L','Laki-Laki',512),('P','Perempuan',300);
/*!40000 ALTER TABLE `rekap` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-04-26 14:29:25
