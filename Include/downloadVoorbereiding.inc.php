<?PHP
/* functie om een pdf te printen van een voorbereiding. */
include_once 'Dbh.inc.php';
if(!empty($_GET['ID']))
{
    $ID = filter_input(INPUT_GET,'ID', FILTER_SANITIZE_SPECIAL_CHARS);
}else{ $ID = 0; }

queryAanmaken(
    'SELECT voorbereidingTitel,voorbereidingDatum,materialen,methode,hypothese,
    instellingenApparaten,voorbereidendeVragen,veiligheid,vak,uitvoerders,
    uitvoeringsDatum,benodigdeFormules,jaar,bijlageTheorie,bijlageMaterialen,
    bijlageMethode,bijlageVeiligheid,bijlageVoorbereidendevragen,doel,docentID,beoordeling
    FROM voorbereiding
    WHERE voorbereidingID = ?'
    ,"i",$ID    
); // vraag alle gegevens op van de database.
mysqli_stmt_bind_result($stmt, $titelvoorbereiding,$voorbereidingsdatum,$materialen,$methode,$hypothese,
                        $InstellingenApparaten,$voorbereidendevragen,$veiligheid,$vak,$uitvoerders,$uitvoeringsdatum,$benodigdeFormules,
                        $jaar,$bijlageTheorie,$bijlageMaterialen,$bijlageMethode,$bijlageVeiligheid,$bijlageVoorbereidendevragen,
                        $doel,$docent,$beoordeling); // bind de resultaten
mysqli_stmt_store_result($stmt);  // sla de resultaten op.                                
while (mysqli_stmt_fetch($stmt)) 
{    }
/* maak de while statement aan en sluit deze.
omdat er altijd maar 1 resultaat is wordt deze meteen gesloten zodat de database connectie
weer kan worden gebruikt. */
querySluiten(); 

//haal docent naam op
if(!empty($docent))
{
    queryAanmaken(
    'SELECT docentNaam
     FROM docent
     WHERE docentID = ?
    ',
    "i",
    $docent
    );
    mysqli_stmt_bind_result($stmt, $docentNaam);
    mysqli_stmt_store_result($stmt);
    while (mysqli_stmt_fetch($stmt)) 
    {    }
    querySluiten();

 }; 

    require_once __DIR__ . '/vendor/autoload.php'; // voeg de library toe om de functies van mpdf uit te voeren.
    $date = date('d-m-y HH:MM'); // vraag de datum met tijd aan om toe te voegen aan de naam van de pdf.
    $pdfname = $titelvoorbereiding . " " .$date.".pdf"; // naam van de pdf
    // maak nieuw pdf aan.
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->showImageErrors = true; // deze is toegevoegd zodat er afbeeldingen kunnen worden getoond.
 
    $data = '
    <html>
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../Css/style.css"> 
            <title>Document</title>
        </head>
        <body>
            <h1>Voorbereiding</h1>
            <p>
                <strong>Titel voorbereiding:</strong>
                <br />
                '.$titelvoorbereiding.'
            </p>
            <p>
                <strong>Uitvoerders:</strong>
                ';
                $uitvoerdersArray = unserialize(base64_decode($uitvoerders)); // zet de uitvoerders vanuit de database weer om in een array.
                foreach($uitvoerdersArray as $uitvoerder) // voor elke waarde print de studentnaam uit.
                {
                    queryAanmaken(
                        'SELECT studentNaam
                        FROM student
                        WHERE studentNummer = '.$uitvoerder);
                    mysqli_stmt_bind_result($stmt, $studentNaam);
                    mysqli_stmt_store_result($stmt);
                    while (mysqli_stmt_fetch($stmt)) 
                    {
                        $data.= '<br> &nbsp; &nbsp; &nbsp;- '.$studentNaam;
                    }
                    querySluiten();
                } 
    $data.= '
            </p>
            <p>
                <strong>Voorbereidings datum:</strong>
                <br />
                '.$voorbereidingsdatum.'
            </p>
            <p>
                <strong>Start datum experiment:</strong>
                <br />
                '.$uitvoeringsdatum.'
            </p>
            
            <p>

                <strong>Upload Theorie:</strong>
                <br />';
                if(!empty($bijlageTheorie)){
                    $extension = explode(".", $bijlageTheorie);
                    if ($extension[3] == "jpg" || $extension[3] == "jpeg" || $extension[3] == "png"){
                        $data.= '<img src="'.$bijlageTheorie.'" width=30% height=30%/>';
                    }
                    else
                    {
                        $data.='<a class="downloadLink" target="_blank" href="'.$bijlageTheorie.'">'.$bijlageTheorie.'</a>';
                    }  
                } else {
                    $data.='Geen bestand geupload.';
                }
    $data.='
            </p>
            <p>
                <strong>Benodigde Formules: </strong>
                <br />
                '.nl2br($benodigdeFormules).'
            </p>
            <p>
                <strong>InstellingenApparaten:</strong>
                <br />
                '.nl2br($InstellingenApparaten).'
            </p>
            <p>
                <strong>Doel:</strong>
                <br />
                '.nl2br($doel).'
            </p>
            <p>
                <strong>Hypothese:</strong>
                <br />
                '.nl2br($hypothese).'
            </p>
            <p>
                <strong>Materialen:</strong>
                <br />
                '.nl2br($materialen).'
            </p>
            <p>
                <strong>Upload Materialen:</strong>
                <br />';
                if(!empty($bijlageMaterialen)){
                    $extension = explode(".", $bijlageMaterialen);
                    if ($extension[3] == "jpg" || $extension[3] == "jpeg" || $extension[3] == "png"){
                        $data.= '<img src="'.$bijlageMaterialen.'" width=30% height=30%/>';
                    }
                    else
                    {
                        $data.='<a class="downloadLink"  target="_blank" href="'.$bijlageMaterialen.'">'.$bijlageMaterialen.'</a>';
                    }  
                } else {
                    $data.='Geen bestand geupload.';
                }
    $data.='
            </p>
            <p>
                <strong>Methode:</strong>
                <br />
                '.nl2br($methode).'
            </p>
            <p>
                <strong>Upload Methode:</strong>
                <br />';
                if(!empty($bijlageMethode)){
                    $extension = explode(".", $bijlageMethode);
                    if ($extension[3] == "jpg" || $extension[3] == "jpeg" || $extension[3] == "png"){
                        $data.= '<img src="'.$bijlageMethode.'" width=30% height=30%/>';
                    }
                    else
                    {
                        $data.='<a class="downloadLink"  target="_blank" href="'.$bijlageMethode.'">'.$bijlageMethode.'</a>';
                    }  
                } else {
                    $data.='Geen bestand geupload.';
                }
    $data.='
            </p>
            <p>
                <strong>Veiligheid:</strong>
                <br />
                '.nl2br($veiligheid).'
            </p>
            <p>
                <strong>Upload Veiligheid:</strong>
                <br />';
                if(!empty($bijlageVeiligheid)){
                    $extension = explode(".", $bijlageVeiligheid);
                    if ($extension[3] == "jpg" || $extension[3] == "jpeg" || $extension[3] == "png"){
                        $data.= '<img src="'.$bijlageVeiligheid.'" width=30% height=30%/>';
                    }
                    else
                    {
                        $data.='<a class="downloadLink"  target="_blank" href="'.$bijlageVeiligheid.'">'.$bijlageVeiligheid.'</a>';
                    }  
                } else {
                    $data.='Geen bestand geupload.';
                }
    $data.='
            </p>
            <p>
                <strong>Voorbereidende vragen: :</strong>
                <br />
                '.nl2br($voorbereidendevragen).'
            </p>
            <p>
                <strong>Upload Voorbereidendevragen:</strong>
                <br />';
                if(!empty($bijlageVoorbereidendevragen)){
                    $extension = explode(".", $bijlageVoorbereidendevragen);
                    if ($extension[3] == "jpg" || $extension[3] == "jpeg" || $extension[3] == "png"){
                        $data.= '<img src="'.$bijlageVoorbereidendevragen.'" width=30% height=30%/>';
                    }
                    else
                    {
                        $data.='<a class="downloadLink"  target="_blank" href="'.$bijlageVoorbereidendevragen.'">'.$bijlageVoorbereidendevragen.'</a>';
                    }  
                } else {
                    $data.='Geen bestand geupload.';
                }
    $data.='
            </p>
            
            <p>
                <strong>Vak:</strong>
                <br />
                '.$vak.'
            </p>
            <p>
                <strong>Jaar:</strong>
                <br />
                '.$jaar.'
            </p>
            <p>
                <strong>Cijfer:</strong>
                <br />
                '.$beoordeling.'
            </p>
            <p>
                <strong>Beoordeeld door:</strong>
                <br />
                '.$docentNaam.'
            </p>
        </body>
    </html>
    ';  
    
    // maak het pdf.
    $mpdf->WriteHTML($data);

    //voer de pdf uit in je browser.
    $mpdf->Output($pdfname, "D");
