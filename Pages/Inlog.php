<img src="" alt = "Logo wit"
<h1><b>Welkom!</b></h1>
<form action = "inlogredirect.php" method = "POST">
    <p><label for="Email"><b>E-mail:</b></label><br> 
    <input type = "email" name = "Email" placeholder="voer hier uw e-mail in..."></p>

    <p><label for="Password"><b>Wachtwoord:</b></label><br>
    <input type = "password" name = "Password" placeholder="voer hier uw wachtwoord in..."><br>
    <a href = "" >Wachtwoord vergeten?</a></p>

    <p><input type = "radio" id = "Student" name = "SorD" value = "Student" checked = "checked">Student
    <input type = "radio" id = "Docent" name = "SorD" value = "Docent">Docent</p>

    <p>
        <button formaction = "Registreer.php">Regristeren</button>
        <input type = "submit" name = "Submit" value = "Inloggen">
    </p>
</form>

de php gedeelte moet hier nog komen (validaten)