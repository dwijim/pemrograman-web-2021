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

            require_once "../koneksi.php";
            set_time_limit(0);


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
              while (strpos($cus, "  ")) {
                $cus = str_replace("  ", " ", $cus);
              }
              return $cus;
            }



            function extractBibliographyText($full_text)
            {
              $bibliography_block = '';
              $start_pos = false;

              // =====================================================================
              // PRIORITAS 1: MENCARI HEADING DENGAN METODE CERDAS (FLEKSIBEL + AMAN)
              // =====================================================================
              $heading_keywords = ['daftar pustaka', 'referensi', 'bibliografi', 'bibliography'];
              // Normalisasi semua jenis jeda baris menjadi satu jenis (\n) untuk konsistensi
              $normalized_text = str_replace(["\r\n", "\r"], "\n", $full_text);
              $lines = explode("\n", $normalized_text);
              $char_pos = 0;

              foreach ($lines as $line) {
                $cleaned_line = trim(preg_replace('/\s+/', ' ', strtolower($line)));
                foreach ($heading_keywords as $keyword) {
                  // Kondisi: Jika baris MENGANDUNG kata kunci DAN cukup PENDEK untuk sebuah judul
                  if (strpos($cleaned_line, $keyword) === 0){
                    $start_pos = $char_pos + strlen($line) + 1;
                    break 2; // Ditemukan, langsung keluar dari kedua loop
                  }
                }
                $char_pos += strlen($line) + 1;
              }

              // ======================================================================
              // PRIORITAS 2 (CADANGAN): JIKA HEADING GAGAL, BARU GUNAKAN TEBAKAN POLA
              // ======================================================================
              if ($start_pos === false) {
                // Regex ini fleksibel untuk format tahun dan ketat (case-sensitive) untuk format nama
                $pattern = '/([A-Z][a-z\'-]+,?\s+.*?)(\d{4})/';
                preg_match_all($pattern, $full_text, $matches, PREG_OFFSET_CAPTURE);

                if (count($matches[0]) >= 2) {
                  $text_length = strlen($full_text);
                  $search_start_offset = (int)($text_length * 0.60);
                  foreach ($matches[0] as $match) {
                    if ($match[1] >= $search_start_offset) {
                      $start_pos = $match[1];
                      break;
                    }
                  }
                }
              }

              // Jika setelah semua usaha tetap tidak ditemukan, kembalikan string kosong
              if ($start_pos === false) {
                return "";
              }

              // Ekstrak blok dari posisi yang benar
              $bibliography_block = substr($full_text, $start_pos);

              // Potong bagian akhir jika ada lampiran
              $cut_off_keywords = ['lampiran', 'apendiks', 'riwayat hidup', 'kuesioner penelitian'];
              foreach ($cut_off_keywords as $keyword) {
                if (($cut_pos = stripos($bibliography_block, $keyword)) !== false) {
                  $bibliography_block = substr($bibliography_block, 0, $cut_pos);
                  break;
                }
              }

              $cleaned_block = str_ireplace($heading_keywords, '', $bibliography_block);

              $lines = explode("\n", $cleaned_block); // Pecah teks menjadi array per baris
              $clean_lines = []; // Siapkan array untuk menampung baris bersih
              $prefixes_to_check = ['ADDIN Mendeley CSL_', 'ADDIN CSL_CITATION'];

              foreach ($lines as $line) {
                $trimmed_line = trim($line); // Hapus spasi di awal/akhir baris
                $prefix_found = false;

                foreach ($prefixes_to_check as $prefix) {
                  // Cek apakah baris ini DIAWALI dengan salah satu prefiks
                  if (strpos($trimmed_line, $prefix) === 0) {
                    // Jika ya, potong prefiks tersebut dari awal string
                    $clean_lines[] = trim(substr($trimmed_line, strlen($prefix)));
                    $prefix_found = true;
                    break; // Lanjut ke baris berikutnya
                  }
                }

                // Jika tidak ada prefiks yang ditemukan, masukkan baris asli
                if (!$prefix_found) {
                  $clean_lines[] = $line;
                }
              }

              // Gabungkan kembali baris-baris bersih menjadi satu blok teks
              $final_cleaned_block = implode("\n", $clean_lines);

              return trim($final_cleaned_block);
            }


            // Fungsi untuk mendeteksi apakah daftar pustaka dari Mendeley atau manual
            function detectReferenceFormat($text)
            {
              // Hitung jumlah line breaks
              $lineBreaks = substr_count($text, "\n");

              // Hitung jumlah pattern author-year yang mungkin
              preg_match_all('/[A-Z][a-z]+,\s*[A-Z]\..*?\(\d{4}\)/', $text, $matches);
              $authorYearPatterns = count($matches[0]);

              // Jika line breaks sedikit tapi pattern author-year banyak, kemungkinan dari Mendeley
              if ($lineBreaks < $authorYearPatterns) {
                return 'mendeley';
              }

              return 'manual';
            }

            // Fungsi untuk parsing daftar pustaka dari Mendeley
            function parseMendeleyReferences($text)
            {
              $references = [];

              // Pattern untuk berbagai format referensi
              $patterns = [
                // APA Style: Nama, I. (Tahun). Judul
                '/(?=([A-Z][a-z]+(?:,\s*[A-Z]\.(?:\s*[A-Z]\.)*)*(?:,\s*[A-Z][a-z]+(?:,\s*[A-Z]\.(?:\s*[A-Z]\.)*)*)*(?:,\s*(?:dan|and|&)\s*[A-Z][a-z]+(?:,\s*[A-Z]\.(?:\s*[A-Z]\.)*)*)*,?\s*\(\d{4}[a-z]?\)))/i',

                // IEEE Style: [1] Nama
                '/(?=\[\d+\]\s*[A-Z])/i',

                // Vancouver Style: 1. Nama
                '/(?=\d+\.\s*[A-Z])/i'
              ];

              foreach ($patterns as $pattern) {
                $temp_refs = preg_split($pattern, $text, -1, PREG_SPLIT_NO_EMPTY);

                if (count($temp_refs) > 1) {
                  // Bersihkan setiap referensi
                  foreach ($temp_refs as $ref) {
                    $ref = trim($ref);
                    if (!empty($ref) && strlen($ref) > 20) { // Filter referensi yang terlalu pendek
                      $references[] = $ref;
                    }
                  }
                  break; // Gunakan pattern yang berhasil pertama kali
                }
              }

              // Jika pattern di atas tidak berhasil, coba dengan pendekatan lain
              if (empty($references)) {
                $references = parseByAuthorYearAdvanced($text);
              }

              return $references;
            }

            // Fungsi parsing lanjutan berdasarkan pola author-year
            function parseByAuthorYearAdvanced($text)
            {
              $references = [];

              // Pattern yang lebih fleksibel untuk menangkap berbagai format
              $pattern = '/([A-Z][a-z\'-]+,?\s+(?:[A-Z]\.\s?)*.*?)(?:[\(\[](\d{4}[a-z]?)[\)\]]|\b(\d{4}[a-z]?)\.)/';
              preg_match_all($pattern, $text, $matches, PREG_OFFSET_CAPTURE);

              if (!empty($matches[0])) {
                for ($i = 0; $i < count($matches[0]); $i++) {
                  $start = $matches[0][$i][1];
                  $end = isset($matches[0][$i + 1]) ? $matches[0][$i + 1][1] : strlen($text);

                  $reference = trim(substr($text, $start, $end - $start));

                  // Validasi panjang referensi
                  if (strlen($reference) > 20 && strlen($reference) < 1000) {
                    $references[] = $reference;
                  }
                }
              }

              return $references;
            }

            // Fungsi untuk membersihkan dan memisahkan daftar pustaka
            function parseReferences($daftar_pustaka_teks)
            {
              // Deteksi format daftar pustaka
              $format = detectReferenceFormat($daftar_pustaka_teks);

              if ($format === 'mendeley') {
                // Gunakan parser khusus untuk Mendeley
                $daftar_pustaka_array = parseMendeleyReferences($daftar_pustaka_teks);
              } else {
                // Gunakan metode lama untuk format manual
                $daftar_pustaka_array = array_filter(preg_split('/[\n\r]+/', $daftar_pustaka_teks), 'trim');
              }

              return $daftar_pustaka_array;
            }

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

            // TAHAP 1: EKSTRAKSI DATA 
            $nama = mysqli_query($conn, "select nama from upload where id = 1");
            $nama1 = mysqli_fetch_assoc($nama);
            $gass = $nama1['nama'];

            // Langkah 1: Coba baca dengan fungsi bawaan
            $isi_dokumen = new docxConversion($gass);
            $isi = $isi_dokumen->convertToText();

            if (strlen(trim($isi)) < 500) { // Anggap gagal jika teks kurang dari 500 karakter
              $isi = baca_docx_alternatif($gass);
            }

            $prefixes_to_remove = [
              'ADDIN Mendeley CSL_',
              'ADDIN CSL_CITATION'
            ];

            $isi = str_replace($prefixes_to_remove, '', $isi);

            // Lanjutkan proses seperti biasa
            $isi = hapus_spasi_spam($isi);

            if (!empty($isi) && file_exists($gass)) {
              unlink($gass); // Menghapus file fisik dari server

              // (Opsional) Hapus juga entri dari database agar tidak ada referensi "mati"
              $id_upload = 1; // Sesuaikan dengan ID yang Anda gunakan
              mysqli_query($conn, "DELETE FROM upload WHERE id = " . $id_upload);
            }

            $pattern_to_remove = '/(ADDIN CSL_CITATION|ADDIN Mendeley CSL_)\s*\{.*?\}\s*("formattedCitation"\s*:\s*")(.*?)"/s';
            $replacement = '$3';
            $isi_bersih = preg_replace($pattern_to_remove, $replacement, $isi);
            $isi_bersih = html_entity_decode($isi_bersih, ENT_QUOTES, 'UTF-8');

            // TEMUKAN DAN ISOLASI BLOK DAFTAR PUSTAKA
            $daftar_pustaka_teks = extractBibliographyText($isi_bersih);

            //BUAT NASKAH UTAMA (TANPA DAFTAR PUSTAKA)
            $naskah_utama = !empty($daftar_pustaka_teks) ? str_replace($daftar_pustaka_teks, '', $isi_bersih) : $isi_bersih;

            // EKSTRAK SITASI DARI NASKAH UTAMA (METODE DUA LANGKAH)
            $sitasi_ditemukan = [];

            // Cari sitasi dalam kurung
            $pattern_parenthetical = '/\((([a-zA-Z\s,\'&et al.dkk-]+?),?\s*(\d{4}[a-z]?))\)/';
            preg_match_all($pattern_parenthetical, $naskah_utama, $matches_parenthetical);
            if (!empty($matches_parenthetical[0])) {
              foreach ($matches_parenthetical[0] as $match) {
                $sitasi_ditemukan[] = $match;
              }
            }

            // Cari sitasi naratif
            $pattern_narrative = '/((?:(?!Menurut|Berdasarkan|Dalam|Oleh|dikutip dari\s)\b[A-Z][a-z\'-]+\b|[,\s&]|et al\.|dkk\.,|dan)+?)\s+\((\d{4}[a-z]?)\)/';
            preg_match_all($pattern_narrative, $naskah_utama, $matches_narrative, PREG_SET_ORDER);
            if (!empty($matches_narrative)) {
              foreach ($matches_narrative as $match) {
                if (!empty($match[1]) && !empty($match[2])) {
                  $author_part = trim(preg_replace('/\s+/', ' ', $match[1]));
                  $sitasi_ditemukan[] = $author_part . ' (' . $match[2] . ')';
                }
              }
            }

            //Finalisasi daftar sitasi
            $sitasi = array_unique($sitasi_ditemukan);

            //PROSES DAFTAR PUSTAKA DAN LAKUKAN PENCOCOKAN
            if (empty($daftar_pustaka_teks)) {
              echo "<tr><td colspan='3'>Error: Blok Daftar Pustaka tidak dapat dideteksi.</td></tr>";
            } else {

              // Lanjutkan proses parsing daftar pustaka menjadi array
              $daftar_pustaka_array_kotor = parseReferences($daftar_pustaka_teks);

              // TAHAP 2: VALIDASI DAN PENCOCOKAN (Kode ini tidak perlu diubah)
              $daftar_pustaka_array = array_filter($daftar_pustaka_array_kotor, 'isValidDafpusEntry');
              $peta_dafpus = [];
              foreach ($daftar_pustaka_array as $dafpus_item) {
                $kunci = normalisasi_kunci_penulis_tahun($dafpus_item);
                if ($kunci && !isset($peta_dafpus[$kunci])) $peta_dafpus[$kunci] = $dafpus_item;
              }

              $hasil_pencocokan = [];
              $kunci_dafpus_terpakai = [];

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
            }


            // TAHAP 3: TAMPILKAN HASIL DAN SIMPAN KE DATABASE
            if (!empty($hasil_pencocokan) || !empty($dafpus_tidak_terpakai)) {
              $nomor = 1;

              $stmt = mysqli_prepare($conn, "INSERT INTO daftar_pustaka (sitasi, dafpus) VALUES (?, ?)");

              foreach ($hasil_pencocokan as $hasil) {
                $sitasi_tampil = htmlspecialchars($hasil['sitasi']);
                $dafpus_tampil = $hasil['dafpus'] ? htmlspecialchars($hasil['dafpus']) : "<td style='color:red; background-color:#fff0f0;'>Tidak ada daftar pustaka yang sesuai</td>";

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
                $dafpus_db = $hasil['dafpus'] ? $hasil['dafpus'] : 'Tidak ada daftar pustaka yang sesuai';
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