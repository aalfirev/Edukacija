<?php
include("dbconn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ime = mysqli_real_escape_string($MySQL, $_POST['name']);
    $prezime = mysqli_real_escape_string($MySQL, $_POST['surname']);
    $email = mysqli_real_escape_string($MySQL, $_POST['email']);
    $country = (int) $_POST['country'];
    $grad = mysqli_real_escape_string($MySQL, $_POST['city']);
    $ulica = mysqli_real_escape_string($MySQL, $_POST['street']);
    $datum_rodenja = mysqli_real_escape_string($MySQL, $_POST['birthdate']);

   
    $username = strtolower(substr($ime, 0, 1) . $prezime);
    $query = "SELECT username FROM users WHERE username='$username'";
    $result = mysqli_query($MySQL, $query);
    $counter = 1;

    while (mysqli_num_rows($result) > 0) {
        $username = strtolower(substr($ime, 0, 1) . $prezime) . $counter;
        $counter++;
        $result = mysqli_query($MySQL, "SELECT username FROM users WHERE username='$username'");
    }

    
    $plain_password = bin2hex(random_bytes(4)); // 
    $password = password_hash($plain_password, PASSWORD_DEFAULT);

    $query = "INSERT INTO users (first_name, last_name, email, country_id, city, street, birth_date, username, password)
              VALUES ('$ime', '$prezime', '$email', $country, '$grad', '$ulica', '$datum_rodenja', '$username', '$password')";
    if (mysqli_query($MySQL, $query)) {
        echo "<p>Uspješno ste registrirani!</p>";
        echo "<p>Korisničko ime: $username</p>";
        echo "<p>Lozinka: $plain_password</p>";
    } else {
        echo "<p>Došlo je do greške: " . mysqli_error($MySQL) . "</p>";
    }
}


echo '
<form method="post" action="">
    <label for="name">Ime:</label>
    <input type="text" id="name" name="name" required><br>

    <label for="surname">Prezime:</label>
    <input type="text" id="surname" name="surname" required><br>

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="country">Država:</label>
    <select id="country" name="country" required>';
    
    // Dohvaćanje država iz baze
    $query = "SELECT id, name FROM countries";
    $result = mysqli_query($MySQL, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
    }
    
    echo '</select><br>
    
    <label for="city">Grad:</label>
    <input type="text" id="city" name="city" required><br>

    <label for="street">Ulica:</label>
    <input type="text" id="street" name="street" required><br>

    <label for="birthdate">Datum rođenja:</label>
    <input type="date" id="birthdate" name="birthdate" required><br>

    <button type="submit">Registriraj se</button>
</form>';
?>
