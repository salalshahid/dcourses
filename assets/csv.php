<?php
include "connect.php";
if (isset($_GET['export']) && !empty($_GET['export'])) {

$ctable = $_GET['ctable'];
$start_id = $_GET['startid'];
$end_id = $_GET['endid'];
$limit  = $_GET['limit'];
set_time_limit($limit);
header('Content-Type: text/csv');
$bfile = 'backup_'.date('Y-m-d__H-i-s');
header('Content-Disposition: attachment;filename='.$bfile.'.csv');

//SQL Query for Data
$sql = "SELECT * FROM $ctable WHERE id BETWEEN $start_id and $end_id LIMIT $limit;";
//Prepare Query, Bind Parameters, Excute Query
$STH = $db->prepare($sql);
$STH->execute();

//Export to .CSV
$fp = fopen('php://output', 'w');

// first set
$first_row = $STH->fetch(PDO::FETCH_ASSOC);
$headers = array_keys($first_row);
fputcsv($fp, $headers); // put the headers
fputcsv($fp, array_values($first_row)); // put the first row

while ($row = $STH->fetch(PDO::FETCH_NUM))  {
fputcsv($fp,$row); // push the rest
}
fclose($fp);
}

?>
