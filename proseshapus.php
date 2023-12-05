<html>
<body>
      <p id="demo"></p>
        <script>
      // Set the date we're counting down to
      var countDownDate = new Date("Jan 5, 2024 15:37:25").getTime();
      
      // Update the count down every 1 second
      var x = setInterval(function() {
      
        // Get today's date and time
        var now = new Date().getTime();
      
        // Find the distance between now and the count down date
        var distance = countDownDate - now;
      
        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
      
        // Display the result in the element with id="demo"
        document.getElementById("demo").innerHTML = "Batas pengisian data: "+days + " hari " + hours + " jam "
        + minutes + " menit " + seconds + " detik ";
      
        // If the count down is finished, write some text
        if (distance < 0) {
          clearInterval(x);
          document.getElementById("demo").innerHTML = "Waktu sudah habis ...";
        }
      }, 1000);
      </script>    
  </body>  
</html>

<?php
/* ------------------------------------------------------
   program untuk membaca isi suatu tabel dari basis data
   dibuat dengan PHP dan MariaDB
   dwi sakethi, 8 November 2023
   ------------------------------------------------------ */
   echo "<title>Hapus Data Anggota</title>";
   echo "<h1>Hapus Data Anggota</h1>";

   // membuat koneksi ke server
   //                     server      username password   basis data
   $konek=mysqli_connect("localhost","dwijim","12345678","latihan");

   $nomor_data = $_GET[nomor_data];
echo "$nomor_data<br>";

   // membuat kueri sesuai dengan kebutuhan
   $kueri = "delete from manusia 
             where  nomor_data=$nomor_data";
   //echo "$kueri<br>";
   // menjalankan kueri dan menyimpan hasilnya ke variabel
   $hasil = mysqli_query($konek,$kueri);
echo "<br>";
echo "Kli <a href=hapus.php>di sini ...</a>"
?>
