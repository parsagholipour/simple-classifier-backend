<?php
header("Content-Type: text/event-stream");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header("Access-Control-Allow-Headers: X-Requested-With");
echo 'data: {"event":"start"}', "\n\n";
while (ob_get_level() > 0) {
    ob_end_flush();
}
flush();
chdir('/home/maghsoudloo');
$imageName = $_GET['image_name'];
$time_start = microtime(true);
$result =  shell_exec('/bin/bash ./env2/mycodes/script.bash ' . $imageName);
$time_end = microtime(true);
$execution_time = number_format($time_end - $time_start, 2);
/*
 * Formatting
 */
$result = explode(' ', $result);
$object = '';
for ($i = 0; $i < count($result) - 1; $i++) {
    $object .= ' ' . $result[$i];
}
$object = trim($object);
$possibility = number_format($result[count($result) - 1], 2);
echo "data: {\"event\":\"done\", \"result\": {\"object\": \"{$object}\", \"possibility\": \"{$possibility}\", \"time\": {$execution_time}}}", "\n\n";
