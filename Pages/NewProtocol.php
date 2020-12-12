<!DOCTYPE HTML>
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="../Css/Main.css">
    <link rel="stylesheet" href="../Css/Responsive.css">

</head>
<body>
    <?php 
    /* Header */
    include_once '../Include/Header.php';
    include_once '../Include/Dbh.inc.php';
    ?>
    <main id="Protocol">
        <div class="PageTitle">
            <h1>Nieuw Protocol</h1>
            <hr>
        </div>
        <div class="whitebg">
            <div class="content">
                <form class="Pform"method="POST" action="NewProtocol.php">
                    <label for="PTitle">Protocol Titel: *</label>
                    <input type="text" name="PTitle" placeholder="Titel" required></input><br>
                    <label for="PUpload">Protocol: *</label>
                    <input type="file" name="PUpload"><br>

                    <label for="Vakken">Vak: *</label>
                    <div name="Vakken">
                        <input type="radio" id="BML" name="PVak" value="BML" checked>
                        <label for="BML">BML</label><br>
                        <input type="radio" id="Chemie" name="PVak" value="Chemie">
                        <label for="Chemie">Chemie</label>
                    </div>
                    <label for="Jaren">Jaar: *</label>
                    <div name="Jaren">
                        <input type="radio" id="Jaar 1" name="PJaar" value="1" checked>
                        <label for="BML">Jaar 1</label><br>
                        <input type="radio" id="Jaar 2" name="PJaar" value="2">
                        <label for="Chemie">Jaar 2</label><br>
                        <input type="radio" id="Jaar 3" name="PJaar" value="3">
                        <label for="Chemie">Jaar 3</label>
                    </div>
                    

                    <input class="bluebtn" id="PSubmit" type="submit" value="Upload protocol" name="PSubmit">
                </form>
                <?php
                //print_r($_POST);
                if(isset($_POST["PSubmit"])){
                    if(!empty($_POST["PTitle"])){
                        if(!empty($_POST["PJaar"])){
                            if(!empty($_POST["PVak"])){
                                
                                $studentID =  filter_var($_SESSION["studentID"], FILTER_SANITIZE_SPECIAL_CHARS);
                                $uploadDatum =  date("Y-m-d");
                                $titel =  filter_input(INPUT_POST,'PTitle', FILTER_SANITIZE_SPECIAL_CHARS);
                                $protocol =  filter_input(INPUT_POST,'PUpload', FILTER_SANITIZE_SPECIAL_CHARS);
                                $vakken =  filter_input(INPUT_POST,'PVak', FILTER_SANITIZE_SPECIAL_CHARS);
                                $jaar =  filter_input(INPUT_POST,'PJaar', FILTER_SANITIZE_SPECIAL_CHARS); 
                                echo($studentID.' '.$uploadDatum.' '.$titel.' '.$protocol.' '.$vakken.' '.$jaar);
                                
                                queryAanmaken('INSERT INTO protocol(studentID,uploadDatum,titel,protocol,vakken,jaar)
                                VALUES ("'.$studentID.'","'.$uploadDatum.'","'.$titel.'","'.$protocol.'","'.$vakken.'","'.$jaar.'")');
                                querySluiten();
                                
                            }else{
                                echo "Geen Vak geselecteerd";
                            }
                        }else{
                            echo "Geen Bestand geselecteerd";
                        }
                    }else{
                        echo "Geen Titel ingevoerd";
                    }
                }
                ?>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            </div>
        </div>
    </main>
    <?php 
    /* Footer */
    include_once '../Include/Footer.php';
    ?>    
</body>