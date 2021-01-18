<?php
session_start();
include_once '../Include/Dbh.inc.php';
/* verandering van jaar met behulp van een cookie /  jaarselectie*/
    if(isset($_POST['jaar'])) {
        if ($_POST["jaar"] == '1') {
            $_SESSION['jaar'] = "1";
            queryAanmaken('UPDATE student SET jaar = ? WHERE studentID = ?', 'ii', $_SESSION['jaar'], $_SESSION['StudentID']);
            querySluiten();
        }
        if ($_POST["jaar"] == '2') {
            $_SESSION['jaar'] = "2";
            queryAanmaken('UPDATE student SET jaar = ? WHERE studentID = ?', 'ii', $_SESSION['jaar'], $_SESSION['StudentID']);
            querySluiten();
        }
        if ($_POST["jaar"] == '3') {
            $_SESSION['jaar'] = "3";
            queryAanmaken('UPDATE student SET jaar = ? WHERE studentID = ?', 'ii', $_SESSION['jaar'], $_SESSION['StudentID']);
            querySluiten();
        }
       else {
           echo "No Jaar Found";
       }
    }
/* verandering van taal met behulp van een cookie */
    if(isset($_POST['taal'])) {
        if ($_POST['taal'] == "Nederlands") {
            setcookie('taal', "nederlands");
        }
        if ($_POST['taal'] == "English") {
            setcookie('taal', "english");
        }
        header("location:Instellingen.php");
    }
    else {
        echo "No POST found";
    }
?>