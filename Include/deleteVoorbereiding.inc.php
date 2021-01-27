<?PHP
// functie om een voorbereiding te verwijderen.
session_start();
include_once 'Dbh.inc.php';
$ID = filter_input(INPUT_GET,'ID', FILTER_SANITIZE_SPECIAL_CHARS);
queryAanmaken (
    'DELETE FROM voorbereiding WHERE voorbereiding.voorbereidingID = ? AND studentID = ?',
    "ii",
    $ID,$_SESSION["StudentID"]
);
querySluiten();
header("location: ../Pages/voorbereidingen.php?deleteLabjournaal=succes");  