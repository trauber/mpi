<?php

$max = 500; 

#$phototext = 'Has photo';
$phototext = '<img src="photo.png" height="14" align="bottom"/>';

# Using a simple templating library, mustache, which is implemented in about a dozen different languages.
# php mustache is from bobthecow....
include('Mustache.php');


# rendering function.
function mrender($t,$v) {
	$m = new Mustache;
	echo $m->render($t, $v);
	exit;
}


# Found a nice date checker snippet at php.net!!
function datecheck($input) {
	$date_format = 'Y-m-d';
	$input = trim($input);
	$time = strtotime($input);
	$is_valid = date($date_format, $time) == $input;

	if (!($is_valid)) {
		$template = file_get_contents('exception.mustache');
		$view['exception'] = "$input is not valid.  Dates must be in the form: YYYY-MM-DD. Example: 1973-04-08.  Dates must also be real.";
		mrender($template, $view);
	}
}



# This is the results template.
# For exceptions use a different one.
# And make it something simple, with a return link to the search form
# and a one scalar view.
$template = file_get_contents('search.mustache');

$con = mysql_connect ("127.0.0.1", "root","7he2@7@sp12")  or die (mysql_error());

$datesort = $_POST['dsort'];
$term = $_POST['term'];  
$startdate = $_POST['startdate'];
$enddate = $_POST['enddate'];
$paper = $_POST['paper'];

datecheck($startdate);
datecheck($enddate);


if (strlen($term) > 100) {
	$template = file_get_contents('exception.mustache');
	$view['exception'] = "You must shorten your search term.  It is over 100 characters.";
	mrender($template, $view);
}




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

	if(isset($_POST['photo']) && $_POST['photo'] == 'Yes') {
		if ($row['photo'] == '') {
			continue;
		}
	}

	if ($row['photo'] == 'yes') {
		$row['photo'] = $phototext;
	}

	foreach($paper as $k=>$v) {
		if(isset($paper[$k])) {
			$count++;
			if ($row['newspaper'] != $v) {
				$count--;
				continue;
			} else {

			array_push($results, array(
			'headline' => $row['headline'],
			'newspaper' => $row['newspaper'],
			'date' => $row['date'],
			'page' => $row['page'],
			'photo' => $row['photo'],
			'subject' => $row['subject'],
			'columntitle' => $row['columntitle'],
			'count' => $count
			));
			}
		}

	}



	if ($count > $max) {
		unset($results);
		$template = file_get_contents('exception.mustache');
		$view['exception'] = "Your search returned more than $max results.  Please refine it.";
		mrender($template, $view);

	}
}


$view['count'] = $count;
$view['results'] = $results;

mrender($template, $view);

?>
