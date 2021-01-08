<!DOCTYPE html>
<html>

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
    <link rel="stylesheet" href="../Css/Main.css">
    <link rel="stylesheet" href="../Css/Responsive.css">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Nieuwe Voorbereiding</title>
</head>

<body>
<?PHP
    /* Header */
    include_once '../Include/Header.php';
?>

<main id="Labjournaal">
    <div class="PageTitle">
        <h1>Nieuwe Voorbereiding</h1>
        <hr>
    </div>
    <div class="whitebg">
        <div class="content">
            <?PHP
                if(!empty($_GET['addvoorbereiding']))
                {
                    echo'<div class="bericht">';
                        $addvoorbereiding = $_GET["addvoorbereiding"];
                        if($addvoorbereiding != "failed")
                        {
                            echo'<b>De voorbereiding is opgeslagen.</b><hr>';
                        }
                        else
                        {
                            echo'<b>Niet alle velden zijn ingevuld</b><hr>';
                        }
                    echo'</div>';
                }
            ?>
            <form class="Lform" action="../Pages/addvoorbereiding.inc.php" method="post" enctype="multipart/form-data">
            
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

            <br>
            <br>
            
            <!-- <label for="uploadlogboek">Upload logboek bestand: </label>
            <input type="file" id="uploadlogboek" name="uploadlogboek" accept=".xls,.xlsx,.doc,.docx"> -->

            <br>
            <br>

            <br>
            <br>
			<label for="Vakken">Vak: *</label>
                    <div name="Vakken">
                        <input type="radio" id="BML" name="LVak" value="BML" checked>
                        <label for="BML">BML</label><br>
                        <input type="radio" id="Chemie" name="LVak" value="Chemie">
                        <label for="Chemie">Chemie</label>
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
</main>            

<?php
    /* Footer */
    include_once '../Include/Footer.php';
?>