<?php
  function queryAanmaken ($query)
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

    $sql = $query;
    $GLOBALS ['stmt'] = mysqli_prepare($GLOBALS['conn'], $sql) or DIE("Preparation error"); // is het een werkende query
    mysqli_stmt_execute($GLOBALS ['stmt']) or DIE(mysqli_error($GLOBALS['conn']));
    function querySluiten ()
    {
        mysqli_stmt_close($GLOBALS ['stmt']);
        mysqli_close($GLOBALS['conn']);
    }
  }
  
// bind result kun je gewoon met $stmt aanroepen zie hieronder voor voorbeelden.
/* titel van labjournalen en loboeken van studentID 1 ophalen.
    queryAanmaken('SELECT `labjournaalTitel`,`logboek` 
                   FROM `labjournaal` 
                   WHERE `studentID` = 1;');
    mysqli_stmt_bind_result($stmt, $titelLabjournaal, $logboek);
    mysqli_stmt_store_result($stmt);
    if(mysqli_stmt_num_rows($stmt) != 0)
    {
        echo "Labjournalen en logboeken van studentID 1 <hr />";
        while(mysqli_stmt_fetch($stmt))
        {
            echo $titelLabjournaal."&nbsp; &nbsp;". $logboek."<br />";
        }
    }
    querySluiten();
*/
/* titellabjournal van studentID 1 en docentID 1 toevoegen.
    $titelLabjournaal =  filter_input(INPUT_POST,'titelLabjournaal', FILTER_SANITIZE_SPECIAL_CHARS); 
    queryAanmaken('INSERT INTO labjournaal(studentID,docentID,labjournaalTitel)
    VALUES ("1","1","'.$titelLabjournaal.'");');
    querySluiten();
*/