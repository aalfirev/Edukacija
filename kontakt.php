<?php 
echo '
<section>
    <h2>Kontaktirajte nas</h2>

   
    <div class="map-section">
        
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d177883.63835527323!2d15.799213054261052!3d45.842655792404045!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1shr!2shr!4v1733070199644!5m2!1shr!2shr" 
        width="100%" height="300" allowfullscreen="" loading="lazy"></iframe>
    
   
    </div>

    <!-- Forma za kontakt -->
    <section class="contact-form-section">
        <h3>Pošaljite nam poruku:</h3>
        <form action="send_contact.php" method="post">
            <div>
                <label for="name">Ime:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="surname">Prezime:</label>
                <input type="text" id="surname" name="surname" required>
            </div>
            <div>
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="country">Država:</label>
                <select id="country" name="country">
                    <option value="hr">Hrvatska</option>
                    <option value="si">Slovenija</option>
                    <option value="ba">Bosna i Hercegovina</option>
                    <option value="rs">Srbija</option>
                </select>
            </div>
            <div>
                <label for="message">Opis:</label>
                <textarea id="message" name="message" rows="5"></textarea>
            </div>
            <button type="submit">Pošalji</button>
        </form>
    </section>
</section>';
?>
