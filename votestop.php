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

//echo $idArray['0'];

$voteResult = mysql_query("SELECT * FROM votes WHERE voting_id = " . $idArray['0']);

$voteNum = mysql_num_rows($voteResult);

$voteArray = array();

while($row = mysql_fetch_array($voteResult)) {
    $voteArray[] = $row["vote"];
}

$voteTotal = 0;
$numberOf1 = 0;
$numberOf2 = 0;
$numberOf3 = 0;
$numberOf4 = 0;
$numberOf5 = 0;

foreach($voteArray as $value) {
    $voteTotal = $voteTotal + $value;

    if($value == 1) { $numberOf1++; }
    if($value == 2) { $numberOf2++; }
    if($value == 3) { $numberOf3++; }
    if($value == 4) { $numberOf4++; }
    if($value == 5) { $numberOf5++; }

}

$average = $voteTotal / $voteNum;

$voteAverage = round($average, 1, PHP_ROUND_HALF_UP);

//echo $voteNum;

mysql_query("UPDATE voting_rounds SET average = " . $voteAverage . " WHERE in_progress = 1 ORDER BY id DESC LIMIT 1");

$sql = "UPDATE voting_rounds SET in_progress = 0 WHERE in_progress = 1";
mysql_query($sql);

$result_json = array('color' => 'purple', 'message' => 'The voting round called "' . $nameArray['0'] . '" have been stopped<br />Number of votes: ' . $voteNum . '<br />Average: ' . $voteAverage . '<br />Number of ones: ' . $numberOf1 . '<br />Number of twos: ' . $numberOf2 . '<br />Number of threes: ' . $numberOf3 . '<br />Number of fours: ' . $numberOf4 . '<br />Number of fives: ' . $numberOf5, 'notify' => 'false', 'message_format' => 'html');
//headers for not caching the results
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, Jul 26 1997 05:00:00 GMT');
//headers to tell that the result is JSON
header('Content-type: application/json');
//send the result now
echo json_encode($result_json);

mysql_close($dbc);

?>