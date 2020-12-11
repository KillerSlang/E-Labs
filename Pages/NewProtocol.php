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
                    <label>Protocol Titel: *</label>
                    <input type="text" name="PTitle" placeholder="Titel" required></input><br>
                    <label>Protocol: *</label>
                    <input type="file" name="PUpload"><br>
                    
                    <label for="BML">BML</label>
                    <input type="radio" id="BML" name="PVak" value="BML"><br>
                    <label for="Chemie">Chemie</label>
                    <input type="radio" id="Chemie" name="PVak" value="Chemie">
                    

                    <input class="bluebtn" id="PSubmit" type="submit" value="Upload protocol" name="PSubmit">
                </form>
                <?php
                if(isset($_POST["PSubmit"])){
                    if(!empty($_POST["PTitle"])){
                        if(!empty($_POST["PUpload"])){
                            
                        }else{
                            echo "Geen bestand geselecteerd";
                        }
                    }else{
                        echo "Geen titel ingevoerd";
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