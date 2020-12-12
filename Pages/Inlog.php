<?php
// Starting session
session_start();
?>


<img src="" alt = "Logo wit" >
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

<!-- de php gedeelte moet hier nog komen (validaten) -->


<?php

    $email = $_POST["Email"];
    $ww = $_POST["Password"];
    $wachtwoord = sha1($ww);
    $SorD = $_POST["SorD"];

    if(isset($_POST["Submit"]) and $SorD == "Student")
    {

        $link = mysqli_connect("localhost","root","") 
        OR DIE("Could not connect to the database!");
        if($link)
        {
    
                $connection = mysqli_connect("localhost","root","");
                mysqli_select_db($connection, 'e-labs');
    
                $SQL = "SELECT studentID FROM student WHERE wachtwoord = '$wachtwoord' and studentEmail = '$email'";
                $login = mysqli_query($connection, $SQL);
    
 
                    if(mysqli_num_rows($login) == 1){
                        
                        $row = mysqli_fetch_array($login);
                        
                        $studentID = $row['studentID'];

                        $_SESSION["StudentID"] = $studentID;
                        $_SESSION["SorD"] = "Student";
                       
                    }else{
                        echo "Probeer opnieuw";
                    }
    
    
                
    
    
                mysqli_close($connection);
                
                
            
        }
    }      





    
    

?>