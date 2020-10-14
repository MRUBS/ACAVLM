<?php
header("Content-type: application/csv");
header("Content-Disposition: attachment; filename=".$filename);
header("Pragma: no-cache");
header("Expires: 0");

//echo $data;
outputCSV($data);

function outputCSV($data) {
    $outstream = fopen("php://output", 'w');
    function __outputCSV(&$vals, $key, $filehandler) {
        fputcsv($filehandler, $vals); // add parameters if you want
    }
    array_walk($data, '__outputCSV', $outstream);
    fclose($outstream);
}

?>