<?php
// Mulai session untuk bisa membaca data yang disimpan
session_start();

// Ambil data hasil dari session
$hasil_analisis = isset($_SESSION['hasil_analisis_sitasi']) ? $_SESSION['hasil_analisis_sitasi'] : null;

// Jika tidak ada data di session (misal, halaman dibuka langsung), beri pesan.
if (!$hasil_analisis) {
    die("Tidak ada data hasil analisis untuk ditampilkan. Silakan jalankan analisis terlebih dahulu.");
}

// Pecah lagi datanya
$hasil_pencocokan = $hasil_analisis['cocok_dan_tidak'];
$dafpus_tidak_terpakai = $hasil_analisis['tidak_disitasi'];
?>
<html>
<title>Laporan Hasil Pengecekan Sitasi</title>
<style>
    body {
        font-family: sans-serif;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #f2f2f2;
    }

    .merah {
        background-color: red;
        color: white;
        transition: all 0.3s ease;
    }

    .merah:hover {
        background-color: darkred;
        color: #ffcccc;
    }

    .oranye {
        background-color: orange;
        color: black;
        transition: all 0.3s ease;
    }

    .oranye:hover {
        background-color: darkorange;
        color: white;
    }
</style>

<body>
    <h1>Laporan Hasil Pengecekan Sitasi dan Daftar Pustaka</h1>
    <h2><span class="merah">Warna Merah</span> berarti tidak ada daftar pustaka yang cocok</h2>
    <h2><span class="oranye">Warna Oranye</span> berarti tidak ada sitasi yang cocok</h2>
    <h3>Harus diperhatikan keselurahannya</h3>
    Data-data yang ada di sini, hanya sebagai pembantu saja.<br>
    Boleh jadi keliru, baik itu benar dianggap salah.
    Ataupun salah dianggap benar.<br><br>
    <table>
        <thead>
            <tr>
                <th>Nomor</th>
                <th>Sitasi Dalam Naskah</th>
                <th>Entri Pada Daftar Pustaka</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $nomor = 1;

            if (!empty($hasil_pencocokan)) {
                foreach ($hasil_pencocokan as $hasil) {
                    $sitasi = htmlspecialchars($hasil['sitasi']);
                    $dafpus = $hasil['dafpus'] ? htmlspecialchars($hasil['dafpus']) : 'Tidak ada daftar pustaka yang cocok';
                    $class_css = !$hasil['dafpus'] ? 'merah' : '';

                    echo "<tr class='" . $class_css . "'>";
                    echo "<td>" . $nomor++ . "</td>";
                    echo "<td>" . $sitasi . "</td>";
                    echo "<td>" . $dafpus . "</td>";
                    echo "</tr>";
                }
            }

            if (!empty($dafpus_tidak_terpakai)) {
                foreach ($dafpus_tidak_terpakai as $item) {
                    echo "<tr class='oranye'>";
                    echo "<td>" . $nomor++ . "</td>";
                    echo "<td>Tidak pernah disitasi dalam naskah</td>";
                    echo "<td>" . htmlspecialchars($item) . "</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</body>

</html>