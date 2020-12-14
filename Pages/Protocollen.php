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
            <h1>Protocol</h1>
            <hr>
        </div>
        <div class="whitebg">
            <div class="content">
                <a class="bluebtn" id="Pbutton" href='NewProtocol.php'>Nieuw Protocol</a>
                <a class="bluebtn" id="Pbutton" href='Protocollen.php?jaar=3'>Jaar 3</a>
                <a class="bluebtn" id="Pbutton" href='Protocollen.php?jaar=2'>Jaar 2</a>
                <a class="bluebtn" id="Pbutton" href='Protocollen.php?jaar=1'>Jaar 1</a>
                <a class="bluebtn" id="Pbutton" href='Protocollen.php?jaar=0'>Alle jaren</a>
                
                <br>
                <?php
                    if(isset($_POST['protocolSubmit'])){
                        if(!empty($_POST['protocolID'])) {
                            
                            $protocolID = $_POST['protocolID'];
                            queryAanmaken('SELECT titel, vakken, jaar, protocol
                                            FROM protocol 
                                            WHERE protocolID = '.$protocolID.'');
                            echo( mysqli_stmt_bind_result($stmt, $titel, $vakken, $jaar, $protocol));
                            mysqli_stmt_store_result($stmt);
                            mysqli_stmt_fetch($stmt);
                            
                            querySluiten();

                            //Bestandsnaam genereren aan de hand van waarden uit database
                            $fileName = $titel.' '.$vakken.' - Jaar'.$jaar.' - Protocol.pdf';
                            echo downloadFile($protocol, $fileName);
                            ob_end_clean();

                        }
                    }
                    $sql = 'SELECT protocolID, studentNaam, uploadDatum, titel, vakken, jaar
                    FROM protocol AS p
                    JOIN student AS s ON p.studentID = s.studentID ';
                    if(!empty($_GET['jaar'])){
                        if($_GET['jaar'] == 0 ){
                            
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
                    mysqli_stmt_bind_result($stmt, $protocolID, $studentNaam, $uploadDatum, $titel, $vakken, $jaar);
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
                            <td><form method='post'><input type='hidden' name='protocolID' value='{$protocolID}'>
                            <button  class='bluebtn' type='submit' value'submit' name='protocolSubmit'>Download</button></form></td>
                            </tr>";
                        }
                        echo"</table>";
                    }
                    querySluiten();
                    if(!isset($_GET['page']) || $_GET['page'] == 0){
                        $url = 'Protocollen.php?jaar='.$_GET['jaar'].'&page=';
                        $next = $url.'1';
                        echo'<a class="bluebtn" id="Pbutton" href='.$url.$next.'>Alle Protocollen</a>';
                    } else {
                        $url = 'Protocollen.php?jaar='.$_GET['jaar'].'&page=';
                        $next = $url.$_GET['page']+1;
                        $back = $url.$_GET['page']-1;

                        echo'<a class="bluebtn" id="Pbutton" href='.$next.'>Volgende pagina</a>';
                        echo'<a class="bluebtn" id="Pbutton" href='.$back.'>Volgende pagina</a>';
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


                
