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

//headers for not caching the results
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
//headers to tell that the result is JSON
header('Content-type: application/json');
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, TRUE); //convert JSON into array
$receivedMessage = $input["item"] ["message"] ["message"];
$inputArray = explode(' ', $receivedMessage, 2);

$sql = "INSERT INTO voting_rounds (id, name, average, in_progress) VALUES (NULL, '" . $inputArray['1'] . "', NULL, '1');";
mysql_query($sql);

$result_json = array('color' => 'purple', 'message' => 'A voting round called ' . $inputArray['1'] . ' has been started, use /vote # to vote', 'notify' => 'false', 'message_format' => 'text');
//send the result now
echo json_encode($result_json);

mysql_close($dbc);
?>