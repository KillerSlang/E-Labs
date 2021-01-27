<!DOCTYPE html>
<html lang="en">

    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="../Css/Main.css">
        <link rel="shortcut icon" type="image/png" href="../Images/favicon.png"/>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php
        if($_COOKIE['taal'] == 'english') {
            echo "<title>New Experiment</title>";
        }
        else{
            echo "<title>Nieuw Labjournaal</title>";
        }
        ?>
        
    </head> 

    <body>
    <?PHP
        /* Header */
        include_once '../Include/Header.php';
    ?>

    <main id="Labjournaal">
        <div class="PageTitle">
            <h1><?=$LabjournaalNieuwFA?></h1>
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
                                echo'<b>'.$Nietalleveldeningevuld.'</b><hr>';
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
                
                <label>'.$LabjournaalTitel.': </label>
                <input type="text" id="titellabjournaal" name="titelLabjournaal" placeholder="'.$Titel.'" value="'.$titelLabjournaal.'">
                
                <label>'.$LabjournaalUitvoerder.': </label>
                <input type="number" id="uitvoerders" name="uitvoerders" placeholder="'.$StudentNummer.'">
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
                        echo  ''.$Studentnummernietgevondenindatabase.'';
                    }
                }
                echo'
                <div id="buttonArea">
                    <button class="userToevoegen" type="Submit" name="userSubmit">
                        <i class="fa fa-user-plus"> </i>
                    </button>
                    <button class="userVerwijderen" type="Submit" name="userVerwijderen">
                        <i class="fa fa-user-times"> </i>
                    </button>
                </div>

                <label>'.$LabjournaalDatum.': </label>
                <input type="date" id="experimentdatum" name="experimentdatum" value="'.$experimentdatum.'">

                <label>'.$LabjournaalDatumS.': </label>
                <input type="date" id="experimentstartdatum" name="experimentstartdatum" value="'.$experimentstartdatum.'">

                <label>'.$LabjournaalDatumE.': </label>
                <input type="date" id="experimenteinddatum" name="experimenteinddatum" value="'.$experimenteinddatum.'">

                <br>

                <label>'.$LabjournaalVeiligheid.': </label><p>'.$AlleenAfbeeldingenEnExcel.'</p>
                <input type="file" id="uploadveiligheid" name="uploadveiligheid" accept=".xls,.xlsx,image/*">

                <br>
                <br>

                <label>'.$LabjournaalDoel.': </label>
                <textarea name="doel" class="autoresizingNieuw" placeholder="'.$LabGegevens.'">'.$doel.'</textarea>

                <br>
                <br>

                <label>'.$LabjournaalWaarneming.': </label><p>'.$AlleenAfbeeldingen.'</p>
                <input type="file" id="uploadwaarnemingen" name="uploadwaarnemingen" accept="image/*">

                <br>
                <br>
            
                <label>'.$LabjournaalHypothese.': </label>
                <textarea name="hypothese" class="autoresizingNieuw" placeholder="'.$LabGegevens.'">'.$hypothese.'</textarea>

                <br>
                <br>

                <label>'.$LabjournaalMateriaal.': </label>
                <textarea name="materialen" class="autoresizingNieuw" placeholder="'.$LabGegevens.'">'.$materialen.'</textarea>

                <br>
                <br>

                <label>'.$LabjournaalMethode.': </label>
                <textarea  name="methode" class="autoresizingNieuw" placeholder="'.$LabGegevens.'">'.$methode.'</textarea>

                <br>
                <br>

                <label>'.$LabjournaalMeetR.': </label><p>'.$AlleenAfbeeldingenEnExcel.'</p>
                <input type="file" id="uploadmeetresultaten" name="uploadmeetresultaten" accept=".xls,.xlsx,image/*">

                <br>
                <br>
                
                <label>'.$LabjournaalLogboek.': </label>
                <textarea name="logboek" class="autoresizingNieuw" placeholder="'.$LabGegevens.'">'.$logboek.'</textarea>

                <br>
                <br>
                
                <label>'.$LabjournaalLogboekU.': </label><p>'.$AlleenAfbeeldingenEnExcel.'</p>
                <input type="file" id="uploadlogboek" name="uploadlogboek" accept=".xls,.xlsx,.doc,.docx">

                <br>
                <br>

                <label>'.$LabjournaalObservatie.': </label>
                <textarea name="observaties" class="autoresizingNieuw" placeholder="'.$LabGegevens.'">'.$observaties.'</textarea>

                <br>
                <br>
                
                <label>'.$LabjournaalObservatieU.': </label><p>'.$AlleenAfbeeldingenEnWord.'</p>
                <input type="file" id="uploadobservaties" name="uploadobservaties" accept="image/*,.doc,.docx">

                <br>
                <br>

                <label>'.$LabjournaalWeeg.': </label>
                <textarea name="weeggegevens" class="autoresizingNieuw" placeholder="'.$LabGegevens.'">'.$weeggegevens.'</textarea>

                <br>
                <br>
                
                <label>'.$LabjournaalWeegU.': </label><p>'.$AlleenExcel.'</p>
                <input type="file" id="uploadweeggegevens" name="uploadweeggegevens" accept=".xls,.xlsx">

                <br>
                <br>

                <label>'.$LabjournaalImg.': </label><p>'.$AlleenAfbeeldingen.'</p>
                <input type="file" id="uploadafbeelding" name="uploadafbeelding" accept="image/*" multiple>

                <br>
                <br>
                <label>'.$Vak.': *</label>
                        <div id="Vakken">';
                            if ($vak == "BML")
                            {
                                echo'
                                <input type="radio" name="LVak" value="BML" checked>
                                <label>'.$BML.'</label><br>
                                <input type="radio" name="LVak" value="Chemie">
                                <label>'.$Chemie.'</label>';
                            }
                            else
                            {
                                echo'
                                <input type="radio" name="LVak" value="BML">
                                <label>'.$BML.'</label><br>
                                <input type="radio" name="LVak" value="Chemie" checked>
                                <label>'.$Chemie.'</label>';
                            }
                echo ' 
                        </div>    
                        <br><br>

                <input class="bluebtn" type="Submit" id="LSubmit" name="LSubmit" value="'.$Opslaan.'">
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