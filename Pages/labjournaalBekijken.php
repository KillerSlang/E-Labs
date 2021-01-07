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
                                        WHERE labjournaalID = '.$labjournaalID.'');
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
            
                    <label for="titellabjournaal">Titel labjournaal: * </label>';
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
        
                    <label for="uploadveiligheid">Veiligheid: </label>
                    <form method="post"><input type="hidden" name="labjournaalID" value="'.$ID.'">
                            <button id="Ptbutton" class="bluebtn" type="submit" value="submit" name="labjournaalSubmit">Download</button></form>
                    <br>
        
                    <label for="doel">Doel: </label>
                    <textarea class="autoresizingBekijken" readonly>';
                        echo $doel.'
                    </textarea>        
        
                    <label for="uploadwaarnemingen">Upload waarnemingen bestand: </label>
                    <!--<input type="file" id="uploadwaarnemingen" name="uploadwaarnemingen" accept="image/*">-->
        
                    <br>
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

        
                    <label for="uploadmeetresultaten">Upload meetresultaten bestand: </label>
                    <!--<input type="file" id="uploadmeetresultaten" name="uploadmeetresultaten" accept=".xls,.xlsx,image/*">-->
        
                    <br>
                    <br>
                    
                    <label for="logboek">Logboek: </label>
                    <textarea class="autoresizingBekijken" readonly>';
                        echo $logboek.
                    '</textarea>
        
                    
                    <label for="uploadlogboek">Upload logboek bestand: </label>
                    <!--<input type="file" id="uploadlogboek" name="uploadlogboek" accept=".xls,.xlsx,.doc,.docx">--><br>
        

        
                    <label for="observaties">Observaties: </label>
                    <textarea class="autoresizingBekijken" readonly>';
                        echo $observaties.'
                    </textarea>

                    
                    <label for="uploadobservaties">Upload observatie bestand: </label>
                    <!--<input type="file" id="uploadobservaties" name="uploadobservaties" accept="image/*,.doc,.docx">--><br>
        

        
                    <label for="weeggegevens">Weeggegevens: </label>
                    <textarea class="autoresizingBekijken" readonly>';
                        echo $weeggegevens.'
                    </textarea>

                    
                    <label for="uploadweegegevens">Upload weeggegevens bestand: </label>
                    <!--<input type="file" id="uploadweeggegevens" name="uploadweeggegevens" accept=".xls,.xlsx">-->
        
                    <br>
                    <br>
        
                    <label for="uploadafbeelding">Upload afbeeldingen: </label>
                    <!--<input type="file" id="uploadafbeelding" name="uploadafbeelding" accept="image/*" multiple>-->
        
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
                                    <!--<input type="radio" id="BML" name="LVak" value="BML">
                                    <label for="BML">BML</label><br>
                                    <input type="radio" id="Chemie" name="LVak" value="Chemie" checked>
                                    <label for="Chemie">Chemie</label>-->';
                                }
                    echo ' 
                            </div>    
        
                        
                            <br>
                               
        
                    <!--<label for="Jaren">Jaar: *</label>
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
       
                            </div>-->
        
                            <br>
                            <br>
        
                    
            ';
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
</body>
<?php
    /* Footer */
    include_once '../Include/Footer.php';
?>