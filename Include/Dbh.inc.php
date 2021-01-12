<?php
/* functies om de database connectie te vereenvoudigen met de functie queryAanmaken kan er een sql statement worden ingezet.
Wanneer er vraagtekens in de sql statement zitten kun je deze binden d.m.v. de variabele types en bindparameter. De variabele
types is voor de datatypes dus bijvoorbeeld "i" voor integer en de bind parameter kun je de variabelen van de vraagtekens meegeven.
De advanced functie wordt gebruikt om door de code heen een query op te bouwen. Wanneer de variabele send true is wordt de query pas verstuurd.*/

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
  function queryAanmakenAdvanced ($sql,$send,$types = "",...$bindParameters) 
  {
    if(empty($_SESSION['sql'])) // wanneer er nog geen sessie bestaat maak deze aan.
    {
      $_SESSION['sql'] = $sql;
      $_SESSION['types'] = $types;
      $_SESSION['bindParameters'] = array();
      foreach($bindParameters as $input)
      {
        array_push($_SESSION ['bindParameters'],$input);
      }
    }
    else // anders voeg de waarde van de variabelen toe.
    {
      $_SESSION['sql'] .= $sql;
      $_SESSION['types'] .= $types;
      foreach($bindParameters as $input)
      {
        array_push($_SESSION ['bindParameters'],$input);
      }
    }
    if($send)//wanneer send true is verstuur de query naar de database en schrijf de sessies leeg.
    { 
      $sql = $_SESSION['sql'];      
      $types =  $_SESSION['types'];
      $bindParameters = $_SESSION['bindParameters'];
      $_SESSION['sql'] = "";
      $_SESSION['types'] = "";
      $_SESSION['bindParameters'] = array();
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
  }
  function querySluiten () // sluit de connectie met de database.
  {
    mysqli_stmt_close($GLOBALS['stmt']);
    mysqli_close($GLOBALS['conn']);
  }
  
