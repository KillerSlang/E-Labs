<!DOCTYPE HTML>
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cda83c7af3.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Css/Main.css">
    <link rel="stylesheet" href="../Css/Responsive.css">
</head>
<body>
    <?php 
        /* Header */
        include_once '../Include/Header.php';
        include_once '../Include/Dbh.inc.php';

        function get_options($select)
        {
            $vakken = array('BML','Chemie');
            $options = '';
            foreach($vakken as $input)
            {
                if($select == $input)
                {
                    $options .= '<option value="'.$input.'" selected>'.$input.'</option>';
                }
                else
                {
                    $options .= '<option value="'.$input.'" >'.$input.'</option>';
                }
            }
            return $options;
        }
        if(isset($_POST["vak"]))
        {
            $selected = $_POST["vak"];
            $_SESSION["select"] = $selected;
        }
        else
        {
            if(isset($_SESSION["select"]))
            {
                $selected = $_SESSION["select"];
            }else {$selected = "BML";}
        }
?>
    <main id="Protocol">
    <div class="PageTitle">
            <h1>Te bekijken labjournalen</h1>
            <hr>
        </div>
        <div class="whitebg">
            <div class="content">
                <a class="bluebtn" id="Pbutton" href='labjournalenBekijken.php?jaar=3'>Jaar 3</a>
                <a class="bluebtn" id="Pbutton" href='labjournalenBekijken.php?jaar=2'>Jaar 2</a>
                <a class="bluebtn" id="Pbutton" href='labjournalenBekijken.php?jaar=1'>Jaar 1</a>
                <a class="bluebtn" id="Pbutton" href='labjournalenBekijken.php?jaar=0'>Alle jaren</a>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="selectform" method="post">
                    <select class="bluebtn" id="Pbutton" name="vak" onchange="this.form.submit();">                        
                        <?PHP
                            echo get_options($selected);
                        ?>
                    </select>
                </form>
                <a class="bluebtn" id="PbuttonLeft" href='labjournalen.php'>Bewerk labjournalen</a>
                <br>
                <?php
                    queryAanmaken('SELECT studentNummer
                                    FROM student
                                    WHERE studentID = '.$_SESSION["StudentID"]);
                    mysqli_stmt_bind_result($stmt,$studentNummer);
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) != 0)
                    {
                        while (mysqli_stmt_fetch($stmt)) 
                        {
                            $studentNummer = $studentNummer;
                        }
                    }
                    querysluiten(); 
                    queryaanmaken('SELECT uitvoerders,labjournaalID
                                   FROM labjournaal');
                    mysqli_stmt_bind_result($stmt,$uitvoerders,$labjournaalID);
                    mysqli_stmt_store_result($stmt);  
                    if(mysqli_stmt_num_rows($stmt) != 0)
                    {            
                        $labjournalenArray = array();              
                        while (mysqli_stmt_fetch($stmt)) 
                        {
                            $uitvoerdersArray = unserialize(base64_decode($uitvoerders));
                            foreach($uitvoerdersArray as $input)
                            {
                                if($input == $studentNummer)
                                {
                                    array_push($labjournalenArray,$labjournaalID);
                                }
                            }
                        }
                        $labjournalen = "";
                        foreach ($labjournalenArray as $labjournaal)
                        {
                            if(empty($labjournalen))
                            {
                                $labjournalen .= " WHERE (labjournaalID =".$labjournaal;
                            }
                            else
                            {
                                $labjournalen .= " OR labjournaalID =".$labjournaal;
                            }
                        } $labjournalen .= ")"; 
                        $queryError = false;
                        
                    }else {$queryError = true;}
                    querysluiten();
                    if(!$queryError)
                    {                   
                        $sql = '
                        SELECT studentNaam,labjournaalTitel,experimentDatum,vak,l.jaar,labjournaalID
                        FROM labjournaal as l
                        JOIN student AS s ON l.studentID = s.studentID';
                        if(!empty($_GET['jaar']))
                        {
                            $jaarlaag = $_GET['jaar'];
                            $sql .= ' WHERE l.jaar = '.$jaarlaag;
                            if($_SESSION['SorD'] == "Student")
                            {
                                $sql .= ' AND s.studentID = '.$_SESSION["StudentID"];  
                            }       
                        }
                        else
                        {
                            $jaarlaag = 0;
                            if($_SESSION['SorD'] == "Student")
                            {
                                    $sql .= ' WHERE s.studentID = '.$_SESSION["StudentID"].' ';      // student of docent
                            }       
                        }
                        $sql .= ' AND l.vak = "'.$selected.'" ';                    
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
                            echo "<table class='LTable'><th>Titel</th><th>Auteur</th><th>Experiment datum</th><th>Vakken</th><th>Jaar</th><th>download</th><th>Bekijken</th>";
                            while(mysqli_stmt_fetch($stmt))
                            {
                                echo '<tr>
                                <td>'.$labjournaalTitel.'</td>
                                <td>'.$studentNaam.'</td>
                                <td>'.$experimentDatum.'</td>
                                <td>'.$vak.'</td>
                                <td>'.$jaar.'</td>
                                <td><a class="labjournaalLink"href="../Include/downloadLabjournaal.inc.php?ID='.$labjournaalID .'"</a><i class="fas fa-download"></i></td>
                                <td><a class="labjournaalLink"href="labjournaalBekijken.php?ID='.$labjournaalID .'"</a>Bekijken</td>
                                </tr>' ;
                            }
                            echo"</table>";
                            
                        }
                        querySluiten();
                        if(!isset($_GET['page']) || $_GET['page'] == 0){
                            $url = 'labjournalenBekijken.php?jaar='.$jaarlaag.'&page=';
                            $next = $url.'1';
                            echo'<a class="bluebtn" id="Pbutton" href='.$next.'>Alle Labjournalen</a>';
                        } else {
                            $url = 'labjournalenBekijken.php?jaar='.$jaarlaag.'&page=';
                            $next = $_GET['page']+1;
                            $back = $_GET['page']-1;
    
                            echo'<a class="bluebtn" id="Pbutton" href="'.$url.$next.'">Volgende pagina</a>';
                            echo'<a class="bluebtn" id="Pbutton" href="'.$url.$back.'">Vorige pagina</a>';
                        }
                    }else 
                    {
                        echo '<div class="bericht">
                                <b>Er zijn geen labjournalen om te bekijken.</b><hr>
                              </div>';
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