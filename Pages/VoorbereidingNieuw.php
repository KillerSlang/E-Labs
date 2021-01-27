<!DOCTYPE html>
<html lang="en">

    <head>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/cda83c7af3.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="../Css/Main.css">
        <link rel="shortcut icon" type="image/png" href="../Images/favicon.png"/>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <?php
            if($_COOKIE['taal'] == 'english') {
                echo "<title>New Preperation</title>";
            }
            else{
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
            <h1><?=$VoorbereidingNieuwFormulierAanmaken?></h1>
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
                
                <label>'.$VoorbereidingTiteltekst.': </label>
                <input type="text" id="titelvoorbereiding" name="titelvoorbereiding" placeholder="'.$Titel.'" value="'.$titelvoorbereiding.'">
                
                <label>'.$VoorbereidingUitvoerder.': </label>
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
                        echo  ''.$Studentnummernietgevondenindatabase.'.' ;
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

                <label for="voorbereidingsdatum">'.$Voorbereidingdatumtekst.': </label>
            <input type="date" id="voorbereidingsdatum" name="voorbereidingsdatum" placeholder="dd/mm/yyyy" value="'.$voorbereidingsdatum.'">

            <br/>
            
            <label for="uitvoeringsdatum">'.$VoorbereidingUitvoeringDatum.': *</label>
            <input type="date" id="uitvoeringsdatum" name="uitvoeringsdatum" placeholder="dd/mm/yyyy" value="'.$uitvoeringsdatum.'">
            
            <br/>

            <label for="uploadtheorie">'.$VoorbereidingUploadTheorie.': </label><p>'.$AlleenAfbeeldingenEnWord.'</p>
            <input type="file" id="uploadtheorie" name="uploadtheorie" accept=".docx,.doc,image/*"> 

            <br>
            <br>

            <label for="benodigdeFormules">'.$VoorbereidingBenodigdeFormules.': </label>
            <textarea id="benodigdeFormules" name="benodigdeFormules" class="autoresizingNieuw" placeholder="'.$LabGegevens.'" >'.$benodigdeFormules.'</textarea>

            <br>
            <br>

            <label >'.$VoorbereidingInstellingenApparaten.': </label>
            <textarea id="instellingenapparaten" name="instellingenapparaten" class="autoresizingNieuw" placeholder="'.$LabGegevens.'" >'.$InstellingenApparaten.'</textarea>

            <br>
            <br>
            
            <label for="doel">'.$VoorbereidingDoel.': </label>
            <textarea id="doel" name="doel" class="autoresizingNieuw" placeholder="'.$LabGegevens.'">'.$doel.'</textarea>

            <br>
            <br>

            <label>'.$VoorbereidingHypothese.': </label>
            <textarea  id="hypothese" name="hypothese" class="autoresizingNieuw" placeholder="'.$LabGegevens.'" >'.$hypothese.'</textarea>

            <br>
            <br>
            
            <label for="materialen">'.$VoorbereidingMaterialen.': </label>
            <textarea  id="materialen" name="materialen" class="autoresizingNieuw" placeholder="'.$LabGegevens.'" >'.$materialen.'</textarea>

            <br>
            <br>

            <label>'.$VoorbereidingUploadMaterialen.': </label><p>'.$AlleenExcel.'</p>
            <input type="file" id="uploadmaterialen" name="uploadmaterialen" accept=".xls,.xlsx">
 
            <br>
            <br>
        
            <label>'.$VoorbereidingMethode.': </label>
            <textarea id="methode" name="methode" class="autoresizingNieuw" placeholder="'.$LabGegevens.'" >'.$methode.'</textarea>

            <br>
            <br>

            <label>'.$VoorbereidingUploadMethode.': </label><p>'.$AlleenExcel.'</p>
            <input type="file" id="uploadmethode" name="uploadmethode" accept=".xls,.xlsx">

            <br>
            <br>

            <label>'.$VoorbereidingVeiligheid.': </label>
            <textarea  id="veiligheid" name="veiligheid" class="autoresizingNieuw" placeholder="'.$LabGegevens.'">'.$veiligheid.'</textarea>
            
            <br>
            <br>
            
            <label>'.$VoorbereidingUploadVeiligheid.': </label><p>'.$AlleenAfbeeldingenEnExcel.'</p>
            <input type="file" id="uploadveiligheid" name="uploadveiligheid" accept="image/*,.xls,.xlsx">

            <br>
            <br>
            

            <label>'.$VoorbereidingVoorbereidendeVragen.': </label>
            <textarea id="voorbereidendevragen" name="voorbereidendevragen" class="autoresizingNieuw" placeholder="'.$LabGegevens.'" >'.$voorbereidendevragen.'</textarea>

            <br>
            <br>
            

            <label>'.$VoorbereidingUploadVoorbereidendeVragen.': </label><p>'.$AlleenAfbeeldingenEnExcelEnWord.'</p>
            <input type="file" id="uploadvoorbereidendevragen" name="uploadvoorbereidendevragen" accept=".xls,.xlsx,.doc,.docx,image/*">

            <br>
            <br>
           
            <br>
            <br>
                <label>'.$Vak.': </label>
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