<?php
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
        echo "No GET found";
    }
?>