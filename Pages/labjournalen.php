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
    function downloadFile($queryResult, $fileName){

		ob_end_clean();
            
		//Bestandsnaam genereren aan de hand van waarden uit database
			
		//Headers genereren voor export pdf + pdf downloaden door echo
		header('Content-type: application/x-download');
		header('Content-Disposition: attachment; filename="'.$fileName.'"');
		header('Content-Transfer-Encoding: binary');
		header('Content-Length: '.strlen($queryResult));
		
		return $queryResult;

	}
    ?>
    <main id="Protocol">
    <div class="PageTitle">
            <h1>Labjournaal</h1>
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
                        echo "<table class='LTable'><th>Titel</th><th>Auteur</th><th>Experiment datum</th><th>Vakken</th><th>Jaar</th><th></th>";
                        while(mysqli_stmt_fetch($stmt))
                        {
                            echo '<tr>
                            <td>'.$labjournaalTitel.'</td>
                            <td>'.$studentNaam.'</td>
                            <td>'.$experimentDatum.'</td>
                            <td>'.$vak.'</td>
                            <td>'.$jaar.'</td>
                            <td><a class="labjournaalLink"href="labjournaal.php?ID='.$labjournaalID .'"</a>Aanpassen</td>
                            </tr>' ;
                        }
                        echo"</table>";
                    }
                    querySluiten();
                    /*print_r($_POST);
                    if(isset($_POST['protocolSubmit'])){
                        $fileName = $titel.' '.$vakken.'-'.$jaar.' - Protocol.pdf';
                        ob_end_clean();
        
                        //Bestandsnaam genereren aan de hand van waarden uit database
                            
                        //Headers genereren voor export pdf + pdf downloaden door echo
                        header('Content-type: application/x-download');
                        header('Content-Disposition: attachment; filename="'.$fileName.'"');
                        header('Content-Transfer-Encoding: binary');
                        header('Content-Length: '.strlen($protocol));
                        echo downloadFile($protocol, $fileName);
                    
                    }
                    $sql = 'SELECT studentNaam, experimentDatum, labjournaalTitel, vak, jaar
                    FROM protocol AS p
                    JOIN student AS s ON p.studentID = s.studentID ';
                    if(!empty($_GET['jaar'])){
                        if($_GET['jaar'] == 0 )
                        {
                            
                        } else {
                            $jaar = $_GET['jaar'];
                            $sql = $sql.'WHERE jaar = '.$jaar.' ';
                        }
                    }

                    $sql = $sql.'ORDER BY uploadDatum DESC ';
                    
                    if(!isset($_GET['page']) || $_GET['page'] == 0){
                        $sql = $sql.'LIMIT 5'; 
                    } else {
                        $counter = $_GET['page'];
                        $limit = 20;
                        $offset = $limit*($counter-1);
                        $sql = $sql.'LIMIT '.$limit.' OFFSET '.$offset.'';
                    }
                    queryAanmaken($sql);
                    mysqli_stmt_bind_result($stmt, $studentNaam, $uploadDatum, $titel, $protocol, $vakken, $jaar);
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) != 0)
                    {
                        echo "<table class='PTable'><th>Titel</th><th>Auteur</th><th>UploadDatum</th><th>Vakken</th><th>Jaar</th><th>Protocol</th>";
                        while(mysqli_stmt_fetch($stmt))
                        {
                            echo "<tr>
                            <td>".$titel."</td>
                            <td>".$studentNaam."</td>
                            <td>".$uploadDatum."</td>
                            <td>".$vakken."</td>
                            <td>".$jaar."</td>
                            <td><form method='post'><button  class='bluebtn' type='submit' value'download' name='protocolSubmit'>Download</button></form></td>
                            </tr>";
                        }
                        echo"</table>";
                    }
                    querySluiten();
                    if(!isset($_GET['page']) || $_GET['page'] == 0){
                        $url = 'labjournalen.php?jaar='.$_GET['jaar'].'&page=';
                        $next = $url.'1';
                        echo'<button class="bluebtn" id="Pbutton"><a href='.$next.'>Alle Protocollen</a></button>';
                    } else {
                        $url = 'labjournalen.php?jaar='.$_GET['jaar'].'&page=';
                        $next = $_GET['page']+1;
                        $back = $_GET['page']-1;
                        echo'<button class="bluebtn" id="Pbutton"><a href='.$url.$next.'>Volgende pagina</a></button>';
                        echo'<button class="bluebtn" id="Pbutton"><a href='.$url.$back.'>Vorige pagina</a></button>';
                    }
                    */
                    
                ?>
            </div>
        </div>
    </main>
    <?php 
    /* Footer */
    include_once '../Include/Footer.php';
    ?>    
</body>