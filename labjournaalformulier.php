<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Nieuw Labjournaal</title>
</head>
<body>
<?PHP
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
<form action="includes/addlabjournaal.inc.php" method="post">

    <h1>Nieuw Labjournaal aanmaken</h1>

    <h2>Voer data in: </h2>

    <p><label for="titellabjournaal">Titel labjournaal: * </label>
    <input type="text" id="titellabjournaal" name="titelLabjournaal" size="40"></p>

    
    <!-- <label for="gebruiker">Door student: </label>
    <input type="text" name="gebruiker"><br> -->
    
    <br>

    <p><label for="experimentdatum">Experiment datum: * </label>
    <input type="date" id="experimentdatum" name="experimentdatum"></p>

    <p><label for="experimentstartdatum">Start datum experiment: </label>
    <input type="date" id="experimentstartdatum" name="experimentstartdatum"></p>

    <p><label for="experimenteinddatum">Eind datum experiment: </label>
    <input type="date" id="experimenteinddatum" name="experimenteinddatum"></p>

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

    <br>

    <p><input type="submit" id="submit" name="submit"></p>



</form>
