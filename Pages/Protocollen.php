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
        <div class="whitebg">
            <div class="content">
                <a id="Pbutton" href="NewProtocol.php">Nieuw Protocol</a>
                <?php
                    queryAanmaken(
                        'SELECT studentID 
                        FROM protocol
                        ORDER BY uploadDatum DESC
                        limit 5
                        ');
                    mysqli_stmt_bind_result($stmt, $Presults);
                    mysqli_stmt_store_result($stmt);
                    $i=0;
                    while(mysqli_stmt_num_rows($stmt) > $i)
                    {
                        mysqli_stmt_fetch($stmt);
                        echo $Presults;
                        $i++;
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


                
