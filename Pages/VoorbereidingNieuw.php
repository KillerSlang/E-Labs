<!DOCTYPE html>
<html lang="en">

    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="../Css/Main.css">
        <link rel="stylesheet" href="../Css/Responsive.css">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <?php
        if($_COOKIE['taal'] == 'english') {
            echo "<title>New Preparations</title>";
        }else {
            echo "<title>Nieuwe Voorbereiding</title>";
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
            <h1>Nieuw Voorbereiding formulier aanmaken</h1>
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
                            $titelvoorbereiding = $_SESSION['titelvoorbereiding'];
                            $voorbereidingsdatum = $_SESSION['voorbereidingsdatum'];
                            $uitvoeringsdatum = $_SESSION['uitvoeringsdatum'];
                            $benodigdeFormules = $_SESSION['benodigdeFormules'];
                            $InstellingenApparaten = $_SESSION['InstellingenApparaten'];
                            $hypothese = $_SESSION['hypothese'];
                            $materialen = $_SESSION['materialen'];
                            $methode = $_SESSION['methode'];
                            $veiligheid = $_SESSION['veiligheid'];
                            $voorbereidendevragen = $_SESSION['voorbereidendevragen'];
                            $vak = $_SESSION['vak'];
                            $doel = $_SESSION['doel'];
                        echo'</div>';
                    }
                    else // wanneer je niet vanuit een include komt maar van de overzichtpagina schrijf alle variabelen leeg.
                    {
                        $titelvoorbereiding = "";
                        $uitvoerders = "";
                        $voorbereidingsdatum = "";
                        $benodigdeFormules = "";
                        $InstellingenApparaten = "";
                        $hypothese = "";
                        $materialen = "";
                        $methode = "";
                        $veiligheid = "";
                        $voorbereidendevragen = "";
                        $vak = "";
                        $doel = "";
                        $uitvoeringsdatum = "";
                    }

                
    echo '<form class="Lform" action="../Include/addvoorbereiding.inc.php" method="post" enctype="multipart/form-data">
                
                <label>Titel experiment: * </label>
                <input type="text" id="titelvoorbereiding" name="titelvoorbereiding" value="'.$titelvoorbereiding.'">
                
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
                        <i class="fa fa-user-plus"> </i>
                    </button>
                    <button class="userVerwijderen" type="Submit" id="userVerwijderen" name="userVerwijderen">
                        <i class="fa fa-user-times"> </i>
                    </button>
                </div>

                <label for="voorbereidingsdatum">Voorbereidings datum: * </label>
            <input type="date" id="voorbereidingsdatum" name="voorbereidingsdatum" placeholder="dd/mm/yyyy" value="'.$voorbereidingsdatum.'">

            </br>
            
            <label for="uitvoeringsdatum">Uitvoerings datum: *</label>
            <input type="date" id="uitvoeringsdatum" name="uitvoeringsdatum" placeholder="dd/mm/yyyy" value="'.$uitvoeringsdatum.'">
            
            </br>

            <label for="uploadtheorie">Upload theorie: </label><p>Alleen afbeeldingen en word</p>
            <input type="file" id="uploadtheorie" name="uploadtheorie" accept=".docx,.doc,image/*"> 

            <br>
            <br>

            <label for="benodigdeFormules">Benodigde formules: </label>
            <textarea id="benodigdeFormules" class="autoresizingNieuw" name="benodigdeFormules" rows="4" cols="50" placeholder="Voer gegevens in..." value="'.$benodigdeFormules.'"></textarea>

            <br>
            <br>

            <label for="InstellingenApparaten">Instellingen apparaten: </label>
            <textarea id="instellingenapparaten" class="autoresizingNieuw" name="instellingenapparaten" rows="4" cols="50" placeholder="Voer gegevens in..." value="'.$InstellingenApparaten.'"></textarea>

            <br>
            <br>
            
            <label for="doel">Doel: </label>
            <textarea id="doel" class="autoresizingNieuw" name="doel" rows="4" cols="50" placeholder="Voer gegevens in..." value="'.$doel.'"></textarea>

            <br>
            <br>

            <label for="Hypothese">Hypothese: </label>
            <textarea id="hypothese" class="autoresizingNieuw" name="hypothese" rows="4" cols="50" placeholder="Voer gegevens in..." value="'.$hypothese.'"></textarea>

            <br>
            <br>
            
            <label for="materialen">Materialen: </label>
            <textarea id="materialen" class="autoresizingNieuw" name="materialen" rows="4" cols="50" placeholder="Voer gegevens in..." value="'.$materialen.'"></textarea>

            <br>
            <br>

            <label>Upload Materialen bestand: </label><p>Alleen excel</p>
            <input type="file" id="uploadmaterialen" name="uploadmaterialen" accept=".xls,.xlsx">
 
            <br>
            <br>
        
            <label for="Methode">Methode: </label>
            <textarea id="methode" class="autoresizingNieuw" name="methode" rows="4" cols="50" placeholder="Voer gegevens in..." value="'.$methode.'"></textarea>

            <br>
            <br>

            <label>Upload methode bestand: </label><p>Alleen excel</p>
            <input type="file" id="uploadmethode" name="uploadmethode" accept=".xls,.xlsx">

            <br>
            <br>

            <label for="Veiligheid">Veiligheid: </label>
            <textarea id="veiligheid" class="autoresizingNieuw" name="veiligheid" rows="4" cols="50" placeholder="Voer gegevens in..." value="'.$veiligheid.'"></textarea>
            
            <br>
            <br>
            
            <label>Upload veiligheid bestand: </label><p>Alleen afbeeldingen en excel</p>
            <input type="file" id="uploadveiligheid" name="uploadveiligheid" accept="image/*,.xls,.xlsx">

            <br>
            <br>
            

            <label for="Voorbereidendevragen">Voorbereidende vragen: </label>
            <textarea id="voorbereidendevragen" class="autoresizingNieuw" name="voorbereidendevragen" rows="4" cols="50" placeholder="Voer gegevens in..." value="'.$voorbereidendevragen.'"></textarea>

            <br>
            <br>
            

            <label>Upload voorbereidende vragen bestand: </label><p>Alleen afbeeldingen, excel, en word</p>
            <input type="file" id="uploadvoorbereidendevragen" name="uploadvoorbereidendevragen" accept=".xls,.xlsx,.doc,.docx,image/*">

            <br>
            <br>
           
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