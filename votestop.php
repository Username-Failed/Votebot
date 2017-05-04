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

$votingResult = mysql_query("SELECT * FROM voting_rounds WHERE in_progress = 1 ORDER BY id DESC LIMIT 1");

$idArray = array();
$nameArray = array();

while($row = mysql_fetch_array($votingResult)) {
    $idArray[] = $row["id"];
    $nameArray[] = $row["name"];
}

echo $idArray['0'];
/*

$voteResult = mysql_query("SELECT * FROM votes WHERE voting_id = " . $idArray['0']);

$voteNum = mysql_num_rows($voteResult);

$sql = "UPDATE voting_rounds SET in_progress = 0 WHERE in_progress = 1";
mysql_query($sql);

$result_json = array('color' => 'purple', 'message' => 'The voting round called "' . $nameArray['0'] . '" have been stopped, Number of votes: ' . $voteNum . ', Average: ', 'notify' => 'false', 'message_format' => 'text');
//headers for not caching the results
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, Jul 26 1997 05:00:00 GMT');
//headers to tell that the result is JSON
header('Content-type: application/json');
//send the result now
echo json_encode($result_json);
*/
mysql_close($dbc);

?>