<!DOCTYPE html>
<html>

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/cda83c7af3.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Css/Main.css">
    <link rel="stylesheet" href="../Css/Responsive.css">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Nieuw Labjournaal</title>
</head>

<body>
<?PHP
    /* Header */
    include_once '../Include/Header.php';
	include_once '../Include/Dbh.inc.php';
?>

<main id="Labjournaal">
    <div class="PageTitle">
        <h1>Labjournaal</h1>
        <hr>
    </div>
    <div class="whitebg">
        <div class="content">
            <?PHP
                if(isset($_POST['labjournaalSubmit'])){
                    if(!empty($_POST['labjournaalID'])) {
                        
                        $labjournaalID = $_POST['labjournaalID'];
                        queryAanmaken('SELECT labjournaalTitel, vak, jaar, veiligheid
                                        FROM labjournaal 
                                        WHERE labjournaalID = '.$f.'');
                        echo( mysqli_stmt_bind_result($stmt, $titel, $vakken, $jaar, $veiligheid));
                        mysqli_stmt_store_result($stmt);
                        mysqli_stmt_fetch($stmt);
                        
                        querySluiten();

                        //Bestandsnaam genereren aan de hand van waarden uit database
                        $fileName = $titel.' '.$vakken.' - Jaar'.$jaar.' - veiligheid.pdf';
                        echo downloadFile($veiligheid	, $fileName);

                    }
                }

				if(!empty($_GET['ID']))
				{
					$ID = filter_input(INPUT_GET,'ID', FILTER_SANITIZE_SPECIAL_CHARS);
                }else{ $ID = 0; }
                

                $sql = 'SELECT labjournaalTitel,uitvoerders,experimentdatum,
				experimentBeginDatum,experimentEindDatum,veiligheid,doel,bijlageWaarnemingen,
				hypothese,materialen,methode,bijlageMeetresultaten,logboek,bijlageLogboek,
				observaties,bijlageObservaties,weeggegevens,bijlageWeeggegevens,
				bijlageAfbeelding,vak,jaar
				FROM labjournaal
                WHERE labjournaalID ='.$ID;
                queryAanmaken($sql);
                
                mysqli_stmt_bind_result($stmt, $labjournaalTitel, $uitvoerders, $experimentDatum, $experimentBeginDatum, $experimentEindDatum, 
                                        $veiligheid, $doel, $bijlageWaarnemingen, $hypothese, $materialen, $methode, $bijlageMeetresultaten, $logboek,
                                        $bijlageLogboek, $observaties, $bijlageObservaties, $weeggegevens, $bijlageWeeggegevens, $bijlageAfbeelding,
                                        $vak, $jaar);
                
                mysqli_stmt_store_result($stmt);  
                 
                                              
                while (mysqli_stmt_fetch($stmt)) {}
                    echo '
            
                    <label for="titellabjournaal">Titel experiment: * </label>';
                    echo $labjournaalTitel.' <br>
                    
                    
                    <label for="uitvoerders">Uitvoerders: * </label>';
                    $uitvoerdersArray = unserialize(base64_decode($uitvoerders));
                    foreach($uitvoerdersArray as $uitvoerder)
                    {
                        queryAanmaken(
                            'SELECT studentNaam
                            FROM student
                            WHERE studentNummer = '.$uitvoerder);
                        mysqli_stmt_bind_result($stmt, $studentNaam);
                        mysqli_stmt_store_result($stmt);
                        while (mysqli_stmt_fetch($stmt)) 
                        {
                            echo '<br> &nbsp; &nbsp; &nbsp;- '.$studentNaam;
                        }
                        querySluiten();
                    }        
                    echo'
                    <br>
                    <label for="experimentdatum">Experiment datum: * </label>';
                    echo $experimentDatum.'
        
                    <br><label for="experimentstartdatum">Start datum experiment: </label>';
                    echo $experimentBeginDatum.'
        
                    <br><label for="experimenteinddatum">Eind datum experiment: </label>';
                    echo $experimentEindDatum.'
        
                    <br>
        
                    <label for="uploadveiligheid">Veiligheid: </label>';
                        if(!empty($veiligheid)){
                            echo'<a class="bluebtn" id="Pbutton" target="_blank" href="'.$veiligheid.'" download>Download</a>';
                            $extension = explode(".", $veiligheid);
                            if ($extension[3] == "jpg" || $extension[3] == "jpeg" || $extension[3] == "png"){
                                echo '<img src="'.$veiligheid.'">';
                            }
                        } else {
                            echo'Geen bestand geupload.';
                        }
                    echo '<br>
                    <br>
        
                    <label for="doel">Doel: </label>
                    <textarea class="autoresizingBekijken" readonly>';
                        echo $doel.'
                    </textarea>        
        
                    <label for="uploadwaarnemingen">Download waarnemingen: </label>';
                    if(!empty($bijlageWaarnemingen)){
                        echo'<a class="bluebtn" id="Pbutton" target="_blank" href="'.$bijlageWaarnemingen.'" download>Download</a>
                        <img src="'.$bijlageWaarnemingen.'">';
                    } else {
                        echo'Geen bestand geupload.';
                    }
                    echo'<br>
                    <br>
                
                    <label for="hypothese">Hypothese: </label>
                    <textarea class="autoresizingBekijken" readonly>';
                        echo $hypothese.'
                    </textarea>

        
                    <label for="materialen">Materialen: </label>
                    <textarea class="autoresizingBekijken" readonly>';
                        echo $materialen.'
                    </textarea>

        
                    <label for="methode">Methode: </label>
                    <textarea class="autoresizingBekijken" readonly>';
                        echo $methode.'
                    </textarea>

        
                    <label for="uploadmeetresultaten">Download meetresultaten: </label>';
                    if(!empty($bijlageMeetresultaten)){
                        $extension = explode(".", $bijlageMeetresultaten);
                        if ($extension[3] == "jpg" || $extension[3] == "jpeg" || $extension[3] == "png"){
                            echo '<img src="'.$bijlageMeetresultaten.'">';
                        }  
                    } else {
                        echo'Geen bestand geupload.';
                    }
                    echo '
        
                    <br>
                    <br>
                    
                    <label for="logboek">Logboek: </label>
                    <textarea class="autoresizingBekijken" readonly>';
                        echo $logboek.
                    '</textarea>
        
                    
                    <label for="uploadlogboek">Download logboek: </label>';
                    if(!empty($bijlageLogboek)){
                        echo'<a class="bluebtn" id="Pbutton" target="_blank" href="'.$bijlageLogboek.'" download>Download</a>';
                    } else {
                        echo'Geen bestand geupload.';
                    }
                    echo'<br>
                    <br>
        

        
                    <label for="observaties">Observaties: </label>
                    <textarea class="autoresizingBekijken" readonly>';
                        echo $observaties.'
                    </textarea>

                    
                    <label for="uploadobservaties">Download observatie: </label>';
                    if(!empty($bijlageObservaties)){
                        echo'<a class="bluebtn" id="Pbutton" target="_blank" href="'.$bijlageObservaties.'" download>Download</a>';
                        $extension = explode(".", $bijlageObservaties);
                        if ($extension[3] == "jpg" || $extension[3] == "jpeg" || $extension[3] == "png"){
                            echo '<img src="'.$bijlageObservaties.'">';
                        }
                    } else {
                        echo'Geen bestand geupload.';
                    }
                    echo '
                    <br>
                    <br>
        
                    <label for="weeggegevens">Weeggegevens: </label>
                    <textarea class="autoresizingBekijken" readonly>';
                        echo $weeggegevens.'
                    </textarea>
                    <label for="weeggegevens">Weeggegevens: </label>
                    <textarea class="autoresizingBekijken" readonly>';
                        echo $weeggegevens.'
                    </textarea>

                    
                    <label for="uploadweegegevens">Download weeggegevens: </label>';
                    if(!empty($bijlageWeeggegevens)){
                        echo'<a class="bluebtn" id="Pbutton" target="_blank" href="'.$bijlageWeeggegevens.'" download>Download</a>';
                    } else {
                        echo'Geen bestand geupload.';
                    }
                    echo'
                    <br>
                    <br>
        
                    <label for="uploadafbeelding">Download afbeeldingen: </label>';
                    if(!empty($bijlageAfbeelding)){
                        echo'<a class="bluebtn" id="Pbutton" target="_blank" href="'.$bijlageAfbeelding.'" download>Download</a>
                        <img src="'.$bijlageAfbeelding.'">';
                    } else {
                        echo'Geen bestand geupload.';
                    }
                    echo'
                    <br>
                    <br>
                    <label for="Vakken">Vak: *</label>
                            <div name="Vakken">';
                                if ($vak == "BML")
                                {
                                    echo'
                                    <input type="radio" id="BML" name="LVak" value="BML" checked>
                                    <label for="BML">BML</label><br>
                                    <input type="radio" id="Chemie" name="LVak" value="Chemie">
                                    <label for="Chemie">Chemie</label>';
                                }
                                else
                                {
                                    echo'
                                    <input type="radio" id="BML" name="LVak" value="BML">
                                    <label for="BML">BML</label><br>
                                    <input type="radio" id="Chemie" name="LVak" value="Chemie" checked>
                                    <label for="Chemie">Chemie</label>';
                                }
                    echo ' 
                            </div>    
        
                        
                            <br>
                               
        
                    <label for="Jaren">Jaar: *</label>
                            <div name="Jaren">';
                            if ($jaar == "1") 
                            {
                                echo '<input type="radio" id="Jaar 1" name="PJaar" value="1" checked>
                                <label for="BML">Jaar 1</label><br>
                                <input type="radio" id="Jaar 2" name="PJaar" value="2">
                                <label for="Chemie">Jaar 2</label><br>
                                <input type="radio" id="Jaar 3" name="PJaar" value="3">
                                <label for="Chemie">Jaar 3</label>';
                            } elseif ($jaar == "2")
                            {
                                echo '<input type="radio" id="Jaar 1" name="PJaar" value="1">
                                <label for="BML">Jaar 1</label><br>
                                <input type="radio" id="Jaar 2" name="PJaar" value="2" checked>
                                <label for="Chemie">Jaar 2</label><br>
                                <input type="radio" id="Jaar 3" name="PJaar" value="3">
                                <label for="Chemie">Jaar 3</label>';
                            } elseif ($jaar == "3") 
                            {
                                echo '<input type="radio" id="Jaar 1" name="PJaar" value="1" >
                                <label for="BML">Jaar 1</label><br>
                                <input type="radio" id="Jaar 2" name="PJaar" value="2">
                                <label for="Chemie">Jaar 2</label><br>
                                <input type="radio" id="Jaar 3" name="PJaar" value="3" checked>
                                <label for="Chemie">Jaar 3</label>';
                            } else {
                                echo '<input type="radio" id="Jaar 1" name="PJaar" value="1" checked>
                                <label for="BML">Jaar 1</label><br>
                                <input type="radio" id="Jaar 2" name="PJaar" value="2">
                                <label for="Chemie">Jaar 2</label><br>
                                <input type="radio" id="Jaar 3" name="PJaar" value="3">
                                <label for="Chemie">Jaar 3</label>';
                            }
                            echo '    
                            </div>';
                           
                            
                            $ID = filter_input(INPUT_GET,'ID', FILTER_SANITIZE_SPECIAL_CHARS);

                            if($_SESSION['SorD'] == "Docent") 
                             {
                                 echo '<form class="" action="../Include/toevoegenBeoordeling.inc.php?ID='.$ID.'" method="post">

                                    <br>
                                    <br>
                                     <label for="beoordeling">Beoordeling: </label>
                                     <input type="number" id="beoordeling" name="beoordeling" min="0" max="10" value="0" step="0.1" style="width: 3em">

                                     <br>
                                     <br>

                                     <input class="bluebtn" type="Submit" id="beoordelingSubmit" name="beoordelingSubmit" value="Opslaan">
                                    </form>';
                             } 

                            
                            
                        
            ?>
</main>
<script type="text/javascript">
    textarea = document.querySelectorAll(".autoresizingBekijken");
    textarea.forEach(function(ta){
        var event = new CustomEvent("resizeAfterRefresh");
        ta.addEventListener('input', autoResize, false);
        ta.addEventListener('resizeAfterRefresh', autoResize, false);
        ta.dispatchEvent(event);
    })
    function autoResize() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    }
</script>            
<?php
    /* Footer */
    include_once '../Include/Footer.php';
?>
</body>