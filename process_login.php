<?php
include("dbconn.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($MySQL, $_POST['username']);
    $password = $_POST['password'];

 
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($MySQL, $query);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

  
        if (password_verify($password, $user['password'])) {
          
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role']; 
            $_SESSION['username'] = $user['username'];

            echo "Prijava uspješna! Preusmjeravanje...";

          
            if ($user['role'] === 'admin') {
                header("Location: http://localhost/php/edukacija_II/index.php?menu=8"); 
            } else {
                header("Location: http://localhost/php/edukacija_II/index.php"); 
            }
            exit();
        } else {
            echo "Pogrešna lozinka.";
        }
    } else {
        echo "Korisničko ime ne postoji.";
    }
}
?>
