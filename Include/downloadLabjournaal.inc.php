<?PHP
/* functie om een pdf te printen van een labjournaal. */
include_once 'Dbh.inc.php';
if(!empty($_GET['ID']))
{
    $ID = filter_input(INPUT_GET,'ID', FILTER_SANITIZE_SPECIAL_CHARS);
}else{ $ID = 0; }

queryAanmaken(
    'SELECT labjournaalTitel,uitvoerders,experimentdatum,
    experimentBeginDatum,experimentEindDatum,veiligheid,doel,bijlageWaarnemingen,
    hypothese,materialen,methode,bijlageMeetresultaten,logboek,bijlageLogboek,
    observaties,bijlageObservaties,weeggegevens,bijlageWeeggegevens,
    bijlageAfbeelding,vak,jaar
    FROM labjournaal
    WHERE labjournaalID = ?'
    ,"i",$ID    
); // vraag alle gegevens op van de database.
mysqli_stmt_bind_result($stmt, $labjournaalTitel, $uitvoerders, $experimentDatum, $experimentBeginDatum, $experimentEindDatum, 
                        $veiligheid, $doel, $bijlageWaarnemingen, $hypothese, $materialen, $methode, $bijlageMeetresultaten, $logboek,
                        $bijlageLogboek, $observaties, $bijlageObservaties, $weeggegevens, $bijlageWeeggegevens, $bijlageAfbeelding,
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
    $pdfname = $labjournaalTitel . " " .$date.".pdf"; // naam van de pdf
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
            <h1>Labjournaal</h1>
            <p>
                <strong>Titel experiment:</strong>
                <br />
                '.$labjournaalTitel.'
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
                <strong>Experiment datum:</strong>
                <br />
                '.$experimentDatum.'
            </p>
            <p>
                <strong>Start datum experiment:</strong>
                <br />
                '.$experimentBeginDatum.'
            </p>
            <p>
                <strong>Einddatum experiment:</strong>
                <br />
                '.$experimentEindDatum.'
            </p>
            <p>
                <strong>Upload  veiligheid:</strong>
                <br />';
                if(!empty($veiligheid)){
                    $extension = explode(".", $veiligheid);
                    if ($extension[3] == "jpg" || $extension[3] == "jpeg" || $extension[3] == "png"){
                        $data.= '<img src="'.$veiligheid.'" width=30% height=30%/>';
                    }
                    else
                    {
                        $data.='<a class="downloadLink" " target="_blank" href="'.$veiligheid.'">'.$veiligheid.'</a>';
                    }  
                } else {
                    $data.='Geen bestand geupload.';
                }
    $data.='
            </p>
            <p>
                <strong>Doel:</strong>
                <br />
                '.nl2br($doel).'
            </p>
            <p>
                <strong>Upload waarnemingen:</strong>
                <br />';
                if(!empty($bijlageWaarnemingen)){
                    $data.='<img src="'.$bijlageWaarnemingen.'" width=30% height=30%/>';
                } else {
                    $data.='Geen bestand geupload.';
                }
    $data.='
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
            <p>
                <strong>Upload meetresultaten:</strong>
                <br />';
                if(!empty($bijlageMeetresultaten)){
                    $extension = explode(".", $bijlageMeetresultaten);
                    if ($extension[3] == "jpg" || $extension[3] == "jpeg" || $extension[3] == "png"){
                        $data.= '<img src="'.$bijlageMeetresultaten.'" width=30% height=30%/>';
                    }
                    else
                    {
                        $data.='<a class="downloadLink" " target="_blank" href="'.$bijlageMeetresultaten.'">'.$bijlageMeetresultaten.'</a>';
                    }  
                } else {
                    $data.='Geen bestand geupload.';
                }
    $data.='
            </p>
            <p>
                <strong>Logboek:</strong>
                <br />
                '.nl2br($logboek).'
            </p>
            <p>
                <strong>Upload logboek:</strong>
                <br />';
                if(!empty($bijlageLogboek)){
                    $data.='<a class="downloadLink" " target="_blank" href="'.$bijlageLogboek.'">'.$bijlageLogboek.'</a>';
                } else {
                    $data.='Geen bestand geupload.';
                }
    $data.='
            </p>
            <p>
                <strong>Observaties:</strong>
                <br />
                '.nl2br($observaties).'
            </p>
            <p>
                <strong>Upload observaties:</strong>
                <br />';
                if(!empty($bijlageObservaties)){
                    $extension = explode(".", $bijlageObservaties);
                    if ($extension[3] == "jpg" || $extension[3] == "jpeg" || $extension[3] == "png"){
                        $data.= '<img src="'.$bijlageObservaties.'" width=30% height=30%/>';
                    }
                    else
                    {
                        $data.='<a class="downloadLink" " target="_blank" href="'.$bijlageObservaties.'">'.$bijlageObservaties.'</a>';
                    }  
                } else {
                    $data.='Geen bestand geupload.';
                }
    $data.='
            </p>
            <p>
                <strong>Weeggegevens:</strong>
                <br />
                '.nl2br($weeggegevens).'
            </p>
            <p>
                <strong>Upload weeggegevens:</strong>
                <br />';
                if(!empty($bijlageWeeggegevens)){
                    $data.='<a class="downloadLink" " target="_blank" href="'.$bijlageWeeggegevens.'">'.$bijlageWeeggegevens.'</a>';
                } else {
                    $data.='Geen bestand geupload.';
                }
    $data.='
            </p>
            <p>
                <strong>Upload afbeeldingen:</strong>
                <br />';
                if(!empty($bijlageAfbeelding)){
                    $data.='<img src="'.$bijlageAfbeelding.'" width=30% height=30%/>';
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
        </body>
    </html>
    ';  
    // maak het pdf.
    $mpdf->WriteHTML($data);

    //voer de pdf uit in je browser.
    $mpdf->Output($pdfname, "D");
