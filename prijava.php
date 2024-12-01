<?php
echo '
<section>
    <h2>Prijava korisnika</h2>
    <form action="process_login.php" method="POST">
    <label for="username">Korisničko ime:</label>
    <input type="text" id="username" name="username" required>
    
    <label for="password">Lozinka:</label>
    <input type="password" id="password" name="password" required>
    
    <button type="submit">Prijavi se</button>
</form>
</section>';
?>

