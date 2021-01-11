<!DOCTYPE HTML>
<html>
    <head>

    <?php
            if(!empty($_GET && !empty($_GET["taal"]))){
                if($_GET["taal"] == "E"){
                    setcookie("taal", "english");
                }
            }
            if($_COOKIE["taal"] == "Engels"){
                include_once "../Include/Engels.php";
            } else {
                include_once "../Include/Nederlands.php";
            }
        ?> 

        <title><?= $wwvergetentitel ?></title>
        <link href="../Css/inlog.css" rel="stylesheet" type="text/css">
    </head>
    <body> 
        <div id="Container">
            <div id="inlogbox">
                <div id="logobalk">
                    
                    <div id="logobalklogo">
                        <img src="../Images/Logo.png" alt = "Logo wit">
                    </div>
                    <div id="logobalktext">
                        <h1><b><?= $wwwijzigen ?></b></h1>
                    </div>
                </div> 
                <div id="inlogruimte">

                    

                    <form action = "<?php echo $_SERVER['PHP_SELF']; ?>" method = "POST">
        
                        <div id="Invoerveld1"><p><label for="Studentnummer"><b><?= $StudentNummer ?></b></label><br> 
                        <input type = "Number" name = "Studentnummer" placeholder="<?= $voerstudentnummer ?>"></p></div>
                        
                        <div id="Invoerveld2"><p><label for="Email"><b><?= $Email ?></b></label><br> 
                        <input type = "email" name = "Email" placeholder="<?= $voeremail ?>"></p></div>
                        
                        <div id="Invoerveld3"><p><label for="Beveilingsvragen"><b><?= $Beveiligingsvragen ?></b></label></p>
                        <p><label for="Beveiligingsvraag1"><?= $Vraag1 ?></label><br>
                        <input type = "text" name = "Vraag1" placeholder="<?= $antwoordvraag1 ?>"></p></div>

                        <div id="Invoerveld4"><p><label for="Beveiligingsvraag2"><?= $Vraag2 ?></label><br>
                        <input type = "text" name = "Vraag2" placeholder="<?= $antwoordvraag2 ?>"></p></div>

                        <div id="Invoerveld5"><p><label for="Beveiligingsvraag3"><?= $Vraag3 ?></label><br>
                        <input type = "text" name = "Vraag3" placeholder="<?= $antwoordvraag3 ?>"></p></div>

                        <div id="Invoerveld6"><p><label for="Nieuwwachtwoord"><b><?= $Nieuwww ?></b></label><br>
                        <input type = "password" name = "Nieuwwachtwoord" placeholder="<?= $voernieuwww ?>"></p></div>

                        <div id="Invoerveld7"><p><label for="Herhaalwachtwoord"><b><?= $herhaalww ?></b></label><br>
                        <input type = "password" name = "Herhaalwachtwoord" placeholder="<?= $voerherhaalww ?>"></p></div>

                        <div id="wwwijzigbutton"><input type = "submit" name = "Submit" value = "<?= $Wijzigww ?>"></div>
                    </form> 

                    <div id="errorcodes"><b>




        <?php
if(isset($_POST["Submit"])){

            $email = $_POST["Email"];
            $studentnummer = $_POST["Studentnummer"];
            
            $Pass = $_POST["Nieuwwachtwoord"];
            $Word = $_POST["Herhaalwachtwoord"];

            if($Pass === $Word){

            $PW = $Pass;

            }else{
                
                echo $Erregwwcheck;
                Die;
            }

            $Password = sha1($PW); 
            $vraag1 = sha1($_POST["Vraag1"]);
            $vraag2 = sha1($_POST["Vraag2"]); 
            $vraag3 = sha1($_POST["Vraag3"]);
            
            
            if(isset($_POST["Submit"]))
            {

                $link = mysqli_connect("localhost","root","") 
                OR DIE("Could not connect to the database!");
                if($link)
                {
            
                        $conn = mysqli_connect("localhost","root","");
                        mysqli_select_db($conn, 'elabs');
            
                        $SQL = "SELECT studentID FROM student WHERE studentNummer = '$studentnummer' and studentEmail = '$email' and beveiligingsVraag1 = '$vraag1' and beveiligingsVraag2 = '$vraag2' and beveiligingsVraag3 = '$vraag3'";
                        $check = mysqli_query($conn, $SQL);
            
        
                            if(mysqli_num_rows($check) == 1){
                                
                                $row = mysqli_fetch_array($check);
                                
                                $studentID = $row['studentID'];
                                
                                $SQLUW = "UPDATE student SET wachtwoord='$Password' WHERE studentID = '$studentID'";
                                
                                if(mysqli_query($conn, $SQLUW)) {
                                    echo $Updatedsucces;
                                } else {
                                    echo "Error updating record: " . mysqli_error($conn);
                                }
                                    
                                
                                
                            }else{
                                echo $Probeeropnieuwgegevensonjuist;
                                
                                
                            }
                        mysqli_close($conn);
                }
            } 
            
        }
        ?>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>