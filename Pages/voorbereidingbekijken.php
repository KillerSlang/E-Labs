<!DOCTYPE html>
<html>

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="../Css/Main.css">
    <link rel="stylesheet" href="../Css/Responsive.css">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Voorbereiding Bekijken</title>
</head>

<body>
<?PHP
    /* Header */
    include_once '../Include/Header.php';
	include_once 'Dbh.inc.php';
?>

<main id="Labjournaal">
    <div class="PageTitle">
        <h1>Voorbereiding</h1>
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
                

                $sql = 'SELECT studentID,voorbereidingTitel,voorbereidingDatum,materialen,
       methode,hypothese,instellingenApparaten,voorbereidendevragen,veiligheid,
       vakken,uitvoerders,uitvoeringsDatum,theorie,benodigdeFormules,doel,Jaar
				FROM voorbereiding
                WHERE voorbereidingID ='.$ID;

                queryAanmaken($sql);
                
                mysqli_stmt_bind_result($stmt, $studentID, $titelvoorbereiding, $voorbereidingsdatum, $materialen, $methode, $hypothese,
                $instellingenappraten, $voorbereidendevragen, $veiligheid, $vak, $uitvoerders, $uitvoeringsdatum, $uploadtheorie, $benodigdeFormules, $doel, $Jaar);
                
                mysqli_stmt_store_result($stmt);  
                 
                                              
                while (mysqli_stmt_fetch($stmt)) {
                    echo '
            
                    <label for="titellabjournaal">Titel labjournaal: </label>';
                    echo $titelvoorbereiding.' <br>
                    
                    
                    <label for="uitvoerders">Uitvoerders: </label>';
                    echo $uitvoerders.'
        
                    <br>
        
                    <label for="experimentdatum">Experiment datum: </label>';
                    echo $voorbereidingsdatum.'
        
                    <br><label for="experimentstartdatum">Start datum experiment: </label>';
                    echo $uitvoeringsdatum.'
        
                    <br>
        
                    <label for="uploadveiligheid">Theorie: </label>
                    <form method="post"><input type="hidden" name="labjournaalID" value="'.$ID.'">
                            <button id="Ptbutton" class="bluebtn" type="submit" value="submit" name="labjournaalSubmit">Download</button></form>
                    <br>
                    <br>
        
                    <label for="benodigdeFormules">Benodigde formules: </label>';
                    echo $benodigdeFormules.'
        
                    <br>
                    <br>
        
                    <!--<label for="uploadwaarnemingen">Upload waarnemingen bestand: </label>
                    <!--<input type="file" id="uploadwaarnemingen" name="uploadwaarnemingen" accept="image/*">-->
        
                    <br>
                    <br>
                
                    <label for="instellingenappraten">Instellingen appraten: </label>';
                    echo $instellingenappraten.'
        
                    <br>
                    <br>
        
                    <label for="doel">Doel: </label>';
                    echo $doel.'
        
                    <br>
                    <br>
        
                    <label for="hypothese">Hypothese: </label>';
                    echo $hypothese.'
        
                    <br>
                    <br>
        
                    <!--<label for="uploadmeetresultaten">Upload meetresultaten bestand: </label>
                    <!--<input type="file" id="uploadmeetresultaten" name="uploadmeetresultaten" accept=".xls,.xlsx,image/*">-->
        
                    <br>
                    <br>
                    
                    <label for="materialen">Materialen: </label>';
                    echo $materialen.'
        
                    <br>
                    <br>
                    
                    <!-- <label for="uploadlogboek">Upload logboek bestand: </label>
                    <!--<input type="file" id="uploadlogboek" name="uploadlogboek" accept=".xls,.xlsx,.doc,.docx">-->
        
                    <br>
                    <br>
        
                    <label for="methode">Methode: </label>';
                    echo $methode.'
        
                    <br>
                    <br>
                    
                    <!--<label for="uploadobservaties">Upload observatie bestand: </label>
                    <!--<input type="file" id="uploadobservaties" name="uploadobservaties" accept="image/*,.doc,.docx">-->
        
                    <br>
                    <br>
        
                    <label for="veiligheid">Veiligheid: </label>';
                    echo $veiligheid.'
        
                    <br>
                    <br>

                    <label for="voorbereidendevragen">Voorbereidende vragen: </label>';
                    echo $voorbereidendevragen.'
        
                    <br>
                    <br>
                    
                    <!--<label for="uploadweegegevens">Upload weeggegevens bestand: </label>
                    <!--<input type="file" id="uploadweeggegevens" name="uploadweeggegevens" accept=".xls,.xlsx">-->
        
                    <br>
                    <br>
        
                    <!--<label for="uploadafbeelding">Upload afbeeldingen: </label>
                    <!--<input type="file" id="uploadafbeelding" name="uploadafbeelding" accept="image/*" multiple>-->
        
                    <br>
                    <br>
                    <label for="Vakken">Vak: </label>';
                    echo $vak.'
                    <!--        <div name="Vakken">';
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
        }
            querySluiten();
        
            ?>
            
</main>            

<?php
    /* Footer */
    include_once '../Include/Footer.php';
?>