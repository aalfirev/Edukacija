
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<?php

$MySQL = mysqli_connect("localhost", "root", "", "inf_edukacija") 
    or die('Greška prilikom povezivanja na MySQL server.');
?>
