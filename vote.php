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



//echo "cheatMessage:|" . $cheatMessage . "|";
if (!(isset($_GET["message"]))) {
    $receivedMessage = $input["item"] ["message"] ["message"];
} else {
    $cheatMessage = $_GET["message"];
    $receivedMessage = $cheatMessage;
}

$inputArray = explode(' ', $receivedMessage, 2);

$votingResult = mysql_query("SELECT * FROM voting_rounds WHERE in_progress = 1 ORDER BY id DESC LIMIT 1");

$idArray = array();
$nameArray = array();

while($row = mysql_fetch_array($votingResult)) {
    $idArray[] = $row["id"];
    $nameArray[] = $row["name"];
}



if(mysql_num_rows($votingResult) == 0) {
    $result_json = array('color' => 'purple', 'message' => 'No voting round in progress, use /votestart [name] to start', 'notify' => 'false', 'message_format' => 'text');
    //send the result now
    echo json_encode($result_json);
} else {
    $n = $inputArray['1'];
    if(!($n == "1" || $n == "2" || $n == "3" || $n == "4" || $n == "5")) {
        $result_json = array('color' => 'purple', 'message' => 'Use a number between 1 and 5 to vote', 'notify' => 'false', 'message_format' => 'text');
    }   else {
        $result_json = array('color' => 'purple', 'message' => 'Thanks for your vote, you voted ' . $inputArray['1'] . ' for "' . $nameArray['0'] . '"', 'notify' => 'false', 'message_format' => 'text');
        //$sql = "INSERT INTO votes (id, voting_id, vote) VALUES (NULL, '" . $idArray['0'] .  "', '" . $inputArray['1'] . "');";
        //mysql_query($sql);
    }
    echo json_encode($result_json);
}

/*

$votingId = [id];

if(1 == 1) {
    $n = $inputArray['1'];
    if(!($n == "1" || $n == "2" || $n == "3" || $n == "4" || $n == "5")) {
        $result_json = array('color' => 'purple', 'message' => 'Use a number between 1 and 5 to vote with', 'notify' => 'false', 'message_format' => 'text');
    }   else {
        $result_json = array('color' => 'purple', 'message' => 'Thanks for your vote, you voted ' . $inputArray['1'] . ' for ' . [name], 'notify' => 'false', 'message_format' => 'text');
        $sql = "INSERT INTO votes (id, voting_id, vote) VALUES (NULL, '" . $votingId .  "', '" . $inputArray['1'] . "');";
        mysql_query($sql);
    }
    //send the result now
    echo json_encode($result_json);
} else {
    $result_json = array('color' => 'purple', 'message' => 'No voting round in progress, use /votestart [name] to start', 'notify' => 'false', 'message_format' => 'text');
    //send the result now
    echo json_encode($result_json);
}
*/
mysql_close($dbc);
?>