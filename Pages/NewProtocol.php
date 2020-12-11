<!DOCTYPE HTML>
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="../Css/Main.css">
    <link rel="stylesheet" href="../Css/Responsive.css">
    <?php
        if(isset($_POST["submit"])){
            if(isset($_POST["PTitle"])){
                if(isset($_POST["PUpload"])){
                
                }else{
                    echo"Upload mist";
                }
            }else{
                echo"Titel mist";
            }
        }
    ?>
</head>
<body>
    <?php 
    /* Header */
    include_once '../Include/Header.php';
    ?>
    <main id="Protocol">
        <div class="whitebg">
            <div class="content">
                <h1>Nieuw Protocol</h1>
                <form class="Pform"method="POST" action="NewProtocol.php">
                    <label>Protocol titel: *</label>
                    <input type="text" name="PTitle" required></input><br>
                    <label>Protocol: *</label>
                    <input type="file" name="PUpload"><br>
                    
                    <input id="PSubmit" type="submit" value="Verzenden" name="PSubmit">
                </form>
            </div>
        </div>
    </main>
    <?php 
    /* Footer */
    include_once '../Include/Footer.php';
    ?>    
</body>