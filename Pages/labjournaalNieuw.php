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
?>

<main id="Labjournaal">
    <div class="PageTitle">
        <h1>Nieuw Labjournaal formulier aanmaken</h1>
        <hr>
    </div>
    <div class="whitebg">
        <div class="content">
            <?PHP
                if(isset($_GET['NEW']))
                {
                    $_SESSION ['studentNaamArray'] =  array();
                    $_SESSION ['studentNummerArray'] =  array();
                }
                if(!empty($_GET['addLabjournaal'])||!empty($_GET['adduser'])||!empty($_GET['deleteuser']))
                {
                    echo'<div class="bericht">';
                        if(!empty($_GET['addLabjournaal']))
                        {
                            echo'<b>Niet alle velden zijn ingevuld</b><hr>';
                        }
                        $titelLabjournaal = $_SESSION['titelLabjournaal'];
                        $experimentdatum = $_SESSION['experimentdatum'];
                        $experimentstartdatum = $_SESSION['experimentstartdatum'];
                        $experimenteinddatum = $_SESSION['experimenteinddatum'];
                        $veiligheid = $_SESSION['uploadveiligheid'];
                        $doel = $_SESSION['doel'];
                        $bijlageWaarnemingen = $_SESSION['bijlageWaarnemingen'];
                        $hypothese = $_SESSION['hypothese'];
                        $materialen = $_SESSION['materialen'];
                        $methode = $_SESSION['methode'];
                        $bijlageMeetresultaten = $_SESSION['meetresultaten'];
                        $logboek = $_SESSION['logboek'];
                        $bijlageLogboek = $_SESSION['bijlageLogboek'] ;
                        $observaties = $_SESSION['observaties'];
                        $bijlageObservaties = $_SESSION['bijlageObservaties'];
                        $weeggegevens = $_SESSION['weeggegevens'];
                        $bijlageWeeggegevens =  $_SESSION['bijlageWeeggegevens'];
                        $bijlageAfbeelding = $_SESSION['bijlageAfbeelding'];
                        $vak = $_SESSION['vak'];
                        $jaar = $_SESSION['jaar'];
                    echo'</div>';
                }
                else
                {
                    $titelLabjournaal = "";
                    $uitvoerders = "";
                    $experimentdatum = "";
                    $experimentstartdatum = "";
                    $experimenteinddatum = "";
                    $veiligheid = "";
                    $doel = "";
                    $bijlageWaarnemingen = "";
                    $hypothese = "";
                    $materialen = "";
                    $methode = "";
                    $bijlageMeetresultaten = "";
                    $logboek = "";
                    $bijlageLogboek = "";
                    $observaties = "";
                    $bijlageObservaties = "";
                    $weeggegevens = "";
                    $bijlageWeeggegevens = "";
                    $bijlageAfbeelding = "";
                    $vak = "";
                    $jaar = "";
                }

            
echo '<form class="Lform" action="../Include/addlabjournaal.inc.php" method="post" enctype="multipart/form-data">
            
            <label for="titellabjournaal">Titel labjournaal: * </label>
            <input type="text" id="titellabjournaal" name="titelLabjournaal" value="'.$titelLabjournaal.'" size="40">
            
            <label for="uitvoerders">Uitvoerders: * </label>
            <input type="number" id="uitvoerders" name="uitvoerders" placeholder="studentnummer"  size="40">
            '; 
            if (isset($_SESSION["studentNaamArray"]))
            {
                foreach($_SESSION["studentNaamArray"] as $naam)
                {
                    echo '<input type="text" class="studentInput" value=" '.$naam.'" size="40" readonly/>' ;
                }
            } 
            if(isset($_GET["adduser"]))
            {
                if($_GET["adduser"] == "failed")
                {
                    echo  'Het studentnummer is niet gevonden in de database.' ;
                }
            }
            echo'
            <div id="buttonArea">
                <button class="userToevoegen" type="Submit" id="userSubmit" name="userSubmit">
                    <i class="fas fa-user-plus"> </i>
                </button>
                <button class="userVerwijderen" type="Submit" id="userVerwijderen" name="userVerwijderen">
                    <i class="fas fa-user-minus"> </i>
                </button>
            </div>

            <label for="experimentdatum">Experiment datum: * </label>
            <input type="date" id="experimentdatum" name="experimentdatum" value="'.$experimentdatum.'">

            <label for="experimentstartdatum">Start datum experiment: </label>
            <input type="date" id="experimentstartdatum" name="experimentstartdatum" value="'.$experimentstartdatum.'">

            <label for="experimenteinddatum">Eind datum experiment: </label>
            <input type="date" id="experimenteinddatum" name="experimenteinddatum" value="'.$experimenteinddatum.'">

            <br>

            <label for="uploadveiligheid">Upload veiligheid: </label><p>alleen Excel en afbeeldingen toegestaan</p>
            <input type="file" id="uploadveiligheid" name="uploadveiligheid" accept=".xls,.xlsx,image/*">

            <br>
            <br>

            <label for="doel">Doel: </label>
            <textarea id="doel" name="doel" rows="4" cols="50" placeholder="Voer gegevens in...">'.$doel.'</textarea>

            <br>
            <br>

            <label for="uploadwaarnemingen">Upload waarnemingen bestand: </label><p>alleen afbeeldingen zijn toegestaan</p>
            <input type="file" id="uploadwaarnemingen" name="uploadwaarnemingen" accept="image/*">

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

            <label for="methode">Methode: </label>
            <textarea id="methode" name="methode" rows="4" cols="50" placeholder="Voer gegevens in...">'.$methode.'</textarea>

            <br>
            <br>

            <label for="uploadmeetresultaten">Upload meetresultaten bestand: </label><p>alleen Excel en afbeeldingen toegestaan</p>
            <input type="file" id="uploadmeetresultaten" name="uploadmeetresultaten" accept=".xls,.xlsx,image/*">

            <br>
            <br>
            
            <label for="logboek">Logboek: </label>
            <textarea id="logboek" name="logboek" rows="4" cols="50" placeholder="Voer gegevens in...">'.$logboek.'</textarea>

            <br>
            <br>
            
            <label for="uploadlogboek">Upload logboek bestand: </label><p>alleen Excel en Word bestanden zijn toegestaan</p>
            <input type="file" id="uploadlogboek" name="uploadlogboek" accept=".xls,.xlsx,.doc,.docx">

            <br>
            <br>

            <label for="observaties">Observaties: </label>
            <textarea id="observaties" name="observaties" rows="4" cols="50" placeholder="Voer gegevens in...">'.$observaties.'</textarea>

            <br>
            <br>
            
            <label for="uploadobservaties">Upload observatie bestand: </label><p>alleen afbeeldingen en Word bestanden zijn toegestaan</p>
            <input type="file" id="uploadobservaties" name="uploadobservaties" accept="image/*,.doc,.docx">

            <br>
            <br>

            <label for="weeggegevens">Weeggegevens: </label>
            <textarea id="weeggegevens" name="weeggegevens" rows="4" cols="50" placeholder="Voer gegevens in...">'.$weeggegevens.'</textarea>

            <br>
            <br>
            
            <label for="uploadweegegevens">Upload weeggegevens bestand: </label><p>alleen Excel bestanden zijn toegestaan</p>
            <input type="file" id="uploadweeggegevens" name="uploadweeggegevens" accept=".xls,.xlsx">

            <br>
            <br>

            <label for="uploadafbeelding">Upload afbeeldingen: </label><p>alleen afbeeldingen zijn toegestaan</p>
            <input type="file" id="uploadafbeelding" name="uploadafbeelding" accept="image/*" multiple>

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

    ?>
</main>            

<?php
    /* Footer */
    include_once '../Include/Footer.php';
?>