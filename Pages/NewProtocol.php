<!DOCTYPE HTML>
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="../Css/Main.css">
    <link rel="stylesheet" href="../Css/Responsive.css">

</head>
<body>
    <?php 
    /* Include */
    include_once '../Include/Header.php';
    include_once '../Include/Dbh.inc.php';
    ?>
    <main id="Protocol">
        <div class="PageTitle">
            <h1><?=$NieuwProtocol?></h1>
            <hr>
        </div>
        <div class="whitebg">
            <div class="content">
                <form class="Pform" method="POST" action="NewProtocol.php" enctype="multipart/form-data">
                    
                    <label for="**PTitle"><?=$Protocol." ".$Titel?>: *</label>
                    <input type="text" name="PTitle" placeholder="Titel" required></input><br>
                    
                    <label for="Vakken"><?=$Vak?>: *</label>
                    <div name="Vakken">
                        <input type="radio" id="BML" name="PVak" value="BML" checked>
                        <label for="BML"><?=$BML?></label><br>
                        <input type="radio" id="Chemie" name="PVak" value="Chemie">
                        <label for="Chemie"><?=$Chemie?></label>
                    </div>

                    <label for="Jaren"><?=$Jaar?>: *</label>
                    <div name="Jaren">
                        <input type="radio" id="Jaar 1" name="PJaar" value="1" checked>
                        <label for="BML"><?=$Jaar1?></label><br>
                        <input type="radio" id="Jaar 2" name="PJaar" value="2">
                        <label for="Chemie"><?=$Jaar2?></label><br>
                        <input type="radio" id="Jaar 3" name="PJaar" value="3">
                        <label for="Chemie"><?=$Jaar3?></label>
                    </div>

                    <label for="PUpload"><?=$Protocol?>: *</label>
                    <input type="file" name="PUpload" id="PUpload"><br>
                    

                    <input class="bluebtn" id="PSubmit" type="submit" value="Upload protocol" name="PSubmit">
                </form>
                <?php
                
                if(isset($_POST["PSubmit"])){
                    if(!empty($_POST["PTitle"])){
                        if(!empty($_POST["PVak"])){
                            if(!empty($_POST["PJaar"])){
                                if(!empty($_FILES)){
                                
                                    $studentID =  filter_var($_SESSION["StudentID"], FILTER_SANITIZE_SPECIAL_CHARS);
                                    $uploadDatum =  date("Y-m-d");
                                    $titel =  filter_input(INPUT_POST,'PTitle', FILTER_SANITIZE_SPECIAL_CHARS);
                                    $vakken =  filter_input(INPUT_POST,'PVak', FILTER_SANITIZE_SPECIAL_CHARS);
                                    $jaar =  filter_input(INPUT_POST,'PJaar', FILTER_SANITIZE_SPECIAL_CHARS); 

                                    //Protocol pdf
                                    

                                    $fileName = basename($_FILES["PUpload"]["name"]); 
                                    $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                                    
                                    if($fileType == 'pdf'){ 

                                        $targetDir = "../upload/protocol/";
                                        $date = date("Y-m-d_h-i-s");
                                        $targetFile= $targetDir.$_SESSION["Name"].$date.'.'.$fileType;
                                        $uploadOk = 1;
                                        //check if file exists
                                        if (file_exists($targetFile)) {
                                            echo "Sorry, file already exists.<br>";
                                            $uploadOk = 0;
                                        }
                                        
                                        // Check file size
                                        if ($_FILES["PUpload"]["size"] > 5000000000) {
                                            echo "Sorry, your file is too large.<br>";
                                            $uploadOk = 0;
                                        }        

                                        // Check if $uploadOk is set to 0 by an error
                                        if ($uploadOk == 0) {
                                            echo "Sorry, your file was not uploaded.<br>";

                                        // if everything is ok, try to upload file
                                        } else {
                                            if (move_uploaded_file($_FILES["PUpload"]["tmp_name"], $targetFile)) {
                                                queryAanmaken('INSERT INTO protocol(studentID,uploadDatum,titel,protocol,vakken,jaar)
                                                    VALUES ("'.$studentID.'","'.$uploadDatum.'","'.$titel.'","'.$targetFile.'","'.$vakken.'","'.$jaar.'")');
                                                querySluiten();

                                                echo "The file ". htmlspecialchars( basename( $_FILES["PUpload"]["name"])). " has been uploaded.<br>";
												//echo "<a class="bluebtn" id="Pbutton" href='Protocollen.php'>Protocollen</a>";
                                            } else {
                                            echo "Sorry, there was an error uploading your file.<br>";
											echo $targetDir;
											echo $targetFile;
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
                                echo $ErJaar;
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