<?php
$fromDate ='2012-01-09 23:00:00';
$toDate = '2012-03-01 23:59:59';

$dateMonthYearArr = array();
$fromDateTS = strtotime($fromDate);
$toDateTS = strtotime($toDate);


for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS += (60 * 60 * 24)) {
// use date() and $currentDateTS to format the dates in between
$currentDateStr = date('Y-m-d',$currentDateTS);
$dateMonthYearArr[] = $currentDateStr;
//print $currentDateStr.'<br />';
}

echo  '<pre>';
print_r($dateMonthYearArr);
echo '</pre>';
?>