<!DOCTYPE HTML>
<html lang="en">
<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="../Css/Main.css">
    <link rel="stylesheet" href="../Css/Responsive.css">
    <link rel="shortcut icon" type="image/png" href="../Images/favicon.png"/>
    <?php
        if($_COOKIE['taal'] == 'english') {
            echo "<title>Protocols</title>";
        }
        else{
            echo "<title>Protocollen</title>";
        }
    ?>
    <?php
        if($_SESSION['SorD'] == "Docent"){
            $backgrounddocent = "class='Docentbackground'";
        }else{

            $backgrounddocent = "id='Protocol'";

        }
    ?>
</head>
<body>
    <?php 
    /* Include header en database handler */
    include_once '../Include/Header.php';
    include_once '../Include/Dbh.inc.php';
    function get_options($select) // Functie om de selectknop voor BML en Chemie Onchange te veranderen.
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
    if(isset($_POST["vak"])) //wanneer vak is opgehaald uit de post print deze uit als geselecteerd. 
    {
        $selected = $_POST["vak"];
        $_SESSION["select"] = $selected;
    }
    else // wanneer er geen post waarde is. Dan is BML het standaard vak.
    {
        if(isset($_SESSION["select"])) 
        {
            $selected = $_SESSION["select"];
        } else {$selected = "BML";}
    }
    ?>
    <?php /* als docent is ingelogd */
        if($_SESSION['SorD'] == "Docent"){
            $backgrounddocent = "class='Docentbackground'";
        }else{

            $backgrounddocent = "id='Protocol'";

        }
    ?>
    <main <?=$backgrounddocent?>>
    <div class="PageTitle">
            <h1><?=$Protocol?></h1>
            <hr>
        </div>
        <div class="whitebg">
            <div class="content" id="Pcontent">
                <!-- jaar selectie -->
                <a class="bluebtn Pbutton" href='NewProtocol.php'><?=$ProtocolNieuw?></a>
                <a class="bluebtn Pbutton <?=($_GET["jaar"] == 1) ? "Pselected" : ""?>" href='Protocollen.php?jaar=1'><?=$Jaar1?></a>
                <a class="bluebtn Pbutton <?=($_GET["jaar"] == 2) ? "Pselected" : ""?>" href='Protocollen.php?jaar=2'><?=$Jaar2?></a>
                <a class="bluebtn Pbutton <?=($_GET["jaar"] == 3) ? "Pselected" : ""?>" href='Protocollen.php?jaar=3'><?=$Jaar3?></a>
                <a class="bluebtn Pbutton <?=($_GET["jaar"] == 0) ? "Pselected" : ""?>" href='Protocollen.php?jaar=0'><?=$JaarAlle?></a>
                <!-- Formulier van de select button van BML en Chemie -->
                <form id="Pdropdwn" action='Protocollen.php?jaar=<?=$_GET["jaar"]?>' name="selectform" method="post">
                    <select  class="bluebtn" name="vak" onchange="this.form.submit();">
                        <?PHP
                            echo get_options($selected);
                        ?>
                    </select>
                </form>
                
                <br>
                <?php
                /* Protocol overzicht */
                    $sql = 'SELECT protocolID, studentNaam, uploadDatum, titel, vakken, p.jaar, protocol
                    FROM protocol AS p
                    JOIN student AS s ON p.studentID = s.studentID ';
                    $sql .= 'WHERE p.vakken = "'.$selected.'" ';
                    if(!empty($_GET['jaar'])){
                        if($_GET['jaar'] == 0 ){
                            
                        } else {
                            $sqljaar = $_GET['jaar'];
                            $sql .= 'AND p.jaar = '.$sqljaar.' ';
                        }
                    }

                    $sql .= 'ORDER BY uploadDatum DESC ';
                    
                    if(!isset($_GET['page']) || $_GET['page'] == 0){
                        $sql .= 'LIMIT 5'; 
                    } else {
                        $counter = $_GET['page'];
                        $limit = 20;
                        $offset = $limit*($counter-1);
                        $sql .= 'LIMIT '.$limit.' OFFSET '.$offset.'';
                    }
                    queryAanmaken($sql);
                    mysqli_stmt_bind_result($stmt, $protocolID, $studentNaam, $uploadDatum, $titel, $vakken, $jaar, $protocolDir);
                    mysqli_stmt_store_result($stmt);
                    if(mysqli_stmt_num_rows($stmt) != 0)
                    {
                        echo "<table class='PTable'><th>".$Titel."</th><th>".$Auteur."</th><th>".$UploadDatum."</th><th>".$Vakken."</th><th>".$Jaar."</th><th>".$Protocol."</th>";
                        while(mysqli_stmt_fetch($stmt))
                        {
                            $datum = explode("-", $uploadDatum);
                            $uploadDatumB = $datum[2]."-".$datum[1]."-".$datum[0];
                            echo "<tr>
                            <td>".$titel."</td>
                            <td>".$studentNaam."</td>
                            <td>".$uploadDatumB."</td>
                            <td>".$vakken."</td>
                            <td>".$jaar."</td>
                            <td><a class='bluebtn Pbutton' target='_blank' href='".$protocolDir."'> <i class='fa fa-download'></i> </a></td>
                            </tr>";
                        }
                        echo"</table>";
                        $queryError = false;
                    }else {$queryError = true;}
                    querySluiten();
                    if(!isset($_GET['page']) || $_GET['page'] == 0){
                        $url = 'Protocollen.php?jaar='.$_GET['jaar'].'&page=';
                        $next = '1';
                        echo'<a class="bluebtn Pbutton Ppages4" href="'.$url.'1">'.$ProtocollenAlle.'</a>';
                    } else {
                        $url = 'Protocollen.php?jaar='.$_GET['jaar'].'&page=';
                        $next = $_GET['page']+1;
                        $back = $_GET['page']-1;

                        echo'<a class="bluebtn Pbutton Ppages1"  href="'.$url.$back.'">'.$PaginaVorige.'</a>';
                        echo'<p class="Ppages2">'.$_GET['page'].'</p>';
                        echo'<a class="bluebtn Pbutton Ppages3" href="'.$url.$next.'">'.$PaginaVolgende.'</a>';
                    }
                    if($queryError)
                    { 
                        echo '<div class="bericht">
                                <b>'.$GeenProtocollen.'</b><hr>
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