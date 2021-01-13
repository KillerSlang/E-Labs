<!DOCTYPE HTML>
<html>
    <head>
        <title>inlogpagina</title>
        <link href="../Css/inlog.css" rel="stylesheet" type="text/css">
    </head>
    <body> 
        
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
                   
                        <form action = "Inlog.php" method = "POST" >
                            <div id="Invoerveld1"><p><label for="Email"><b>E-mail:</b></label><br> 
                            <input type = "email" name = "Email" placeholder="voer hier uw e-mail in..."></p></div>

                            <div id="Invoerveld2"><p><label for="Password"><b>Wachtwoord:</b></label><br>
                            <input type = "password" name = "Password" placeholder="voer hier uw wachtwoord in..."></div>
                            <div id="wwvergeten"><a href = "Pages/wwvergeten.php" >Wachtwoord vergeten?</a></p></div>

                            <div id="SorD"><p><input type = "radio" id = "Student" name = "SorD" value = "Student" checked = "checked">Student
                            <input type = "radio" id = "Docent" name = "SorD" value = "Docent">Docent</p></div>
                            
                            
                            <div id="inlogbutton">
                                <input type = "submit" name = "Submit" value = "Inloggen">
                            </div>
                            
                            <div id="registrerenbutton">
                                <button formaction = "Pages/Registreer.php">Registreren</button>
                            </div>
                            
                        </form>
                    
                    
                      <div id="errorcodes"><b>

                                <?php
                                
                                $errorcode = "Probeer opnieuw";
                                
                                echo $errorcode;
                                
                                ?>

        </b></div>
                </div>
            </div>
        </div>
    </body>
</html>

