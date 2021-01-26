<!DOCTYPE html>
<html>

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="../Css/Main.css">
    <link rel="stylesheet" href="../Css/Responsive.css">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Voorbereiding Bewerken</title>
</head>

<body>
<?PHP
    /* Header */
    include_once '../Include/Header.php';
	include_once '../Include/Dbh.inc.php';
?>

<main id="Voorbereiding">
    <div class="PageTitle">
        <h1>Voorbereiding</h1>
        <hr>
    </div>
    <div class="whitebg">
        <div class="content">
            <?PHP
                if(!empty($_GET['addVoorbereiding']))
                {
                    echo'<div class="bericht">';
                        $addVoorbereiding = $_GET["addVoorbereiding"];
                        if($addVoorbereiding != "failed")
                        {
                            echo'<b>De Voorbereiding is opgeslagen.</b><hr>';
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
                
                $sql = 'SELECT studentID,voorbereidingTitel,voorbereidingDatum,materialen,
                methode,hypothese,instellingenApparaten,voorbereidendevragen,veiligheid,
                vakken,uitvoerders,uitvoeringsDatum,theorie,benodigdeFormules,doel,jaar
				FROM voorbereiding
                WHERE voorbereidingID ='.$ID.' AND s.studentID = '.$_SESSION["StudentID"];

                queryAanmaken($sql);
                
                mysqli_stmt_bind_result($stmt, $studentID, $titelvoorbereiding, $voorbereidingsdatum, $materialen, $methode, $hypothese,
                $instellingenappraten, $voorbereidendevragen, $veiligheid, $vak, $uitvoerders, $uitvoeringsdatum, $uploadtheorie, $benodigdeFormules, $doel, $jaar);
                
                
                mysqli_stmt_store_result($stmt);  
                 
                                              
                while (mysqli_stmt_fetch($stmt)) {
                    echo '<form class="Lform" action="../Include/editvoorbereiding.inc.php?ID='.$ID.'" method="post" enctype="multipart/form-data">
            
                    <label for="titelvoorbereiding">Titel voorbereiding: * </label>
                    <input type="text" id="titellabvoorbereiding" name="titelvoorbereiding" size="40" value="'.$titelvoorbereiding.'"><br>
        
                    <label for="uitvoerders">Uitvoerders: * </label>
                    <input type="text" id="uitvoerders" name="uitvoerders" size="40" value="'.$uitvoerders.'"><br>
        
                    <label for="voorbereidingsdatum">Voorbereidings datum: * </label>
                    <input type="date" id="voorbereidingsdatum" name="voorbereidingsdatum" value="'.$voorbereidingsdatum.'"><br>
        
                    </br>
                    
                    <label for="uitvoeringsdatum">Uitvoerings datum: *</label>
                    <input type="date" id="uitvoeringsdatum" name="uitvoeringsdatum" value="'.$uitvoeringsdatum.'">
                    
                    </br>
        
                    <label for="uploadtheorie">Upload theorie: </label>
                    <input type="file" id="uploadtheorie" name="uploadtheorie" accept=".xls,.xlsx,.docx,.doc*" value="'.$uploadtheorie.'"> 
        
                    <br>
                    <br>
        
                    <label for="benodigdeFormules">Benodigde formules: </label>
                    <textarea id="benodigdeFormules" name="benodigdeFormules" rows="4" cols="50" placeholder="Voer gegevens in...">'.$benodigdeFormules.'</textarea>
        
                    <br>
                    <br>
        
                    <label for="instellingenapparaten">Instellingen apparaten: </label>
                    <textarea id="instellingenapparaten" name="instellingenapparaten" rows="4" cols="50" placeholder="Voer gegevens in...">'.$instellingenapparaten.'</textarea>
        
                    <br>
                    <br>
                    
                    <label for="doel">Doel: </label>
                    <textarea id="doel" name="doel" rows="4" cols="50" placeholder="Voer gegevens in...">'.$doel.'</textarea>
        
                    <br>
                    <br>
        
                    <label for="hypothese">Hypothese: </label>
                    <textarea id="hypothese" name="hypothese" rows="4" cols="50" placeholder="Voer gegevens in...">'.$hypothese.'</textarea>
        
                    <br>
                    <br>
                    
                    <label for="materialen">Materialen: </label>
                    <textarea id="materialen" name="materialen" rows="4" cols="50" placeholder="Voer gegevens in...">'.$materialen.'</textarea>
        
                    <br>
                    <br>
                
                    <label for="Methode">Methode: </label>
                    <textarea id="methode" name="methode" rows="4" cols="50" placeholder="Voer gegevens in...">'.$methode.'</textarea>
        
                    <br>
                    <br>
        
                    <label for="Veiligheid">Veiligheid: </label>
                    <textarea id="veiligheid" name="veiligheid" rows="4" cols="50" placeholder="Voer gegevens in...">'.$veiligheid.'</textarea>
        
                    <br>
                    <br>
        
                        
                    
                    <label for="Voorbereidendevragen">Voorbereidende vragen: </label>
                    <textarea id="voorbereidendevragen" name="voorbereidendevragen" rows="4" cols="50" placeholder="Voer gegevens in...">'.$voorbereidendevragen.'</textarea>
        
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