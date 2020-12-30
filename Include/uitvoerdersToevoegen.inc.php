<?PHP 
$uitvoerders = filter_input(INPUT_POST,'uitvoerders', FILTER_SANITIZE_SPECIAL_CHARS);
echo $uitvoerders;
$sql = ' 
SELECT studentNaam
FROM student
WHERE studentNummer = 
'.$uitvoerders;
echo $sql;