<?PHP
/* functie om een pdf te printen van een voorbereiding. */
include_once 'Dbh.inc.php';
if(!empty($_GET['ID']))
{
    $ID = filter_input(INPUT_GET,'ID', FILTER_SANITIZE_SPECIAL_CHARS);
}else{ $ID = 0; }

queryAanmaken(
    'SELECT voorbereidingTitel,uitvoerders,voorbereidingdatum,
    uitvoeringDatum,theorie,benodigdeFormules,InstellingenApparaten,doel,hypothese,materialen,
    methode,veiligheid,voorbereidendeVragen,vak,jaar
    FROM voorbereiding
    WHERE voorbereidingID = ?'
    ,"i",$ID    
); // vraag alle gegevens op van de database.
mysqli_stmt_bind_result($stmt, $voorbereidingTitel, $uitvoerders, $voorbereidingdatum, $uitvoeringDatum, $uploadtheorie, $benodigdeFormules, 
                        $InstellingenApparaten, $doel, $hypothese, $materialen, $methode, $veiligheid, $voorbereidendeVragen,
                        $vak, $jaar); // bind de resultaten
mysqli_stmt_store_result($stmt);  // sla de resultaten op.                                
while (mysqli_stmt_fetch($stmt)) 
{    }
/* maak de while statement aan en sluit deze.
omdat er altijd maar 1 resultaat is wordt deze meteen gesloten zodat de database connectie
weer kan worden gebruikt. */
querySluiten(); 
    require_once __DIR__ . '/vendor/autoload.php'; // voeg de library toe om de functies van mpdf uit te voeren.
    $date = date('d-m-y HH:MM'); // vraag de datum met tijd aan om toe te voegen aan de naam van de pdf.
    $pdfname = $voorbereidingTitel . " " .$date.".pdf"; // naam van de pdf
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
                <strong>Titel experiment:</strong>
                <br />
                '.$voorbereidingTitel.'
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
                <strong>Voorbereiding datum:</strong>
                <br />
                '.$voorbereidingdatum.'
            </p>
            <p>
                <strong>Uitvoerings Datum:</strong>
                <br />
                '.$uitvoeringDatum.'
            </p>

            <p>
                <strong>Benodigde formules:</strong>
                <br />
                '.nl2br($benodigdeFormules).'
            </p>
            <p>
                <strong>Instellingen apparaten:</strong>
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
                <strong>Methode:</strong>
                <br />
                '.nl2br($methode).'
            </p>  
            uploadbestand?
            <p>
                <strong>Veiligheid:</strong>
                <br />
                '.nl2br($veiligheid).'
            </p> 
            uploadbestand?
            <p>
                <strong>Voorbereidende vragen:</strong>
                <br />
                '.nl2br($voorbereidendeVragen).'
            </p>   
            uploadbestand?
                $data.='<a class="downloadLink" " target="_blank" href="'.$bijlageLogboek.'">'.$bijlageLogboek.'</a>';
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
        </body>
    </html>
    ';  
    // maak het pdf.
    $mpdf->WriteHTML($data);

    //voer de pdf uit in je browser.
    $mpdf->Output($pdfname, "D");
