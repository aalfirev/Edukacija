<?php
require_once 'dbconn.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}


if (isset($_GET['id'])) {
    $user_id = (int)$_GET['id'];
    $delete_query = "DELETE FROM users WHERE id = $user_id";

    if (mysqli_query($MySQL, $delete_query)) {
        header("Location: http://localhost/php/edukacija_II/index.php?menu=8");
        exit;
    } else {
        echo "<p>Greška prilikom brisanja korisnika: " . mysqli_error($MySQL) . "</p>";
    }
} else {
    echo "<p>Nevažeći ID korisnika.</p>";
    exit;
}
?>
