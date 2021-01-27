<!DOCTYPE HTML>
<html lang="en">
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="../Css/Main.css">
    <link rel="stylesheet" href="../Css/Responsive.css">
    <link rel="shortcut icon" type="image/png" href="../Images/favicon.png"/>
    <?php
    //afhankelijk van de taal maak een nederlandse titel of een engels
    if($_COOKIE['taal'] == 'english') {
        echo "<title>New protocol</title>";
    }
    else{
        echo "<title>Nieuw Protocol</title>";
    }
    ?>
</head>
<body>
    <?php 
    /* Include header en database handler */
    include_once '../Include/Header.php';
    include_once '../Include/Dbh.inc.php';
    ?>
    <main id="Protocol">
        <div class="PageTitle">
            <h1><?=$ProtocolNieuw?></h1>
            <hr>
        </div>
        <div class="whitebg">
            <div class="content">
            <!-- invulbare Form voor user om protocol in te doen -->
                <form class="Pform" method="POST" action="NewProtocol.php" enctype="multipart/form-data">
                    
                    <label for="PTitle"><?=$Protocol." ".$Titel?>:</label>
                    <input type="text" name="PTitle" id="PTitle" placeholder="<?=$Titel?>" required>
                    
                    <label><?=$Vak?>:</label>
                    <div id="Vakken">
                        <input type="radio" id="BML" name="PVak" value="BML" checked>
                        <label for="BML"><?=$BML?></label><br>
                        <input type="radio" id="Chemie" name="PVak" value="Chemie">
                        <label for="Chemie"><?=$Chemie?></label>
                    </div>
                    
                    <label for="PUpload"><?=$Protocol?>:</label>
                    <input type="file" id="PUpload" name="PUpload" accept=".pdf">

                    <input class="bluebtn" id="PSubmit" type="submit" value="Upload protocol" name="PSubmit">
                </form>

                <?php
                /* Aanmaken van Protocol */
                if(isset($_POST["PSubmit"])){
                    if(!empty($_POST["PTitle"])){
                        if(!empty($_POST["PVak"])){
                            if(!empty($_SESSION["jaar"])){
                                if(!(empty($_FILES) || $_FILES["PUpload"]["error"] == 4)){
                                    //filter input
                                    $studentID =  filter_var($_SESSION["StudentID"], FILTER_SANITIZE_SPECIAL_CHARS);
                                    $uploadDatum =  date("Y-m-d");
                                    $titel =  filter_input(INPUT_POST,'PTitle', FILTER_SANITIZE_SPECIAL_CHARS);
                                    $vakken =  filter_input(INPUT_POST,'PVak', FILTER_SANITIZE_SPECIAL_CHARS);

                                    //Protocol pdf
                                    
                                    $fileName = basename($_FILES["PUpload"]["name"]); 
                                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                                    
                                    if($fileType == 'pdf'){ 

                                        $targetDir = "../upload/protocol/Protocol ";
                                        $date = date("Y-m-d_G-i-s");
                                        $targetFile = $targetDir.$_SESSION["Name"]." ".$date.'.'.$fileType;
                                        $uploadOk = 1;
                                        //check if file exists
                                        if (file_exists($targetFile)) {
                                            echo $ErFileExist;
                                            $uploadOk = 0;
                                        }
                                        
                                        // Check file size
                                        if ($_FILES["PUpload"]["size"] > 5000000000) {
                                            echo $ErFileSize;
                                            $uploadOk = 0;
                                        }        

                                        // Check if $uploadOk is set to 0 by an error
                                        if ($uploadOk == 0) {
                                            echo $ErFileCant;

                                        // if everything is ok, try to upload file
                                        } else {
                                            //Kijk of het verplaatsten van het bestand lukt
                                            if (move_uploaded_file($_FILES["PUpload"]["tmp_name"], $targetFile)) {
                                                //als dat is gelukt upload dan de nieuwe locatie naar de database
                                                queryAanmaken('INSERT INTO protocol(studentID,uploadDatum,titel,protocol,vakken,jaar)
                                                    VALUES ("'.$studentID.'","'.$uploadDatum.'","'.$titel.'","'.$targetFile.'","'.$vakken.'","'.$_SESSION["jaar"].'")');
                                                querySluiten();
                                                
                                                echo $File.htmlspecialchars( basename( $_FILES["PUpload"]["name"])).$Uploaded;
                                            } else {
                                                //Hier onder staan alle error codes
                                            echo $ErFileNot;
                                            }
                                        }                                        
                                    }
                                    else {
                                        echo $ErType;
                                    }
                                }else{
                                    echo $ErBestand;
                                }
                            }else{
                                echo "<a href='Instellingen.php'>".$ErJaar."</a>";
                            }
                        }else{
                            echo $ErVak;
                        }
                    }else{
                        echo $ErTitel;
                    }
                }
                ?>
            </div>
        </div>
    </main>
    <?php 
    /* Footer */
    include_once '../Include/Footer.php';
    ?>    
</body>