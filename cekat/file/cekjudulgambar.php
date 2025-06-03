<html>

    <head>
        <title>Koreksi Kata</title>
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
                <h2>Penulisan Judul Gambar</h2>
                <div class="auto">
                    <table id="contact-detail" class="compact" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nomor</th>
                                <th>Judul</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>

                        <?php
                        include "../koneksi.php";

                        // kelas untuk membaca isi file .docx
                        class docxConversion {
                            private $filename;

                            public function __construct($filePath) {
                                $this->filename = $filePath;
                            }

                            public function read_docx() {
                                // fungsi utama untuk membaca file .docx
                                if (!file_exists($this->filename)) {
                                    return false;
                                }

                                // buka file sebagai ZIP
                                $zip = zip_open($this->filename);
                                if (!$zip || is_numeric($zip)) {
                                    return false;
                                }

                                $content = '';
                                // iterasi isi file dalam ZIP
                                while ($zip_entry = zip_read($zip)) {
                                    if (zip_entry_open($zip, $zip_entry) == false) {
                                        continue;
                                    }

                                    // cari file "word/document.xml" dalam .docx
                                    if (zip_entry_name($zip_entry) == "word/document.xml") {
                                        $content = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                                        break;
                                    }
                                    zip_entry_close($zip_entry);
                                }
                                zip_close($zip);

                                // menguraikan XML dari document.xml
                                $dom = new DOMDocument();
                                @$dom->loadXML($content);

                                // ambil seluruh teks dari XML
                                $striped_content = '';
                                $paragraphs = $dom->getElementsByTagName('p');
                                foreach ($paragraphs as $paragraph) {
                                    $text = '';
                                    $runs = $paragraph->getElementsByTagName('r');
                                    foreach ($runs as $run) {
                                        $textNodes = $run->getElementsByTagName('t');
                                        foreach ($textNodes as $textNode) {
                                            $text .= $textNode->nodeValue;
                                        }
                                    }
                                    // tambah newline setelah setiap pargraf
                                    $striped_content .= $text . "\\n";
                                }

                                return $striped_content;
                            }
                        }

                        /*
                        // fungsi untuk membuang karakter spasi yang tidak terpakai
                        function hapus_spasi_spam($cus) {
                            $cus = trim($cus);

                            while (strpos($cus, "  ")) {
                                $cus = str_replace("  ", " ", $cus);
                            }

                            return $cus;
                        }
                        */

                        /*
                        // fungsi untuk membuang tulisan tambahan judul gambar
                        function hapus_tambahan_judul_gambar($cus)
                        {
                            $cus = trim($cus);
                            $tulisan_tambahan = 'SEQ Gambar \* ARABIC ';

                            while (strpos($cus, $tulisan_tambahan)) {
                                $cus = str_replace($tulisan_tambahan, ' ', $cus);
                            }

                            return $cus;
                        }
                        */

                        /*
                        // bersihkan tulisan SEQ sampai dengan ARABIC pada judul
                        function mengambil_judul_seq_arabic($salah_judul)
                        {
                            $panjang_salah_judul = strlen($salah_judul);
                            $posisi_seq          = strpos($salah_judul, 'SEQ');
                            $panjang_ARABIC      = strlen('ARABIC');
                            $posisi_arabic      = strpos($salah_judul, 'ARABIC')+$panjang_ARABIC;
                            $judul_baru = "";

                            for ($mulai=0;$mulai<=$panjang_salah_judul-1;$mulai++) {
                                if (($mulai>$posisi_arabic) or ($mulai<$posisi_seq)) {
                                    $judul_baru = $judul_baru.substr($salah_judul, $mulai, 1);
                                }
                            }

                            return $judul_baru;
                        }
                        */

                        /*
                        // fungsi untuk mencari kata pada nested array
                        function in_array_r($needle, $haystack, $strict = false)
                        {
                            foreach ($haystack as $item) {
                                if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                                    return true;
                                }
                            }

                            return false;
                        }
                        */

                        // ambil nama file dari database
                        $nama = mysqli_query($conn, "select nama from upload where id = 1");
                        $nama1 = mysqli_fetch_assoc($nama);
                        $nama2 = $nama1['nama'];
                        $gass = $nama2;

                        // baca isi file .docx
                        $mentah = new docxConversion($gass);
                        $mentah = $mentah->read_docx();

                        /*
                        // bersihkan isi file .docx
                        $mentah = hapus_tambahan_judul_gambar($mentah);
                        $isi = hapus_spasi_spam($isi);
                        */

                        // ambil isi file .docx mulai dari bagian "PENDAHULUAN"
                        $isi = substr($mentah, strpos($mentah, "\\nPENDAHULUAN\\n"));

                        /*
                        // lihat hasil bacaan file .docx
                        echo $isi."<br>"; exit();
                        */

                        // simpan hasil judul gambar
                        $hasil = [];

                        $kata_yang_dicari = "Gambar ";
                        $panjang_skripsi = strlen($isi);
                        $panjang_kata_yang_dicari = strlen($kata_yang_dicari);
                        $asumsi_panjang_judul = 500;

                        // proses dari huruf pertama bagian pendahuluan sampai dengan terakhir isi file .docx
                        for ($proses = 0; $proses <= $panjang_skripsi; $proses++) {
                            $potongan_isi = substr($isi, $proses, $panjang_kata_yang_dicari);

                            // jika ditemukan "Gambar "
                            if ($potongan_isi == $kata_yang_dicari) {
                                // cek kata sebelum kata "Gambar "
                                $sebelum = substr($isi, max(0, $proses - 20), 20);
                                $kata_kata = explode(' ', trim($sebelum));
                                $jumlah_kata = count($kata_kata);
                                $kata_sebelum = strtolower($jumlah_kata > 0 ? $kata_kata[$jumlah_kata - 1] : '');

                                // jika kata sebelum kata "Gambar " adalah kata terlarang
                                if (in_array($kata_sebelum, ['pada', 'dengan', 'dalam', 'dan', 'seperti', 's/d'])) {
                                    continue;
                                }

                                // cek kata setelah kata "Gambar " adalah angka, misal "Gambar 3"
                                $posisi_angka = $proses + $panjang_kata_yang_dicari;
                                $apakah_angka = substr($isi, $posisi_angka, 1);
                                $nilai = is_numeric($apakah_angka);

                                if ($nilai == 0) {
                                    continue;
                                }

                                // ambil potongan isi dari posisi angka untuk diperiksa kata setelah angka
                                $judul_gambarnya = substr($isi, $proses, $asumsi_panjang_judul);
                                $setelah_gambar = substr($isi, $posisi_angka, 20);
                                $potongan_kata = explode(" ", trim($setelah_gambar));

                                // ambil angka dan kata setelah angka
                                $angka_gambar = $potongan_kata[0];
                                $kata_berikutnya = isset($potongan_kata[1]) ? strtolower($potongan_kata[1]) : '';

                                // jika kata setelah kata "Gambar " adalah kata terlarang
                                if (in_array($kata_berikutnya, ['menjelaskan', 'adalah', 'yaitu', 'pada', 'menampilkan', 'menggambarkan', 'menunjukkan', 'memuat', 'diketahui', 'merupakan', 'memperlihatkan', 'terlihat', 'dan', 'akan', 's/d'])) {
                                    continue;
                                }
                                
                                // ambil judul akhir
                                $judul_akhir = $judul_gambarnya;

                                /*
                                // buang tulisan "ARABIC" pada judul
                                $cek_arabic = false;
                                $judul_gambarnya2 = "";
                                $ada = strpos($judul_gambarnya, 'ARABIC');

                                if ($ada!==false) {
                                    $judul_gambarnya2 = mengambil_judul_seq_arabic($judul_gambarnya);
                                    $cek_arabic = true;
                                }

                                if ($cek_arabic==true) {
                                    $judul_akhir = $judul_gambarnya2;
                                }
                                */
                                
                                /*
                                // buang tulisan "CITATION" pada judul
                                $judul_gambarnya3 = "";
                                $posisi_citation = strpos($judul_akhir, "ADDIN ZOTERO_ITEM CSL_CITATION");
                                if ($posisi_citation!=0) {
                                    for ($karakter=0;$karakter<=$posisi_citation-2;$karakter++) {
                                        $judul_gambarnya3 = $judul_gambarnya3.substr($judul_akhir, $karakter, 1);
                                    }

                                    $judul_akhir = $judul_gambarnya3;
                                }
                                */
                                
                                
                                /*
                                // lihat hasil judul akhir
                                echo $judul_akhir."<br>";
                                */

                                // ambil judul sampai 2 titik ditemukan
                                $jumlah_titik_judul = 0;
                                $panjang = strlen($judul_akhir);
                                $judul = "";
                                $ket = "";

                                for ($karakter = 0; $karakter <= $panjang; $karakter++) {
                                    $huruf_ke = substr($judul_akhir, $karakter, 1);

                                    // hitung jumlah titik
                                    if ($huruf_ke == ".") {
                                        $jumlah_titik_judul++;

                                        // jika menemukan karakter '\'
                                    } elseif ($huruf_ke == "\\") {  
                                        $ket = "Tidak ada titik";
                                        break;
                                    }

                                    // stop ketika sudah menemukan 2 titik
                                    if ($jumlah_titik_judul == 2) {
                                        $judul = $judul . $huruf_ke;
                                        $ket = "Benar";
                                        break;
                                    } else {
                                        $judul = $judul . $huruf_ke;
                                    }

                                    /*
                                    // menampilkan hanya gambar tanpa judul
                                    if (is_numeric($huruf_ke)) {
                                        if (substr($judul_akhir, $karakter-7, 7) == "Gambar " && !in_array_r($judul, $hasil, true) && $karakter>8) {
                                            break;
                                        }
                                        
                                        if (substr($judul_akhir, $karakter-7, 7) == "Gambar ") {
                                            $judul = substr($judul_akhir, $karakter-7, 7). $huruf_ke;
                                        } elseif (substr($judul_akhir, $karakter-2, 2) == ". ") {
                                            $judul = $judul.". ". $huruf_ke;
                                        } elseif (is_numeric(substr($judul_akhir, $karakter-1, 1))) {
                                            $judul = $judul. $huruf_ke;
                                        }
                                    }
                                    */
                                }

                                // simpan hasil judul dan keterangan
                                array_push($hasil, [$judul, $ket]);

                                // reset pencarian
                                $kata_yang_dicari = "Gambar ";
                                $panjang_kata_yang_dicari = strlen($kata_yang_dicari);
                            }
                        }
                        ?>

                        <tbody>
                            <?php
                            $no = 1;

                            // menampilkan hasil pencarian pada tabel
                            foreach ($hasil as $h) {
                                echo "<tr>
                                        <td align='center'>" . $no++ . "</td>
                                        <td>" . $h[0] . "</td>
                                        <td align='center'>" . $h[1] . "</td>
                                    </tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                    <script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
                    <script type="text/javascript">
                    $(document).ready(function () {
                        $('#contact-detail').DataTable({
                        rowCallback: function (row, data, index) {
                            if (data[1] == "Salah Tulis") {
                            $(row).find('td').css('background-color', '#FF6347');
                            }
                        }
                        });
                    });
                    </script>
                </div>

                <table>
                    <tr>
                    <td align="center"><a href="baqo.php?data=upload" type="submit">Selesai</a></td>
                    <td align="center"><a href="baqo.php?data=baca" type="submit">Kembali</a></td>
                    </tr>
                </table>
            </div>

            <div id="footer">
                Copyright@ 2020 Andika Saputra(Jerambai)
            </div>
        </div>
    </body>

</html>
