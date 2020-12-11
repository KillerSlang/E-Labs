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
        <div class="whitebg">
            <div class="content">
                <a id="Pbutton" href="NewProtocol.php">Nieuw Protocol</a>
                <?php
                    foreach($Newprotocol as $Protocol => $Pvalue) { ?>
                        <dt><label for="<?php echo $Protocol ?>">$Protocol</label></dt>

                   <?php } ?>
            </div>
        </div>
    </main>
    <?php 
    /* Footer */
    include_once '../Include/Footer.php';
    ?>    
</body>