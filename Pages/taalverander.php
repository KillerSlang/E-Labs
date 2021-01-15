<?php
session_start();
/* verandering van jaar met behulp van een cookie /  jaarselectie*/
    if(isset($_POST['jaar'])) {
        if ($_POST["jaar"] == '1') {
            $_SESSION['jaar'] = "1";
            $query = "INSERT INTO student (jaar) 1 ('$_POST[jaar]')";
        }
        if ($_POST["jaar"] == '2') {
            $_SESSION['jaar'] = "2";
            $query = "INSERT INTO student (jaar) 2 ('$_POST[jaar]')";
        }
        if ($_POST["jaar"] == '3') {
            $_SESSION['jaar'] = "3";
            $query = "INSERT INTO student (jaar) 3 ('$_POST[jaar]')";
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