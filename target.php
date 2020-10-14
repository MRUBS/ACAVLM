<?php
$py = 100000.00;
$feb = 10000.00;
$may = 20000.00;
$perc = 15/100;
$month = 6/12;
$yeartotal = $feb + $may;
$target = $py + ($py*$month)*$perc;
$target += $feb + ((($feb * $perc) / 12) * 4);//4 months from june
$target += $may + ((($may * $perc) / 12) * 1);//1 month from june
//$target = $yeartotal * $perc;
echo($target);
?>