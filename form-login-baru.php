<?php
/* ------------------------------------------------
   form untuk melakukan login
   file ini diberi nama: form-login-baru.php
   dibuat pada tanggal 11 juli 2021

   ----------------------------------------------- */
?>
<form method=POST action=cek-login-sesi.php>
    <table border=0>
        <tr>
            <td> Username</td>
            <td>
                : <input type=text name=username>
            </td>
        </tr>

        <tr>
            <td> Password</td>
            <td>
                : <input type=password name=password>
            </td>

        <tr>
            <td colspan=2 align=center>
                <input type=submit value=Login>
            </td>
        </tr>
    </table>

</form>