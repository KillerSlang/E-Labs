<?PHP
// functie om een labjournaal te verwijderen.
session_start();
include_once 'Dbh.inc.php';
$ID = filter_input(INPUT_GET,'ID', FILTER_SANITIZE_SPECIAL_CHARS);
queryAanmaken (
    'DELETE FROM labjournaal WHERE labjournaal.labjournaalID = ? AND studentID = ?',
    "ii",
    $ID,$_SESSION["StudentID"]
);
querySluiten();
header("location: ../Pages/labjournalen.php?deleteLabjournaal=succes");  