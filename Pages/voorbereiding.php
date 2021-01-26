<!DOCTYPE html>
<html>

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="../Css/Main.css">
    <link rel="stylesheet" href="../Css/Responsive.css">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Voorbereiding Bewerk</title>
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
                if(!empty($_GET['addLabjournaal']))
                {
                    echo'<div class="bericht">';
                        $addlabjournaal = $_GET["addLabjournaal"];
                        if($addlabjournaal != "failed")
                        {
                            echo'<b>Het labjournaal is opgeslagen.</b><hr>';
                        }
                        else
                        {
                            echo'<b>Niet alle velden zijn ingevuld</b><hr>';
                        }
                    echo'</div>';
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
				FROM labjournaal as l
                JOIN student AS s ON l.studentID = s.studentID
                WHERE labjournaalID ='.$ID.' AND s.studentID = '.$_SESSION["StudentID"];
                queryAanmaken($sql);
                
                mysqli_stmt_bind_result($stmt, $labjournaalTitel, $uitvoerders, $experimentDatum, $experimentBeginDatum, $experimentEindDatum, 
                                        $veiligheid, $doel, $bijlageWaarnemingen, $hypothese, $materialen, $methode, $bijlageMeetresultaten, $logboek,
                                        $bijlageLogboek, $observaties, $bijlageObservaties, $weeggegevens, $bijlageWeeggegevens, $bijlageAfbeelding,
                                        $vak, $jaar);
                
                mysqli_stmt_store_result($stmt);  
                 
                                              
                while (mysqli_stmt_fetch($stmt)) {
                    echo '<form class="Lform" action="../Include/editvoorbereiding.inc.php?ID='.$ID.'" method="post" enctype="multipart/form-data">
            
                    <label for="titelvoorbereiding">Titel voorbereiding: * </label>
                    <input type="text" id="titellabvoorbereiding" name="titelvoorbereiding" size="40">
        
                    <label for="uitvoerders">Uitvoerders: * </label>
                    <input type="text" id="uitvoerders" name="uitvoerders" size="40">
        
                    <label for="voorbereidingsdatum">Voorbereidings datum: * </label>
                    <input type="date" id="voorbereidingsdatum" name="voorbereidingsdatum">
        
                    </br>
                    
                    <label for="uitvoeringsdatum">Uitvoerings datum: *</label>
                    <input type="date" id="experimentstartdatum" name="uitvoeringsdatum">
                    
                    </br>
        
                    <label for="uploadtheorie">Upload theorie: </label>
                    <input type="file" id="uploadveiligheid" name="uploadtheorie" accept=".xls,.xlsx,.docx,.doc*"> 
        
                    <br>
                    <br>
        
                    <label for="benodigdeFormules">Benodigde formules: </label>
                    <textarea id="weeggegevens" name="benodigdeFormules" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea>
        
                    <br>
                    <br>
        
                    <label for="InstellingenApparaten">Instellingen apparaten: </label>
                    <textarea id="methode" name="instellingenapparaten" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea>
        
                    <br>
                    <br>
                    
                    <label for="doel">Doel: </label>
                    <textarea id="doel" name="doel" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea>
        
                    <br>
                    <br>
        
                    <label for="Hypothese">Hypothese: </label>
                    <textarea id="materialen" name="hypothese" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea>
        
                    <br>
                    <br>
                    
                    <label for="materialen">Materialen: </label>
                    <textarea id="materialen" name="materialen" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea>
        
                    <br>
                    <br>
                
                    <label for="Methode">Methode: </label>
                    <textarea id="hypothese" name="methode" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea>
        
                    <br>
                    <br>
        
                    <label for="Veiligheid">Veiligheid: </label>
                    <textarea id="observaties" name="veiligheid" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea>
        
                    <br>
                    <br>
        
                        
                    
                    <label for="Voorbereidendevragen">Voorbereidende vragen: </label>
                    <textarea id="logboek" name="voorbereidendevragen" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea>
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
       
                            </div>
        
                            <br>
                            <br>
        
                    <input class="bluebtn" type="Submit" id="LSubmit" name="LSubmit" value="Opslaan">
            </form>';
        }
            querySluiten();
        
            ?>
            
</main>            

<?php
    /* Footer */
    include_once '../Include/Footer.php';
?>