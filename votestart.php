<?php
/*
Edit the config.php.template file before you can use this script
 */

$configDone = false;

include("config.php");

if($configDone == false) {
    echo "Error: Config File not made";
    exit();
}

if ($dbc = mysql_connect(DBHOST, DBUSER, DBPW)) {

    if(!mysql_select_db(DBNAME)) {
        trigger_error("Could not select the database!<br />MySQL Error: " . mysql_error());
        exit();
    }
} else {
    trigger_error("Could not connect to MySQL!<br />MySQL Error: " . mysql_error());
    exit();
}

$stopSql = "UPDATE voting_rounds SET in_progress = 0 WHERE in_progress = 1";
mysql_query($stopSql);

//headers for not caching the results
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
//headers to tell that the result is JSON
header('Content-type: application/json');
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array
$receivedMessage = $input["item"] ["message"] ["message"];
$inputArray = explode(' ', $receivedMessage, 2);

if(empty($inputArray['1'])) {
    $nameOfRound = "Voting round without specific name";
} else {
    $nameOfRound = $inputArray['1'];
}

$sql = "INSERT INTO voting_rounds (id, name, average, in_progress) VALUES (NULL, '" . $nameOfRound . "', NULL, '1');";
mysql_query($sql);

$result_json = array('color' => 'purple', 'message' => 'A voting round called "' . $nameOfRound . '" has been started, use /vote # to vote, where # is 1, 2, 3, 4 or 5. (e.g. /vote 5)<br />Use /votestop to stop the round.', 'notify' => 'false', 'message_format' => 'text');
//send the result now
echo json_encode($result_json);

mysql_close($dbc);
?>