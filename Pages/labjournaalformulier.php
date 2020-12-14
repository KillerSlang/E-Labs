<!DOCTYPE html>
<html>

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="../Css/Main.css">
    <link rel="stylesheet" href="../Css/Responsive.css">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Nieuw Labjournaal</title>
</head>

<body>
<?PHP
    /* Header */
    include_once '../Include/Header.php';
<<<<<<< Updated upstream

?>

<main id="Labjournaal">
=======
    
    if(!empty($_GET['addLabjournaal']))
    {
        $addlabjournaal = $_GET["addLabjournaal"];
        if($addlabjournaal != "failed")
        {
            echo"de query is uitgevoerd.";
        }
        else
        {
            echo"niet alle velden zijn ingevuld.";
        }
    }
?>

<main id="Protocol">
>>>>>>> Stashed changes
    <div class="PageTitle">
        <h1>Nieuw Labjournaal formulier aanmaken</h1>
        <hr>
    </div>
<<<<<<< Updated upstream
    <div class="whitebg">
        <div class="content">
            <?PHP
                if(!empty($_GET['addLabjournaal']))
                {
                    $addlabjournaal = $_GET["addLabjournaal"];
                    if($addlabjournaal != "failed")
                    {
                        echo'<b class="bericht">de query is uitgevoerd</b><hr>';
                    }
                    else
                    {
                        echo'<b class="bericht">Niet alle velden zijn ingevuld</b><hr>';
                    }
                }
            ?>
            <form class="Lform" action="../includes/addlabjournaal.inc.php" method="post" enctype="multipart/form-data">
            
            <label for="titellabjournaal">Titel labjournaal: * </label>
            <input type="text" id="titellabjournaal" name="titelLabjournaal" size="40">
            
            <label for="uitvoerders">Uitvoerders: * </label>
            <input type="text" id="uitvoerders" name="uitvoerders" size="40">

            <br>

            <label for="experimentdatum">Experiment datum: * </label>
            <input type="date" id="experimentdatum" name="experimentdatum">

            <label for="experimentstartdatum">Start datum experiment: </label>
            <input type="date" id="experimentstartdatum" name="experimentstartdatum">

            <label for="experimenteinddatum">Eind datum experiment: </label>
            <input type="date" id="experimenteinddatum" name="experimenteinddatum">

            <br>

            <label for="uploadveiligheid">Upload veiligheid: </label>
            <input type="file" id="uploadveiligheid" name="uploadveiligheid" accept=".xls,.xlsx,image/*">

            <br>
            <br>

            <label for="doel">Doel: </label>
            <textarea id="doel" name="doel" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea>

            <br>
            <br>

            <label for="uploadwaarnemingen">Upload waarnemingen bestand: </label>
            <input type="file" id="uploadwaarnemingen" name="uploadwaarnemingen" accept="image/*">

            <br>
            <br>
        
            <label for="hypothese">Hypothese: </label>
            <textarea id="hypothese" name="hypothese" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea>

            <br>
            <br>

            <label for="materialen">Materialen: </label>
            <textarea id="materialen" name="materialen" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea>

            <br>
            <br>

            <label for="methode">Methode: </label>
            <textarea id="methode" name="methode" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea>

            <br>
            <br>

            <label for="uploadmeetresultaten">Upload meetresultaten bestand: </label>
            <input type="file" id="uploadmeetresultaten" name="uploadmeetresultaten" accept=".xls,.xlsx,image/*">

            <br>
            <br>
            
            <label for="logboek">Logboek: </label>
            <textarea id="logboek" name="logboek" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea>

            <br>
            <br>
            
            <label for="uploadlogboek">Upload logboek bestand: </label>
            <input type="file" id="uploadlogboek" name="uploadlogboek" accept=".xls,.xlsx,.doc,.docx">

            <br>
            <br>

            <label for="observaties">Observaties: </label>
            <textarea id="observaties" name="observaties" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea>

            <br>
            <br>
            
            <label for="uploadobservaties">Upload observatie bestand: </label>
            <input type="file" id="uploadobservaties" name="uploadobservaties" accept="image/*,.doc,.docx">

            <br>
            <br>

            <label for="weeggegevens">Weeggegevens: </label>
            <textarea id="weeggegevens" name="weeggegevens" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea>

            <br>
            <br>
            
            <label for="uploadweegegevens">Upload weeggegevens bestand: </label>
            <input type="file" id="uploadweeggegevens" name="uploadweeggegevens" accept=".xls,.xlsx">

            <br>
            <br>

            <label for="uploadafbeelding">Upload afbeeldingen: </label>
            <input type="file" id="uploadafbeelding" name="uploadafbeelding" accept="image/*" multiple>

            <br>
            <br>
=======
    
    <div class="whitebg">
        <div class="content">

            <form class="Lform" action="includes/addlabjournaal.inc.php" method="post">

            <h2>Voer data in: </h2>

            <p><label for="titellabjournaal">Titel labjournaal: * </label>
            <input type="text" id="titellabjournaal" name="titelLabjournaal" size="40"></p>

            <p><label for="uitvoerders">Uitvoerders: * </label>
            <input type="text" id="uitvoerders" name="uitvoerders" size="40"></p>

            <br>

            <p><label for="experimentdatum">Experiment datum: * </label>
            <input type="date" id="experimentdatum" name="experimentdatum"></p>

            <p><label for="experimentstartdatum">Start datum experiment: </label>
            <input type="date" id="experimentstartdatum" name="experimentstartdatum"></p>

            <p><label for="experimenteinddatum">Eind datum experiment: </label>
            <input type="date" id="experimenteinddatum" name="experimenteinddatum"></p>

            <br>

            <p><label for="uploadveiligheid">Upload veiligheid: </label><br>
            <input type="file" id="uploadveiligheid" name="uploadveiligheid" accept=".xls,.xlsx,image/*"></p>

            <p><label for="doel">Doel: </label><br>
            <textarea id="doel" name="doel" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea></p>

            <p><label for="uploadwaarnemingen">Upload waarnemingen bestand: </label><br>
            <input type="file" id="uploadwaarnemingen" name="uploadwaarnemingen" accept="image/*"></p>
        
            <p><label for="hypothese">Hypothese: </label><br>
            <textarea id="hypothese" name="hypothese" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea></p>

            <p><label for="materialen">Materialen: </label><br>
            <textarea id="materialen" name="materialen" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea></p>

            <p><label for="methode">Methode: </label><br>
            <textarea id="methode" name="methode" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea></p>

            <p><label for="uploadmeetresultaten">Upload meetresultaten bestand: </label><br>
            <input type="file" id="uploadmeetresultaten" name="uploadmeetresultaten" accept=".xls,.xlsx,image/*"></p>

            <br>
            


            <p><label for="logboek">Logboek: </label><br>
            <textarea id="logboek" name="logboek" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea></p>
            
            <p><label for="uploadlogboek">Upload logboek bestand: </label><br>
            <input type="file" id="uploadlogboek" name="uploadlogboek" accept=".xls,.xlsx,.doc,.docx"></p>

            <br>

            <p><label for="observaties">Observaties: </label><br>
            <textarea id="observaties" name="observaties" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea></p>
            
            <p><label for="uploadobservaties">Upload observatie bestand: </label><br>
            <input type="file" id="uploadobservaties" name="uploadobservaties" accept="image/*,.doc,.docx"></p>

                <br>

            <p><label for="weeggegevens">Weeggegevens: </label><br>
            <textarea id="weeggegevens" name="weeggegevens" rows="4" cols="50" placeholder="Voer gegevens in..."></textarea></p>
            
            <p><label for="uploadweegegevens">Upload weeggegevens bestand: </label><br>
            <input type="file" id="uploadweeggegevens" name="uploadweeggegevens" accept=".xls,.xlsx"></p>

            <br>

            <p><label for="uploadafbeelding">Upload afbeeldingen: </label><br>
            <input type="file" id="uploadafbeelding" name="uploadafbeelding" accept="image/*" multiple></p>
>>>>>>> Stashed changes


            <label for="Vakken">Vak: *</label>
                    <div name="Vakken">
                        <input type="radio" id="BML" name="LVak" value="BML" checked>
                        <label for="BML">BML</label><br>
                        <input type="radio" id="Chemie" name="LVak" value="Chemie">
                        <label for="Chemie">Chemie</label>
<<<<<<< Updated upstream
                    </div>    

                
                    <br>
                       

            <label for="Jaren">Jaar: *</label>
                    <div name="Jaren">
                        <input type="radio" id="Jaar 1" name="PJaar" value="1" checked>
                        <label for="BML">Jaar 1</label><br>
                        <input type="radio" id="Jaar 2" name="PJaar" value="2">
                        <label for="Chemie">Jaar 2</label><br>
                        <input type="radio" id="Jaar 3" name="PJaar" value="3">
                        <label for="Chemie">Jaar 3</label>
                    </div>

                    <br>
                    <br>

            <input class="bluebtn" type="Submit" id="LSubmit" name="LSubmit" value="Opslaan">

            </form>
        </div>
    </div>
</main>

=======
            
            <p><input type="submit" id="submit" name="submit"></p>

            </form>
>>>>>>> Stashed changes
<?php
    /* Footer */
    include_once '../Include/Footer.php';
?>