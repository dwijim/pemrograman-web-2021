<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
  <title>Cek Daftar Pustaka</title>
  <link rel="stylesheet" type="text/css" href="../style.css">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
</head>

<body>
  <div class="latar">
    <div class="header">
      <header>
        <header class="judul"><b>S I K A T</b></header>
        <header class="deskripsi"><i>Koreksi Kata</i></header>
      </header>
    </div>
    <div id="menu">
      <?php include("../menubar.php"); ?>
    </div>
    <div class="tengah">
      <h2>Penulisan Referensi dan Daftar Pustaka</h2>
      <div class="auto">
        <table id="contact-detail" class="compact" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>Nomor</th>
              <th>Sitasi Dalam Naskah</th>
              <th>Entri Pada Daftar Pustaka</th>
            </tr>
          </thead>
          <tbody>
            <?php
            // KODE PHP i
            include "../koneksi.php";

            class docxConversion
            {
              private $filename;
              public function __construct($filePath)
              {
                $this->filename = $filePath;
              }
              private function read_doc()
              {
                if (!file_exists($this->filename)) return "";
                $fileHandle = fopen($this->filename, "r");
                $line = @fread($fileHandle, filesize($this->filename));
                fclose($fileHandle);
                $lines = explode(chr(0x0D), $line);
                $outtext = "";
                foreach ($lines as $thisline) {
                  $pos = strpos($thisline, chr(0x00));
                  if (($pos !== FALSE) || (strlen($thisline) == 0)) {
                  } else {
                    $outtext .= $thisline . " ";
                  }
                }
                $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/", "", $outtext);
                return $outtext;
              }
              private function read_docx()
              {
                $striped_content = '';
                $content = '';
                if (!file_exists($this->filename)) return false;
                $zip = zip_open($this->filename);
                if (!$zip || is_numeric($zip)) return false;
                while ($zip_entry = zip_read($zip)) {
                  if (zip_entry_open($zip, $zip_entry) == FALSE) continue;
                  if (zip_entry_name($zip_entry) != "word/document.xml") continue;
                  $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                  zip_entry_close($zip_entry);
                }
                zip_close($zip);
                $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
                $content = str_replace('</w:r></w:p>', "\r\n", $content);
                $striped_content = strip_tags($content);
                return $striped_content;
              }
              public function convertToText()
              {
                if (isset($this->filename) && !file_exists($this->filename)) {
                  return "File Not exists";
                }
                $fileArray = pathinfo($this->filename);
                $file_ext  = $fileArray['extension'];
                if ($file_ext == "doc" || $file_ext == "docx") {
                  if ($file_ext == "doc") {
                    return $this->read_doc();
                  } elseif ($file_ext == "docx") {
                    return $this->read_docx();
                  }
                } else {
                  return "Invalid File Type";
                }
              }
            }

            function hapus_spasi_spam($cus)
            {
              $cus = trim($cus);
              while (strpos($cus, "  ")) { // Menggunakan spasi ganda biasa
                $cus = str_replace("  ", " ", $cus);
              }
              return $cus;
            }

            // TAHAP 1: EKSTRAKSI DATA 
            $nama = mysqli_query($conn, "select nama from upload where id = 1");
            $nama1 = mysqli_fetch_assoc($nama);
            $gass = $nama1['nama'];
            $isi_dokumen = new docxConversion($gass); // Asumsi file ada di root yang sama
            $isi = $isi_dokumen->convertToText();
            $isi = hapus_spasi_spam($isi);

            $pattern_to_remove = '/ADDIN CSL_CITATION\s*\{.*?\}\s*("formattedCitation"\s*:\s*")(.*?)"/s';
            $replacement = '$2';
            $isi_bersih = preg_replace($pattern_to_remove, $replacement, $isi);

            preg_match_all('/\(([^)]+)\)/', $isi_bersih, $matches);
            $sitasi_kotor = isset($matches[1]) ? $matches[1] : [];
            $sitasi = [];
            foreach ($sitasi_kotor as $calon_sitasi) {
              if (
                preg_match('/[a-zA-Z]/', $calon_sitasi) &&
                preg_match('/\d{4}/', $calon_sitasi)
              ) {
                $sitasi[] = '(' . $calon_sitasi . ')';
              }
            }
            $sitasi = array_unique($sitasi);

            $kata_kunci_awal = ['daftar pustaka', 'referensi', 'bibliografi', 'sources'];
            $kandidat_posisi = [];

            $lines = explode("\n", $isi);

            $current_pos = 0;
            foreach ($lines as $line) {
              $cleaned_line = trim(strtolower($line));

              if (in_array($cleaned_line, $kata_kunci_awal)) {
                $kandidat_posisi[] = $current_pos;
              }

              $current_pos += strlen($line) + 1;
            }

            if (!empty($kandidat_posisi)) {
              $posisi_terakhir_daftar_pustaka = end($kandidat_posisi);
            } else {
              $posisi_terakhir_daftar_pustaka = false;
            }

            $posisi_potong = strlen($isi);
            $kata_kunci_setelah_dafpus = ['lampiran', 'apendiks', 'riwayat hidup'];

            if ($posisi_terakhir_daftar_pustaka !== false) {
              $teks_setelah_dafpus = substr($isi, $posisi_terakhir_daftar_pustaka);
              foreach ($kata_kunci_setelah_dafpus as $kata) {
                $pos_kata_kunci = stripos($teks_setelah_dafpus, $kata);
                if ($pos_kata_kunci !== false) {
                  $posisi_potong = $posisi_terakhir_daftar_pustaka + $pos_kata_kunci;
                  break;
                }
              }
            }

            $daftar_pustaka_teks = substr($isi, $posisi_terakhir_daftar_pustaka, $posisi_potong - $posisi_terakhir_daftar_pustaka);
            $field_codes_blacklist = [
              'ADDIN Mendeley Bibliography CSL_BIBLIOGRAPHY',
              'ADDIN ZOTERO_BIBL',
            ];
            // Mulai dengan teks kotor
            $daftar_pustaka_teks = ($posisi_terakhir_daftar_pustaka !== false) ? substr($isi_bersih, $posisi_terakhir_daftar_pustaka) : '';

            // Bersihkan dari blacklist
            $daftar_pustaka_teks_bersih = str_ireplace($field_codes_blacklist, '', $daftar_pustaka_teks);

            // Lanjutkan membersihkan dari variabel yang sudah bersih
            $daftar_pustaka_teks_bersih = str_ireplace("daftar pustaka", "", $daftar_pustaka_teks_bersih);

            // Pecah dari hasil akhir yang paling bersih
            $daftar_pustaka_array_kotor = array_filter(preg_split('/[\n\r]+/', $daftar_pustaka_teks_bersih), 'trim');

            // Bagian Validasi dan Normalisasi 
            function isValidDafpusEntry($item)
            {
              if (!preg_match('/[.\(]\s*\d{4}[a-z]?\s*[.\)]/', $item)) return false;
              if (strlen($item) > 500) return false;
              if (!preg_match('/^[A-Za-z]/', trim($item))) return false;
              return true;
            }

            function normalisasi_kunci_penulis_tahun($item)
            {
              $cleaned_item = html_entity_decode($item, ENT_QUOTES | ENT_HTML5, 'UTF-8');
              $cleaned_item = strtolower(trim($cleaned_item));
              if (substr($cleaned_item, 0, 1) == '(') $cleaned_item = substr($cleaned_item, 1);
              preg_match('/^([a-z\'-]+).*?(\d{4}[a-z]?)/', $cleaned_item, $matches);
              if (isset($matches[1]) && isset($matches[2])) return trim($matches[1]) . "-" . trim($matches[2]);
              preg_match('/(\d{4}[a-z]?)[.\s]+([a-z\'-]+)/', $cleaned_item, $matches);
              if (isset($matches[1]) && isset($matches[2])) return trim($matches[2]) . "-" . trim($matches[1]);
              return null;
            }

            // TAHAP 2: VALIDASI DAN PENCOCOKAN 
            $daftar_pustaka_array = array_filter($daftar_pustaka_array_kotor, 'isValidDafpusEntry');
            $peta_dafpus = [];
            foreach ($daftar_pustaka_array as $dafpus_item) {
              $kunci = normalisasi_kunci_penulis_tahun($dafpus_item);
              if ($kunci && !isset($peta_dafpus[$kunci])) $peta_dafpus[$kunci] = $dafpus_item;
            }
            $hasil_pencocokan = [];
            $kunci_dafpus_terpakai = [];

            $dafpus_tidak_terpakai = array_diff_key($peta_dafpus, $kunci_dafpus_terpakai);

            foreach ($sitasi as $sitasi_item) {
              $kunci_sitasi = normalisasi_kunci_penulis_tahun($sitasi_item);
              $entri_hasil = ['sitasi' => $sitasi_item, 'dafpus' => null];
              if ($kunci_sitasi && isset($peta_dafpus[$kunci_sitasi])) {
                $entri_hasil['dafpus'] = $peta_dafpus[$kunci_sitasi];
                $kunci_dafpus_terpakai[$kunci_sitasi] = true;
              } elseif ($kunci_sitasi) {
                list($penulis_sitasi, $tahun_sitasi) = explode('-', $kunci_sitasi);
                $threshold = 2;

                foreach ($peta_dafpus as $kunci_dafpus => $item_dafpus) {
                  list($penulis_dafpus, $tahun_dafpus) = explode('-', $kunci_dafpus);

                  // Jika tahun sama DAN nama penulisnya sangat mirip
                  if ($tahun_sitasi === $tahun_dafpus && levenshtein($penulis_sitasi, $penulis_dafpus) <= $threshold) {
                    $entri_hasil['dafpus'] = $item_dafpus;
                    $kunci_dafpus_terpakai[$kunci_dafpus] = true;
                    break;
                  }
                }
              }
              $hasil_pencocokan[] = $entri_hasil;
            }
            $dafpus_tidak_terpakai = [];
            foreach ($peta_dafpus as $kunci => $dafpus_item) {
              if (!isset($kunci_dafpus_terpakai[$kunci])) $dafpus_tidak_terpakai[] = $dafpus_item;
            }

            $_SESSION['hasil_analisis_sitasi'] = [
              'cocok_dan_tidak' => $hasil_pencocokan,
              'tidak_disitasi' => $dafpus_tidak_terpakai
            ];

            // TAHAP 3: TAMPILKAN HASIL DAN SIMPAN KE DATABASE
            if (!empty($hasil_pencocokan) || !empty($dafpus_tidak_terpakai)) {
              $nomor = 1;

              $stmt = mysqli_prepare($conn, "INSERT INTO daftar_pustaka (sitasi, dafpus) VALUES (?, ?)");

              foreach ($hasil_pencocokan as $hasil) {
                $sitasi_tampil = htmlspecialchars($hasil['sitasi']);
                $dafpus_tampil = $hasil['dafpus'] ? htmlspecialchars($hasil['dafpus']) : "<td style='color:red; background-color:#fff0f0;'>Tidak ada daftar pustaka yang cocok</td>";

                // Menampilkan data di tabel
                echo "<tr>";
                echo "<td>" . $nomor++ . "</td>";
                echo "<td>" . $sitasi_tampil . "</td>";
                if ($hasil['dafpus']) {
                  echo "<td>" . $dafpus_tampil . "</td>";
                } else {
                  echo $dafpus_tampil; // sudah termasuk tag <td>
                }
                echo "</tr>";

                $sitasi_db = $hasil['sitasi'];
                $dafpus_db = $hasil['dafpus'] ? $hasil['dafpus'] : 'Tidak ada daftar pustaka yang cocok';
                mysqli_stmt_bind_param($stmt, "ss", $sitasi_db, $dafpus_db);
                mysqli_stmt_execute($stmt);
              }

              if (!empty($dafpus_tidak_terpakai)) {
                foreach ($dafpus_tidak_terpakai as $item) {
                  // Menampilkan data di tabel
                  echo "<tr>";
                  echo "<td>" . $nomor++ . "</td>";
                  echo "<td style='color:orange; background-color:#fff9e6;'>Tidak pernah disitasi dalam naskah</td>";
                  echo "<td>" . htmlspecialchars($item) . "</td>";
                  echo "</tr>";

                  // *** [PERUBAHAN 3] Menyimpan hasil ke database ***
                  $sitasi_db = 'Tidak pernah disitasi dalam naskah';
                  $dafpus_db = $item;
                  mysqli_stmt_bind_param($stmt, "ss", $sitasi_db, $dafpus_db);
                  mysqli_stmt_execute($stmt);
                }
              }
              // Menutup statement setelah semua loop selesai
              mysqli_stmt_close($stmt);
            } else {
              echo "<tr><td colspan='3'>Tidak ada sitasi maupun daftar pustaka yang dapat dikenali dalam naskah.</td></tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
      <table>
        <tr>
          <td align="center"><a href="baqo.php?data=upload" type="submit">Selesai</a></td>
          <td align="center"><a href="hasil_sitasi.php" type="submit">Lihat Hasil</a></td>
          <td align="center"><a href="baqo.php?data=baca" type="submit">Kembali</a></td>
        </tr>
      </table>
    </div>
    <div id="footer">
      Copyright@ 2020 Andika Saputra(Jerambai)
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#contact-detail').DataTable({
        "order": []
      });
    });
  </script>
</body>

</html>