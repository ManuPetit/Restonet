<?php
//		graph_test.php
//permet l'affichage d'un graphique

$tick = $max /4;

$chart = new GoogleChart('bvs', 400, 200);
$chart->setMargin(20,20,20,20);
//data
$data = new GoogleChartData( $values);
$data -> setColor($colorgraph);
$data->setAutoscale(TRUE);
$chart -> addData($data);
$chart -> setTitle($titlegraph);

//y axis
$y_axis = new GoogleChartAxis('y');
$y_axis -> setDrawTickMarks(false);
$y_axis -> setLabels(array(0,number_format($tick,2,',',''),number_format($tick*2,2,',',''),number_format($tick*3,2,',',''),number_format($max,2,',','')));
$chart -> addAxis($y_axis);

//x axis
$x_axis = new GoogleChartAxis('x');
$x_axis -> setTickMarks(5);
$x_axis -> setLabels(array('Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jui', 'Jui', 'Aou', 'Sep', 'Oct', 'Nov', 'Dec'));
$chart -> addAxis($x_axis);

echo $chart -> toHtml();
?>

