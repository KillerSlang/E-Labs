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
            <h1>Labjournalen Overzicht</h1>
            <hr>
        </div>
        <div class="whitebg">
            <div class="content">
                <button class="bluebtn" id="Pbutton"><a href='labjournaalformulier.php'>Nieuw Labjournaal</a></button>
                <button class="bluebtn" id="Pbutton"><a href='labjournalen.php?jaar=3'>Jaar 3</a></button>
                <button class="bluebtn" id="Pbutton"><a href='labjournalen.php?jaar=2'>Jaar 2</a></button>
                <button class="bluebtn" id="Pbutton"><a href='labjournalen.php?jaar=1'>Jaar 1</a></button>
                <button class="bluebtn" id="Pbutton"><a href='labjournalen.php'>Alle jaren</a></button>
                <br>
                <?php
                    $sql = '
                    SELECT studentNaam,labjournaalTitel,experimentDatum,vak,jaar,labjournaalID
                    FROM labjournaal as l
                    JOIN student AS s ON l.studentID = s.studentID
                    ';
                    if(!empty($_GET['jaar']))
                    {
                        $jaar = $_GET['jaar'];
                        $sql .= 'WHERE jaar = '.$jaar.' ';                        
                    }
                    $sql .= 'ORDER BY experimentDatum DESC';
                    queryAanmaken($sql);
                    mysqli_stmt_bind_result($stmt, $studentNaam, $labjournaalTitel,$experimentDatum, $vak, $jaar,$labjournaalID);
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) != 0)
                    {
                        echo "<table class='LTable'><th>Titel</th><th>Auteur</th><th>Experiment datum</th><th>Vakken</th><th>Jaar</th><th>Bewerken</th>";
                        while(mysqli_stmt_fetch($stmt))
                        {
                            echo '<tr>
                            <td><a class="labjournaalTitel"href="labjournaalBekijken.php?ID='.$labjournaalID .'"</a>'.$labjournaalTitel.'</td>
                            <td>'.$studentNaam.'</td>
                            <td>'.$experimentDatum.'</td>
                            <td>'.$vak.'</td>
                            <td>'.$jaar.'</td>
                            <td><a class="labjournaalLink"href="labjournaal.php?ID='.$labjournaalID .'"</a>Bewerken</td>
                            </tr>' ;
                        }
                        echo"</table>";
                    }
                    querySluiten();
                   
                ?>
            </div>
        </div>
    </main>
    <?php 
    /* Footer */
    include_once '../Include/Footer.php';
    ?>    
</body>