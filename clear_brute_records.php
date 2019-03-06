<?php
/**
 * Created by PhpStorm.
 * User: Angel
 * Date: 3/5/2019
 * Time: 11:58 PM
 */

/*
set up as cron job to clear brute records daily
for example: 0 	0 	* 	* 	* 	/usr/local/bin/php /home/bleeck/cron/clear_brute.php
*/

require_once 'config.php';
require_once 'db.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "DELETE FROM brute_protection WHERE DATE_TIME < NOW()";
$result = $conn->query($sql);