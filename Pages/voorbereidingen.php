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
    include_once 'Dbh.inc.php';
    
    ?>
    <main id="Protocol">
    <div class="PageTitle">
            <h1>Voorbereidingen Overzicht</h1>
            <hr>
        </div>
        <div class="whitebg">
            <div class="content">
                <a class="bluebtn" id="Pbutton" href='voorbereidingenaanmaak.php'>Nieuwe voorbereiding</a>
                <a class="bluebtn" id="Pbutton" href='voorbereidingen.php?jaar=3'>Jaar 3</a>
                <a class="bluebtn" id="Pbutton" href='voorbereidingen.php?jaar=2'>Jaar 2</a>
                <a class="bluebtn" id="Pbutton" href='voorbereidingen.php?jaar=1'>Jaar 1</a>
                <a class="bluebtn" id="Pbutton" href='voorbereidingen.php?jaar=0'>Alle jaren</a>
                <br>
                <?php
                    $sql = '
                    SELECT uitvoerders, voorbereidingTitel, voorbereidingDatum, vakken, Jaar, voorbereidingID
                    FROM voorbereiding as v
                    JOIN student AS s ON v.studentID = s.studentID
                    ';
                    if(!empty($_GET['jaar']))
                    {
                        $jaarlaag = $_GET['jaar'];
                        $sql .= 'WHERE Jaar = '.$jaarlaag.' AND s.studentID = '.$_SESSION["StudentID"].' ';                        
                    }
                    else
                    {
                        $jaarlaag = 0;
                        $sql .= 'WHERE s.studentID = '.$_SESSION["StudentID"].' ';
                    }
                   $sql .= 'ORDER BY voorbereidingDatum DESC ';
                    if(!isset($_GET['page']) || $_GET['page'] == 0){
                        $sql = $sql.'LIMIT 5'; 
                    } else {
                        $counter = $_GET['page'];
                        $limit = 20;
                        $offset = $limit*($counter-1);
                        $sql = $sql.'LIMIT '.$limit.' OFFSET '.$offset.'';
                    } 


                    queryAanmaken($sql);
                    mysqli_stmt_bind_result($stmt, $studentNaam, $voorbereidingTitel, $voorbereidingDatum, $vak, $Jaar, $voorbereidingID);
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) != 0)
                    {
                        echo "<table class='LTable'><th>Titel</th><th>Auteur</th><th>Experiment datum</th><th>Vakken</th><th>Jaar</th><th>Bewerken</th>";
                        while(mysqli_stmt_fetch($stmt))
                        {
                            echo '<tr>
                            <td><a class="labjournaalTitel"href="voorbereidingBekijken.php?ID='.$voorbereidingID .'"</a>'.$voorbereidingTitel.'</td>
                            <td>'.$studentNaam.'</td>
                            <td>'.$voorbereidingDatum.'</td>
                            <td>'.$vak.'</td>
                            <td>'.$Jaar.'</td>
                            <td><a class="labjournaalLink"href="voorbereidingBekijken.php?ID='.$voorbereidingID .'"</a>Bewerken</td>
                            </tr>' ;
                        }
                        echo"</table>";
                        
                    }
                    querySluiten();
                    if(!isset($_GET['page']) || $_GET['page'] == 0){
                        $url = 'voorbereidingen.php?jaar='.$jaarlaag.'&page=';
                        $next = $url.'1';
                        echo'<a class="bluebtn" id="Pbutton" href='.$next.'>Alle Voorbereidingen</a>';
                    } else {
                        $url = 'voorbereidingen.php?jaar='.$jaarlaag.'&page=';
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