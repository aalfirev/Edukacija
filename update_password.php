<?php
include("dbconn.php"); 


$new_password = "novaLozinka123";
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);


$username = "auser";
$sql = "UPDATE users SET password='$hashed_password' WHERE username='$username'";

if (mysqli_query($MySQL, $sql)) {
    echo "Lozinka je uspešno promenjena!";
    echo "Nova lozinka za korisnika '$username': $new_password";
} else {
    echo "Greška pri promeni lozinke: " . mysqli_error($MySQL);
}

mysqli_close($MySQL);
?>
