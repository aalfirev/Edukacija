<?php
include("dbconn.php");


$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$country = $_POST['country'];
$city = $_POST['city'];
$street = $_POST['street'];
$dob = $_POST['dob'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Kriptiranje lozinke


$username = strtolower($name[0] . $surname);
$query = "SELECT COUNT(*) AS user_count FROM users WHERE username LIKE '$username%'";
$result = mysqli_query($MySQL, $query);
$row = mysqli_fetch_assoc($result);
if ($row['user_count'] > 0) {
    $username .= ($row['user_count'] + 1);
}


$query = "INSERT INTO users (username, name, surname, email, country_id, city, street, dob, password) 
          VALUES ('$username', '$name', '$surname', '$email', $country, '$city', '$street', '$dob', '$password')";
if (mysqli_query($MySQL, $query)) {
    echo "Registracija uspješna! Vaše korisničko ime: $username";
} else {
    echo "Greška: " . mysqli_error($MySQL);
}
?>
