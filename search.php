<?php

$max = 500; 

#$phototext = 'Has photo';
$phototext = '<img src="photo.png" height="14" align="bottom"/>';

# Using a simple templating library, mustache, which is implemented in about a dozen different languages.
# php mustache is from bobthecow....
include('Mustache.php');
$template = file_get_contents('search.mustache');

$con = mysql_connect ("<server>", "<login>","<password>")  or die (mysql_error());

$datesort = $_POST['dsort'];
$term = $_POST['term'];  
$startdate = $_POST['startdate'];
$enddate = $_POST['enddate'];

$view = array();
$view['datesort'] = $datesort;
$view['term'] = $term;
$view['startdate'] = $startdate;
$view['enddate'] = $enddate;

$results = array();

mysql_select_db("ncs",$con);

$sql = mysql_query("
	select * from ncsi
	where
	sdate between '$startdate' and '$enddate'
	and
	(headline like '%$term%'
	or
	subject like '%$term%'
	or
	columntitle like '%$term%'
	or
	author like '%$term%')
	order by sdate $datesort, page asc, author asc, headline asc;
	");
$count = 0;

while ($row = mysql_fetch_array($sql)){
	$count++;
	if(isset($_POST['photo']) && $_POST['photo'] == 'Yes') {
		if ($row['photo'] == '') {
			$count--;
			continue;
		}
	}

	if ($row['photo'] == 'yes') {
		$row['photo'] = $phototext;
	}

	array_push($results, array(
		'count' => $count,
		'headline' => $row['headline'],
		'newspaper' => $row['newspaper'],
		'date' => $row['date'],
		'page' => $row['page'],
		'photo' => $row['photo'],
		'subject' => $row['subject'],
		'columntitle' => $row['columntitle']
	));
	if ($count > $max) {
		unset($results);
		$view['maxout'] = true;
		$count = "Over " . $max;
		break;
	}
}


$view['count'] = $count;
$view['results'] = $results;



$m = new Mustache;

echo $m->render($template, $view);



?>
