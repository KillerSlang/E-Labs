<?php
            // Starting session
            session_start();
            if(empty($_COOKIE["taal"])){
                setcookie("taal", "nederlands");
            }
            if($_COOKIE["taal"] == "english"){
                include_once "../Include/Engels.php";
            } else {
                include_once "../Include/Nederlands.php";
            }
            
			if(isset($_POST["Submit"])){

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
								
								header("Location: Homepage.php");

								
                            }else{
                                echo'<meta http-equiv="refresh" content="0; URL=index.php?error=1">';
                                
                            }
                        mysqli_close($connection);
                }
            }elseif(isset($_POST["Submit"]) and $SorD == "Docent")
            {

                $link = mysqli_connect("localhost","elabs","Bla_1711")
                OR DIE("Could not connect to the database!");
                if($link)
                {
            
                        $connection = mysqli_connect("localhost","root","");
                        mysqli_select_db($connection, 'elabs');
            
                        $SQL = "SELECT docentID, docentNaam FROM docent WHERE wachtwoord = '$wachtwoord' and docentEmail = '$email'";
                        $login = mysqli_query($connection, $SQL);
            
        
                            if(mysqli_num_rows($login) == 1){
                                
                                $row = mysqli_fetch_array($login);
                                
                                $docentID = $row['studentID'];
                                $docentNaam = $row['studentNaam'];
								
								//header("Location: http://www.example.com/");
								
								session_start();
                                $_SESSION["docentID"] = $docentID;
                                $_SESSION["SorD"] = "Docent";
                                $_SESSION["Name"] = $docentNaam;

                                echo 'succes';
                                echo'<meta http-equiv="refresh" content="0; URL=Homepage.php">';
								die;
                            }else{
                                
                                echo'<meta http-equiv="refresh" content="0; URL=index.php?error=1">';
                                
                                

                            }
                        mysqli_close($connection);
                }
            }   
            
        }
        ?>