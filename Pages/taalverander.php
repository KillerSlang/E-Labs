<?php
/* verandering van jaar met behulp van een cookie /  jaarselectie*/
    if(isset($_POST['jaar'])) {
        if ($_POST["jaar"] == '1') {
            setcookie('jaar', "1");
        }
        if ($_POST["jaar"] == '2') {
            setcookie('jaar', "2");
        }
        if ($_POST["jaar"] == '3') {
            setcookie('jaar', "3");
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