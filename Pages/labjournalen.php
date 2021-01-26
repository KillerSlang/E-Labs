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
                <a class="bluebtn" id="Pbutton" href='labjournaalformulier.php'>Nieuw Labjournaal</a>
                <a class="bluebtn" id="Pbutton" href='labjournalen.php?jaar=3'>Jaar 3</a>
                <a class="bluebtn" id="Pbutton" href='labjournalen.php?jaar=2'>Jaar 2</a>
                <a class="bluebtn" id="Pbutton" href='labjournalen.php?jaar=1'>Jaar 1</a>
                <a class="bluebtn" id="Pbutton" href='labjournalen.php?jaar=0'>Alle jaren</a>
                <br>
                <?php
					$sql = '
                    SELECT studentNaam,labjournaalTitel,experimentDatum,vak,jaar,labjournaalID
                    FROM labjournaal as l
                    JOIN student AS s ON l.studentID = s.studentID
                    ';
                    if(!empty($_GET['jaar']))
                    {
                        $jaarlaag = $_GET['jaar'];
                        $sql .= 'WHERE jaar = '.$jaarlaag.' AND s.studentID = '.$_SESSION["StudentID"].' ';                        
                    }
                    else
                    {
                        $jaarlaag = 0;
                        $sql .= 'WHERE s.studentID = '.$_SESSION["StudentID"].' ';
                    }
                    $sql .= 'ORDER BY experimentDatum DESC ';
                    if(!isset($_GET['page']) || $_GET['page'] == 0){
                        $sql = $sql.'LIMIT 5'; 
                    } else {
                        $counter = $_GET['page'];
                        $limit = 20;
                        $offset = $limit*($counter-1);
                        $sql = $sql.'LIMIT '.$limit.' OFFSET '.$offset.'';
                    }
                    queryAanmaken($sql);
                    mysqli_stmt_bind_result($stmt, $studentNaam, $labjournaalTitel,$experimentDatum, $vak, $jaar,$labjournaalID);
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) != 0)
                    {
                        echo "<table class='PTable'><th>Titel</th><th>Auteur</th><th>Experiment datum</th><th>Vakken</th><th>Jaar</th><th>Bewerken</th>";
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
                    if(!isset($_GET['page']) || $_GET['page'] == 0){
                        $url = 'labjournalen.php?jaar='.$jaarlaag.'&page=';
                        $next = $url.'1';
                        echo'<a class="bluebtn" id="Pbutton" href='.$next.'>Alle Labjournalen</a>';
                    } else {
                        $url = 'labjournalen.php?jaar='.$jaarlaag.'&page=';
                        $next = $_GET['page']+1;
                        $back = $_GET['page']-1;

                        echo'<a class="bluebtn" id="Pbutton" href="'.$url.$next.'">Volgende pagina</a>';
                        echo'<a class="bluebtn" id="Pbutton" href="'.$url.$back.'">Vorige pagina</a>';
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