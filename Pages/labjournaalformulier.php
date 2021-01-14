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
?>

<main id="Labjournaal">
    <div class="PageTitle">
        <h1><?=$LabjournaalNieuwFA?></h1>
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
            ?>
            <form class="Lform" action="../Include/addlabjournaal.inc.php" method="post" enctype="multipart/form-data">
            
            <label for="titellabjournaal"><?=$LabjournaalTitel?>: * </label>
            <input type="text" id="titellabjournaal" name="titelLabjournaal" size="40">
            
            <label for="uitvoerders"><?=$LabjournaalUitvoerder?>: * </label>
            <input type="text" id="uitvoerders" name="uitvoerders" size="40">

            <br>

            <label for="experimentdatum"><?=$LabjournaalDatum?>: * </label>
            <input type="date" id="experimentdatum" name="experimentdatum">

            <label for="experimentstartdatum"><?=$LabjournaalDatumS?>: </label>
            <input type="date" id="experimentstartdatum" name="experimentstartdatum">

            <label for="experimenteinddatum"><?=$LabjournaalDatumE?>: </label>
            <input type="date" id="experimenteinddatum" name="experimenteinddatum">

            <br>

            <label for="uploadveiligheid"><?=$LabjournaalVeiligheid?>: </label>
            <input type="file" id="uploadveiligheid" name="uploadveiligheid" accept=".docx">

            <br>
            <br>

            <label for="doel"><?=$LabjournaalDoel?>: </label>
            <textarea id="doel" name="doel" rows="4" cols="50" placeholder=<?=$LabGegevens?>></textarea>

            <br>
            <br>

            <label for="uploadwaarnemingen"><?=$LabjournaalWaarneming?>: </label>
            <input type="file" id="uploadwaarnemingen" name="uploadwaarnemingen" accept="image/*">

            <br>
            <br>
        
            <label for="hypothese"><?=$LabjournaalHypothese?>: </label>
            <textarea id="hypothese" name="hypothese" rows="4" cols="50" placeholder=<?=$LabGegevens?>></textarea>

            <br>
            <br>

            <label for="materialen"><?=$LabjournaalMateriaal?>: </label>
            <textarea id="materialen" name="materialen" rows="4" cols="50" placeholder=<?=$LabGegevens?>></textarea>

            <br>
            <br>

            <label for="methode"><?=$LabjournaalMethode?>: </label>
            <textarea id="methode" name="methode" rows="4" cols="50" placeholder=<?=$LabGegevens?>></textarea>

            <br>
            <br>

            <label for="uploadmeetresultaten"><?=$LabjournaalMeetR?>: </label>
            <input type="file" id="uploadmeetresultaten" name="uploadmeetresultaten" accept=".xls,.xlsx,image/*">

            <br>
            <br>
            
            <label for="logboek"><?=$LabjournaalLogboek?>: </label>
            <textarea id="logboek" name="logboek" rows="4" cols="50" placeholder=<?=$LabGegevens?>></textarea>

            <br>
            <br>
            
            <label for="uploadlogboek"><?=$LabjournaalLogboekU?>: </label>
            <input type="file" id="uploadlogboek" name="uploadlogboek" accept=".xls,.xlsx,.doc,.docx">

            <br>
            <br>

            <label for="observaties"><?=$LabjournaalObservatie?>: </label>
            <textarea id="observaties" name="observaties" rows="4" cols="50" placeholder=<?=$LabGegevens?>></textarea>

            <br>
            <br>
            
            <label for="uploadobservaties"><?=$LabjournaalObservatieU?>: </label>
            <input type="file" id="uploadobservaties" name="uploadobservaties" accept="image/*,.doc,.docx">

            <br>
            <br>

            <label for="weeggegevens"><?=$LabjournaalWeeg?>: </label>
            <textarea id="weeggegevens" name="weeggegevens" rows="4" cols="50" placeholder=<?=$LabGegevens?>></textarea>

            <br>
            <br>
            
            <label for="uploadweegegevens"><?=$LabjournaalWeegU?>: </label>
            <input type="file" id="uploadweeggegevens" name="uploadweeggegevens" accept=".xls,.xlsx">

            <br>
            <br>

            <label for="uploadafbeelding"><?=$LabjournaalImg?>: </label>
            <input type="file" id="uploadafbeelding" name="uploadafbeelding" accept="image/*" multiple>

            <br>
            <br>
			<label for="Vakken"><?=$Vak?>: *</label>
                    <div name="Vakken">
                        <input type="radio" id="BML" name="LVak" value="BML" checked>
                        <label for="BML">BML</label><br>
                        <input type="radio" id="Chemie" name="LVak" value="Chemie">
                        <label for="Chemie"><?=$Chemie?></label>
                    </div>    

                
                    <br>
                       

            <label for="Jaren"><?=$Jaar?>: *</label>
                    <div name="Jaren">
                        <input type="radio" id="Jaar 1" name="PJaar" value="1" checked>
                        <label for="BML"><?=$Jaar1?></label><br>
                        <input type="radio" id="Jaar 2" name="PJaar" value="2">
                        <label for="Chemie"><?=$Jaar2?></label><br>
                        <input type="radio" id="Jaar 3" name="PJaar" value="3">
                        <label for="Chemie"><?=$Jaar3?></label>
                    </div>

                    <br>
                    <br>

            <input class="bluebtn" type="Submit" id="LSubmit" name="LSubmit" value=<?=$Opslaan?>>
        </div>   
    </form>
</main>            

<?php
    /* Footer */
    include_once '../Include/Footer.php';
?>