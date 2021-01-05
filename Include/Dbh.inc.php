<?php
  function queryAanmaken ($sql)
  {
    $dbServername= "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "elabs";
    $GLOBALS['conn'] = mysqli_connect($dbServername,$dbUsername, $dbPassword,$dbName);
    if(!$GLOBALS['conn'])
    {
      DIE("Could not connect". mysqli_error($GLOBALS['conn']));
    }  
    $GLOBALS ['stmt'] = mysqli_prepare($GLOBALS['conn'], $sql) or DIE("Preparation error"); // is het een werkende query
    mysqli_stmt_execute($GLOBALS ['stmt']) or DIE(mysqli_error($GLOBALS['conn']));

  }
  function querySluiten ()
  {
    mysqli_stmt_close($GLOBALS['stmt']);
    mysqli_close($GLOBALS['conn']);
  }
  
