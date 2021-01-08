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
            <h1><?=$Protocol?></h1>
            <hr>
        </div>
        <div class="whitebg">
            <div class="content">
                <a class="bluebtn" id="Pbutton" href='NewProtocol.php'><?=$ProtocolNieuw?></a>
                <a class="bluebtn" id="Pbutton" href='Protocollen.php?jaar=3'><?=$Jaar1?></a>
                <a class="bluebtn" id="Pbutton" href='Protocollen.php?jaar=2'><?=$Jaar2?></a>
                <a class="bluebtn" id="Pbutton" href='Protocollen.php?jaar=1'><?=$Jaar3?></a>
                <a class="bluebtn" id="Pbutton" href='Protocollen.php?jaar=0'><?=$JaarAlle?></a>
                
                <br>
                <?php
                    $sql = 'SELECT protocolID, studentNaam, uploadDatum, titel, vakken, jaar, protocol
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
                    mysqli_stmt_bind_result($stmt, $protocolID, $studentNaam, $uploadDatum, $titel, $vakken, $jaar, $protocolDir);
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) != 0)
                    {
                        echo "<table class='PTable'><th>".$Titel."</th><th>".$Auteur."</th><th>".$UploadDatum."</th><th>".$Vakken."</th><th>".$Jaar."</th><th>".$Protocol."</th>";
                        while(mysqli_stmt_fetch($stmt))
                        {
                            echo "<tr>
                            <td>".$titel."</td>
                            <td>".$studentNaam."</td>
                            <td>".$uploadDatum."</td>
                            <td>".$vakken."</td>
                            <td>".$jaar."</td>
                            <td><a class='bluebtn' id='Pbutton' target='_blank' href='".$protocolDir."'>Download</a></td>
                            </tr>";
                        }
                        echo"</table>";
                    }
                    querySluiten();
                    if(!isset($_GET['page']) || $_GET['page'] == 0){
                        $url = 'Protocollen.php?jaar='.$_GET['jaar'].'&page=';
                        $next = '1';
                        echo'<a class="bluebtn" id="Pbutton" href='.$url.'1>'.$ProtocollenAlle.'</a>';
                    } else {
                        $url = 'Protocollen.php?jaar='.$_GET['jaar'].'&page=';
                        $next = $_GET['page']+1;
                        $back = $_GET['page']-1;

                        echo'<a class="bluebtn" id="Pbutton" href='.$url.$next.'>'.$PaginaVolgende.'</a>';
                        echo'<a class="bluebtn" id="Pbutton" href='.$url.$back.'>'.$PaginaVorige.'</a>';
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