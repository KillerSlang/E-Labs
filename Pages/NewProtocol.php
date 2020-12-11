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
                    <label for="vakken">Vak: *</label>
                    <div name="vakken">
                        <input type="radio" id="BML" name="PVak" value="BML" checked>
                        <label for="BML">BML</label><br>
                        <input type="radio" id="Chemie" name="PVak" value="Chemie">
                        <label for="Chemie">Chemie</label>
                    </div>
                    

                    <input class="bluebtn" id="PSubmit" type="submit" value="Upload protocol" name="PSubmit">
                </form>
                <?php
                if(isset($_POST["PSubmit"])){
                    if(!empty($_POST["PTitle"])){
                        if(!empty($_POST["PUpload"])){
                            if(!empty($_POST["PVak"])){
                            
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