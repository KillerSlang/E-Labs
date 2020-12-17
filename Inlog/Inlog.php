<!DOCTYPE HTML>
<html>
    <head>
        <title>inlogpagina</title>
        <link href="../Css/inlog.css" rel="stylesheet" type="text/css">
    </head>
    <body> 
        <?php
            // Starting session
            session_start();
        ?>
        <div id="Container">
            <div id="inlogbox">
                <div id="logobalk">
                    <div id="logobalklogo">
                        <img src="../Images/Logo.png" alt = "Logo wit" >
                   </div>

                    <div id="logobalktext">
                        <h1><b>Welkom!</b></h1>
                    </div>
                </div>
                
                <div id="inlogruimte">
                   
                        <form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
                            <div id="Invoerveld1"><p><label for="Email"><b>E-mail:</b></label><br> 
                            <input type = "email" name = "Email" placeholder="voer hier uw e-mail in..."></p></div>

                            <div id="Invoerveld2"><p><label for="Password"><b>Wachtwoord:</b></label><br>
                            <input type = "password" name = "Password" placeholder="voer hier uw wachtwoord in..."></div>
                            <div id="wwvergeten"><a href = "wwvergeten.php" >Wachtwoord vergeten?</a></p></div>

                            <div id="SorD"><p><input type = "radio" id = "Student" name = "SorD" value = "Student" checked = "checked">Student	&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                            <input type = "radio" id = "Docent" name = "SorD" value = "Docent">Docent</p></div>
                            
                            <div id="registrerenbutton">
                                <button formaction = "Registreer.php">Registreren</button>
                            </div>
                            <div id="inlogbutton">
                                <input type = "submit" name = "Submit" value = "Inloggen">
                            </div>
                            
                        </form>
                      <div id="errorcodes"><b>


        <!-- Validaten -->
        <?php

if(isset($_POST["submit"])){

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
                        mysqli_select_db($connection, 'elabs');
            
                        $SQL = "SELECT studentID, studentNummer, studentNaam FROM student WHERE wachtwoord = '$wachtwoord' and studentEmail = '$email'";
                        $login = mysqli_query($connection, $SQL);
            
        
                            if(mysqli_num_rows($login) == 1){
                                
                                $row = mysqli_fetch_array($login);
                                
                                $studentID = $row['studentID'];
                                $studentNummer = $row['studentNummer'];
                                $studentNaam = $row['studentNaam'];

                                $_SESSION["StudentID"] = $studentID;
                                $_SESSION["SorD"] = "Student";
                                $_SESSION["studentNummer"] = $studentNummer;
                                $_SESSION["Name"] = $studentNaam;
                            
                                header("location: ../Homepage/Homepage.php");
                            }else{
                                echo "Probeer opnieuw";
                                
                            }
                        mysqli_close($connection);
                }
            }elseif(isset($_POST["Submit"]) and $SorD == "Docent")
            {

                $link = mysqli_connect("localhost","root","") 
                OR DIE("Could not connect to the database!");
                if($link)
                {
            
                        $connection = mysqli_connect("localhost","root","");
                        mysqli_select_db($connection, 'e-labs');
            
                        $SQL = "SELECT docentID, docentNaam FROM docent WHERE wachtwoord = '$wachtwoord' and docentEmail = '$email'";
                        $login = mysqli_query($connection, $SQL);
            
        
                            if(mysqli_num_rows($login) == 1){
                                
                                $row = mysqli_fetch_array($login);
                                
                                $docentID = $row['studentID'];
                                $docentNaam = $row['studentNaam'];

                                $_SESSION["docentID"] = $docentID;
                                $_SESSION["SorD"] = "Docent";
                                $_SESSION["Name"] = $docentNaam;
                            
                                header("location: ../Homepage/Homepage.php");
                            }else{

                                echo "Probeer opnieuw";
                                
                                

                            }
                        mysqli_close($connection);
                }
            }   
            
        }
        ?>

        </b></div>
                </div>
            </div>
        </div>
    </body>
</html>