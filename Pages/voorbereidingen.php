<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="../Css/Main.css">
        <link rel="stylesheet" href="../Css/Responsive.css">
        <link rel="shortcut icon" type="image/png" href="../Images/favicon.png"/>
        <?php
            if($_COOKIE['taal'] == 'english') { // uit de cookie halen of de titel in het nederlands of engels moet.
                echo "<title>Preperations</title>";
            }
            else{
                echo "<title>Voorbereidingen</title>";
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
                }else {$selected = "BML";}
            }
        ?>
        <?php
        
        if($_SESSION['SorD'] == "Docent"){ // student en docent krijgen een verschillende achtergrond.
            $backgrounddocent = "class='Docentbackground'";
        }else{

            $backgrounddocent = "id='Protocol'";

        }
        
        ?>
        <main <?=$backgrounddocent?>>
            <div class="PageTitle">
                <h1><?=$VoorbereidingenOverzicht ?></h1>
                <hr>
            </div>
            <div class="whitebg">
                <div id="Lcontent7" class="content">
                    <?PHP
                        if($_SESSION['SorD'] == "Student") // waneeer een student is ingelogd is de Nieuw Voorbereiding knop en de bekijk knop beschikbaar.
                        {
                            echo '<a class="bluebtn Lbutton"  href="VoorbereidingNieuw.php?NEW">'.$VoorbereidingNieuw.'</a>
                                <a class="bluebtn Lbutton" id="PbuttonLeft" href="VoorbereidingenBekijken.php?jaar=0">'.$Bekijkvoorbereidingen.'</a>';
                        }
                    ?> 
                        <a class="bluebtn Lbutton <?=($_GET["jaar"] == 1) ? "Pselected" : ""?>"  href="voorbereidingen.php?jaar=1"><?=$Jaar1?></a>
                        <a class="bluebtn Lbutton <?=($_GET["jaar"] == 2) ? "Pselected" : ""?>"  href="voorbereidingen.php?jaar=2"><?=$Jaar2?></a>
                        <a class="bluebtn Lbutton <?=($_GET["jaar"] == 3) ? "Pselected" : ""?>"  href="voorbereidingen.php?jaar=3"><?=$Jaar3?></a>
                        <a class="bluebtn Lbutton <?=($_GET["jaar"] == 0) ? "Pselected" : ""?>"  href="voorbereidingen.php?jaar=0"><?=$JaarAlle?></a>
                    
                        <!-- Formulier van de select button van BML en Chemie -->
                        <form action="voorbereidingen.php?jaar=<?=$_GET["jaar"]?>" name="selectform" method="post"> 
                            <select class="bluebtn Lbutton"  name="vak" onchange="this.form.submit();">                        
                                <?PHP
                                    echo get_options($selected);
                                ?>
                            </select>
                        </form>
                        <?PHP
                            // Bouw de query via de sql variabele op.
                            queryAanmakenAdvanced(
                                'SELECT studentNaam,voorbereidingTitel,voorbereidingDatum,vak,v.jaar,voorbereidingID
                                FROM voorbereiding as v
                                JOIN student AS s ON v.studentID = s.studentID
                                ',false);    
                            if(!empty($_GET['jaar'])) // wanneer er op een jaar knop is gedrukt.
                            {
                                $jaarlaag = $_GET['jaar']; // haal het jaar uit de get
                                queryAanmakenAdvanced(
                                    ' WHERE v.jaar = ?',
                                    false,
                                    "i",
                                    $jaarlaag
                                ); // Voeg de Where statement met jaar toe aan de query.
                                if($_SESSION['SorD'] == "Student")// wanneer een student ingelogd is zal er gecontroleerd worden of het studentID overeenkomt.
                                {
                                    queryAanmakenAdvanced(
                                        ' AND s.studentID = ? ',
                                        false,
                                        "i",
                                        $_SESSION["StudentID"]
                                    );  
                                }       
                            }
                            else // anders wordt er alleen gecontroleerd op de student
                            {
                                $jaarlaag = 0; 
                                if($_SESSION['SorD'] == "Student")
                                {
                                    queryAanmakenAdvanced(
                                        ' WHERE s.studentID = ? ',
                                        false,
                                        "i",
                                        $_SESSION["StudentID"]
                                    );
                                }       
                            }
                            queryAanmakenAdvanced(
                                ' AND v.vak = ? ',
                                false,
                                "s",
                                $selected
                            );// voegt toe aan de query welk vak geselecteerd is.
                            if($_SESSION['SorD'] == "Student") // voor een docent is dit een bekijk pagina. Dus is deze query niet nodig bij de student wel.
                            { 
                                queryAanmakenAdvanced(
                                    ' AND v.bewerkTotDatum >= NOW()',
                                    false
                                ); // controleer de bewerkDatum met de datum van Nu.
                            }                  
                            queryAanmakenAdvanced(
                                'ORDER BY voorbereidingDatum DESC ',
                                false
                            ); // de volgorde van de voorbereidingen is via de experiment datum.
                
                            if(!isset($_GET['page']) || $_GET['page'] == 0){
                                queryAanmakenAdvanced('LIMIT 5',false); 
                            } else {
                                $counter = $_GET['page'];
                                $limit = 20;
                                $offset = $limit*($counter-1);
                                //$sql = $sql.'LIMIT '.$limit.' OFFSET '.$offset.'';
                                queryAanmakenAdvanced(
                                    'LIMIT ? OFFSET ?',
                                    false,
                                    "ii",
                                    $limit,$offset
                                );
                            }
                            queryAanmakenAdvanced(' ',true); // de opgebouwde query wordt via deze functie uitgevoerd.
                            mysqli_stmt_bind_result($stmt, $studentID, $voorbereidingTitel, $voorbereidingDatum, $vak, $jaar, $voorbereidingID);
                            mysqli_stmt_store_result($stmt);
                            if(mysqli_stmt_num_rows($stmt) != 0) // wanneer er resultaten zijn wordt de tabel uitgeprint en de knoppen onderaan ook weergeven anders niet.
                            {
                                echo "<table class='LTable'><tr> <th>".$Titel."</th><th>".$Auteur."</th><th>".$Voorbereidingdatumtekst."</th><th>".$Vakken."</th><th>".$Jaar."</th>";
                                if($_SESSION["SorD"] == "Student")// een student heeft na het maken van het Voorbereiding 1 dag om deze te bewerken of te verwijderen.
                                {
                                    echo"<th>".$Bewerken."</th><th>".$Verwijderen."</th>";
                                }else{ echo"<th>".$Bekijken."</th>";} // een docent kan de voorbereidingen alleen bekijken.
                                echo '</tr>'; // table row sluiten.
                                while(mysqli_stmt_fetch($stmt)) // alle resultaten in een rij van de tabel zetten.
                                {
                                    echo '<tr>
                                    <td>'.$voorbereidingTitel.'</td>
                                    <td>'.$studentID.'</td>
                                    <td>'.$voorbereidingDatum.'</td>
                                    <td>'.$vak.'</td>
                                    <td>'.$jaar.'</td>';
                                    //<td> <a class="labjournaalLink" href="../Include/downloadVoorbereiding.inc.php?ID='.$voorbereidingID .'"> <i class="fas fa-download"></i> </a> </td>';
                                    
                                    if($_SESSION["SorD"] == "Student") // de bewerk en de verwijder-knop van de student printen.
                                    {
                                        echo'<td> <a class="labjournaalLink" href="voorbereidingBewerk.php?NEW&ID='.$voorbereidingID .'">'.$Bewerken.' </a></td>';
                                        echo'<td> <a class="labjournaalLink" onclick="DeleteVoorbereiding('.$voorbereidingID .');"> <i class="fa fa-trash"></i> </a> </td>';
                                    }else{ echo'<td> <a class="labjournaalLink" href="voorbereidingbekijken.php?ID='.$voorbereidingID .'">'.$Bekijken.'</a></td>';} // de bekijken-knop van de student printen.
                                    
                                    echo '</tr>' ;
                                }
                                echo"</table>";
                                $queryError = false;
                            }else {$queryError = true;}
                            if(!isset($_GET['page']) || $_GET['page'] == 0){ // de knoppen printen om door de Voorbereidingen heen te gaan.
                                $url = 'voorbereidingen.php?jaar='.$jaarlaag.'&page=';
                                $next = $url.'1';
                                echo'<a class="bluebtn Lbutton Lpages4"  href='.$next.'>'.$VoorbereidingenAlle.'</a>';
                            } else {
                                $url = 'voorbereidingen.php?jaar='.$jaarlaag.'&page=';
                                $next = $_GET['page']+1;
                                $back = $_GET['page']-1;
                                echo'<a class="bluebtn Lbutton Lpages1"  href="'.$url.$next.'">'.$PaginaVolgende.'</a>';
                                echo'<p class="Lpages2">'.$_GET['page'].'</p>';
                                echo'<a class="bluebtn Lbutton Lpages3"  href="'.$url.$back.'">'.$PaginaVorige.'</a>';
                            }
                            querySluiten(); // de database connectie sluiten.
                            
                            if($queryError)
                            { 
                                echo '<div class="bericht">
                                        <b>'.$GeenVoorbereidingen.'</b><hr>
                                    </div>';
                            }
                        ?>
                </div>
            </div>
        </main>
        <script>
            function DeleteVoorbereiding(ID) {
                var r = confirm("Weet je het zeker?");
                if (r == true) {
                    window.location.href = "../Include/deleteVoorbereiding.inc.php?ID="+ID;
                }
            }
        </script>
        <?php 
        /* Footer */
        include_once '../Include/Footer.php';
        ?>    
    </body>
</html>
