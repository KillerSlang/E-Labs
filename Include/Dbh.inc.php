<?php
/* functies om de database connectie te vereenvoudigen met de functie queryAanmaken kan er een sql statement worden ingezet.
Wanneer er vraagtekens in de sql statement zitten kun je deze binden d.m.v. de variabele types en bindparameter. De variabele
types is voor de datatypes dus bijvoorbeeld "i" voor integer en de bind parameter kun je de variabelen van de vraagtekens meegeven.*/
  function queryAanmaken ($sql,$types = "",...$bindParameters) 
  {
     // instellingen.
    $dbServername= "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "elabs";
    $GLOBALS['conn'] = mysqli_connect($dbServername,$dbUsername, $dbPassword,$dbName); 
    if(!$GLOBALS['conn']) //wanneer de connectie niet werkt.
    {
      DIE("Could not connect". mysqli_error($GLOBALS['conn']));
    }  
    $GLOBALS ['stmt'] = mysqli_prepare($GLOBALS['conn'], $sql) or DIE("Preparation error"); // is het een werkende query
    if(!empty($types))// wanneer er een type is ingevuld. 
    {
        mysqli_stmt_bind_param($GLOBALS ['stmt'],$types,...$bindParameters); //zet de types voor de parameters en bind de parameter die gegeven zijn. 
    }
    mysqli_stmt_execute($GLOBALS ['stmt']) or DIE(mysqli_error($GLOBALS['conn'])); // execute de sql statement.

  }
  function querySluiten () // sluit de connectie met de database.
  {
    mysqli_stmt_close($GLOBALS['stmt']);
    mysqli_close($GLOBALS['conn']);
  }
  
