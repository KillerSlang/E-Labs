<!DOCTYPE html>
<html lang="en">

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
                    if(isset($_GET['NEW']))//wanneer je van de overzichtpagina komt moeten de arrays van de uitvoerders leeg zijn.
                    {
                        $_SESSION ['studentNaamArray'] =  array();
                        $_SESSION ['studentNummerArray'] =  array();
                    }
                    if(!empty($_GET['addLabjournaal'])||!empty($_GET['adduser'])||!empty($_GET['deleteuser']))//als je vanuit een include bestand terug komt. 
                    {
                        echo'<div class="bericht">';
                            if(!empty($_GET['addLabjournaal']))
                            {
                                echo'<b>Niet alle velden zijn ingevuld</b><hr>';
                            }
                            $titelLabjournaal = $_SESSION['titelLabjournaal']; // vul de variabelen vanuit de sessie.
                            $experimentdatum = $_SESSION['experimentdatum'];
                            $experimentstartdatum = $_SESSION['experimentstartdatum'];
                            $experimenteinddatum = $_SESSION['experimenteinddatum'];
                            $doel = $_SESSION['doel'];
                            $hypothese = $_SESSION['hypothese'];
                            $materialen = $_SESSION['materialen'];
                            $methode = $_SESSION['methode'];
                            $logboek = $_SESSION['logboek'];
                            $observaties = $_SESSION['observaties'];
                            $weeggegevens = $_SESSION['weeggegevens'];
                            $vak = $_SESSION['vak'];
                        echo'</div>';
                    }
                    else // wanneer je niet vanuit een include komt maar van de overzichtpagina schrijf alle variabelen leeg.
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
                    }

                
    echo '<form class="Lform" action="../Include/addlabjournaal.inc.php" method="post" enctype="multipart/form-data">
                
                <label>Titel experiment: * </label>
                <input type="text" id="titellabjournaal" name="titelLabjournaal" value="'.$titelLabjournaal.'">
                
                <label>Uitvoerders: * </label>
                <input type="number" id="uitvoerders" name="uitvoerders" placeholder="studentnummer">
                '; 
                if (isset($_SESSION["studentNaamArray"])) //wanneer studentnaamArray bestaat.
                {
                    foreach($_SESSION["studentNaamArray"] as $naam) //print elke waarde vanuit de array uit
                    {
                        echo '<input type="text" class="studentInput" value=" '.$naam.'" readonly/>' ;
                    }
                } 
                if(isset($_GET["adduser"])) // adduser in de get is.
                {
                    if($_GET["adduser"] == "failed") // en deze failed terug geeft.
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

                <label>Experiment datum: * </label>
                <input type="date" id="experimentdatum" name="experimentdatum" placeholder="dd/mm/yyyy" value="'.$experimentdatum.'">

                <label>Start datum experiment: </label>
                <input type="date" id="experimentstartdatum" name="experimentstartdatum" placeholder="dd/mm/yyyy" value="'.$experimentstartdatum.'">

                <label>Eind datum experiment: </label>
                <input type="date" id="experimenteinddatum" name="experimenteinddatum" placeholder="dd/mm/yyyy" value="'.$experimenteinddatum.'">

                <br>

                <label>Upload veiligheid: </label><p>alleen Excel en afbeeldingen toegestaan</p>
                <input type="file" id="uploadveiligheid" name="uploadveiligheid" accept=".xls,.xlsx,image/*">

                <br>
                <br>

                <label>Doel: </label>
                <textarea name="doel" class="autoresizingNieuw" placeholder="Voer gegevens in...">'.$doel.'</textarea>

                <br>
                <br>

                <label>Upload waarnemingen bestand: </label><p>alleen afbeeldingen zijn toegestaan</p>
                <input type="file" id="uploadwaarnemingen" name="uploadwaarnemingen" accept="image/*">

                <br>
                <br>
            
                <label>Hypothese: </label>
                <textarea name="hypothese" class="autoresizingNieuw" placeholder="Voer gegevens in...">'.$hypothese.'</textarea>

                <br>
                <br>

                <label>Materialen: </label>
                <textarea name="materialen" class="autoresizingNieuw" placeholder="Voer gegevens in...">'.$materialen.'</textarea>

                <br>
                <br>

                <label>Methode: </label>
                <textarea  name="methode" class="autoresizingNieuw" placeholder="Voer gegevens in...">'.$methode.'</textarea>

                <br>
                <br>

                <label>Upload meetresultaten bestand: </label><p>alleen Excel en afbeeldingen toegestaan</p>
                <input type="file" id="uploadmeetresultaten" name="uploadmeetresultaten" accept=".xls,.xlsx,image/*">

                <br>
                <br>
                
                <label>Logboek: </label>
                <textarea name="logboek" class="autoresizingNieuw" placeholder="Voer gegevens in...">'.$logboek.'</textarea>

                <br>
                <br>
                
                <label>Upload logboek bestand: </label><p>alleen Excel en Word bestanden zijn toegestaan</p>
                <input type="file" id="uploadlogboek" name="uploadlogboek" accept=".xls,.xlsx,.doc,.docx">

                <br>
                <br>

                <label>Observaties: </label>
                <textarea name="observaties" class="autoresizingNieuw" placeholder="Voer gegevens in...">'.$observaties.'</textarea>

                <br>
                <br>
                
                <label>Upload observatie bestand: </label><p>alleen afbeeldingen en Word bestanden zijn toegestaan</p>
                <input type="file" id="uploadobservaties" name="uploadobservaties" accept="image/*,.doc,.docx">

                <br>
                <br>

                <label>Weeggegevens: </label>
                <textarea name="weeggegevens" class="autoresizingNieuw" placeholder="Voer gegevens in...">'.$weeggegevens.'</textarea>

                <br>
                <br>
                
                <label>Upload weeggegevens bestand: </label><p>alleen Excel bestanden zijn toegestaan</p>
                <input type="file" id="uploadweeggegevens" name="uploadweeggegevens" accept=".xls,.xlsx">

                <br>
                <br>

                <label>Upload afbeeldingen: </label><p>alleen afbeeldingen zijn toegestaan</p>
                <input type="file" id="uploadafbeelding" name="uploadafbeelding" accept="image/*" multiple>

                <br>
                <br>
                <label>Vak: *</label>
                        <div id="Vakken">';
                            if ($vak == "BML")
                            {
                                echo'
                                <input type="radio" name="LVak" value="BML" checked>
                                <label>BML</label><br>
                                <input type="radio" name="LVak" value="Chemie">
                                <label>Chemie</label>';
                            }
                            else
                            {
                                echo'
                                <input type="radio" name="LVak" value="BML">
                                <label>BML</label><br>
                                <input type="radio" name="LVak" value="Chemie" checked>
                                <label>Chemie</label>';
                            }
                echo ' 
                        </div>    
                        <br><br>

                <input class="bluebtn" type="Submit" id="LSubmit" name="LSubmit" value="Opslaan">
        </form>';
        ?>
    </div>
    </div>
    </main>
    <script type="text/javascript"> // functie dat de tekstvakken op de pagina automatisch groter worden.
        textarea = document.querySelectorAll(".autoresizingNieuw");
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
</html>