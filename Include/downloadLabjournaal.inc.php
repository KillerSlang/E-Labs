<?PHP
include_once 'Dbh.inc.php';
if(!empty($_GET['ID']))
{
    $ID = filter_input(INPUT_GET,'ID', FILTER_SANITIZE_SPECIAL_CHARS);
}else{ $ID = 0; }


$sql = 'SELECT labjournaalTitel,uitvoerders,experimentdatum,
experimentBeginDatum,experimentEindDatum,veiligheid,doel,bijlageWaarnemingen,
hypothese,materialen,methode,bijlageMeetresultaten,logboek,bijlageLogboek,
observaties,bijlageObservaties,weeggegevens,bijlageWeeggegevens,
bijlageAfbeelding,vak,jaar
FROM labjournaal
WHERE labjournaalID ='.$ID;

queryAanmaken($sql);

mysqli_stmt_bind_result($stmt, $labjournaalTitel, $uitvoerders, $experimentDatum, $experimentBeginDatum, $experimentEindDatum, 
                        $veiligheid, $doel, $bijlageWaarnemingen, $hypothese, $materialen, $methode, $bijlageMeetresultaten, $logboek,
                        $bijlageLogboek, $observaties, $bijlageObservaties, $weeggegevens, $bijlageWeeggegevens, $bijlageAfbeelding,
                        $vak, $jaar);

mysqli_stmt_store_result($stmt);  
    
                                
while (mysqli_stmt_fetch($stmt)) 
{    }
querySluiten(); 
    require_once __DIR__ . '/vendor/autoload.php';
    $date = date('d-m-y H:i');
    $pdfname = $labjournaalTitel . " " .$date.".pdf";

    // create new pdf
    $mpdf = new \Mpdf\Mpdf();

    // create pdf
    $data = '
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../Css/style.css"> 
            <title>Document</title>
        </head>
        <body>
            <h1>Labjournaal</h1>
            <p>
                <strong>Titel Labjournaal:</strong>
                <br />
                '.$labjournaalTitel.'
            </p>
            <p>
                <strong>Uitvoerders:</strong>
                ';
                $uitvoerdersArray = unserialize(base64_decode($uitvoerders));
                foreach($uitvoerdersArray as $uitvoerder)
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
                <br />
                '.$veiligheid.'
            </p>
            <p>
                <strong>Doel:</strong>
                <br />
                '.nl2br($doel).'
            </p>
            <p>
                <strong>Upload waarnemingen:</strong>
                <br />
                '.$bijlageWaarnemingen.'
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
                <br />
                '.$bijlageMeetresultaten.'
            </p>
            <p>
                <strong>Logboek:</strong>
                <br />
                '.nl2br($logboek).'
            </p>
            <p>
                <strong>Upload logboek:</strong>
                <br />
                '.$bijlageLogboek.'
            </p>
            <p>
                <strong>Observaties:</strong>
                <br />
                '.nl2br($observaties).'
            </p>
            <p>
                <strong>Upload observaties:</strong>
                <br />
                '.$bijlageObservaties.'
            </p>
            <p>
                <strong>Weeggegevens:</strong>
                <br />
                '.nl2br($weeggegevens).'
            </p>
            <p>
                <strong>Upload weeggegevens:</strong>
                <br />
                '.$bijlageWeeggegevens.'
            </p>
            <p>
                <strong>Upload afbeeldingen:</strong>
                <br />
                '.$bijlageAfbeelding.'
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
    ';
    // write pdf
    $mpdf->WriteHTML($data);

    //output to browser
    $mpdf->Output($pdfname, "D");
