<?php
$result = array(
	'columns' => array(
		array('key' => 'Num', 'label' => 'Number', 'type' => 'Number'),
		array('key' => 'Picture', 'label' => 'Picture', 'type' => 'Image'),
		array('key' => 'Name', 'label' => 'Name', 'type' => 'String'),
		array('key' => 'Pos', 'label' => 'Position', 'type' => 'String'),
		array('key' => 'Height', 'label' => 'Height', 'type' => 'String'),
		array('key' => 'Weight', 'label' => 'Weight', 'type' => 'Number'),
		array('key' => 'Birthday', 'label' => 'Birthday', 'type' => 'String'),
		array('key' => 'Years', 'label' => 'Years', 'type' => 'Number')
	),
	'items' => array(
		array("Num" => 32, "Picture" => "http://stats.nba.com/media/players/230x185/201933.png", "Name" => "Blake Griffin", "Pos" => "F", "Height" => "6-10", "Weight" => 251, "Birthday" => "03/16/1989", "Years" => "4"),
		array("Num" => 9, "Picture" => "http://stats.nba.com/media/players/230x185/203099.png", "Name" => "Jared Cunningham", "Pos" => "SG", "Height" => "6-4", "Weight" => 194, "Birthday" => "05/22/1991", "Years" => "2"),
		array("Num" => 6, "Picture" => "http://stats.nba.com/media/players/230x185/201599.png", "Name" => "DeAndre Jordan", "Pos" => "C", "Height" => "6-11", "Weight" => 250, "Birthday" => "07/21/1988", "Years" => "6"),
		array("Num" => 3, "Picture" => "http://stats.nba.com/media/players/230x185/101108.png", "Name" => "Chris Paul", "Pos" => "G", "Height" => "6-0", "Weight" => 175, "Birthday" => "05/06/1985", "Years" => "9"),
		array("Num" => 11, "Picture" => "http://stats.nba.com/media/players/230x185/2037.png", "Name" => "Jamal Crawford", "Pos" => "G", "Height" => "6-5", "Weight" => 200, "Birthday" => "03/20/1980", "Years" => "14"),
		array("Num" => 25, "Picture"=>"http://stats.nba.com/media/players/230x185/203493.png", "Name" => "Reggie Bullock", "Pos" => "SF", "Height" => "6-7", "Weight" => 205, "Birthday"=>"03/16/1991","Years"=>"1"),
		array("Num" => 13, "Picture"=>"http://stats.nba.com/media/players/230x185/202327.png", "Name" => "Ekpe Udoh", "Pos" => "PF", "Height" => "6-10", "Weight" => 240, "Birthday"=>"05/20/1987","Years"=>"4"),
		array("Num" => 22, "Picture"=>"http://stats.nba.com/media/players/230x185/2440.png", "Name" => "Matt Barnes", "Pos" => "F", "Height" => "6-7", "Weight" => 235, "Birthday"=>"03/09/1980","Years"=>"11"),
		array("Num" => 10, "Picture"=>"http://stats.nba.com/media/players/230x185/201150.png", "Name" => "Spencer Hawes", "Pos" => "PF", "Height" => "7-0", "Weight" => 245, "Birthday"=>"04/28/1988","Years"=>"7"),
		array("Num" => 4, "Picture"=>"http://stats.nba.com/media/players/230x185/200755.png", "Name" => "J.J. Redick", "Pos" => "SG", "Height" => "6-4", "Weight" => 190, "Birthday"=>"06/24/1984","Years"=>"8"),
		array("Num" => 1, "Picture"=>"http://stats.nba.com/media/players/230x185/200770.png", "Name" => "Jordan Farmar", "Pos" => "PG", "Height" => "6-2", "Weight" => 180, "Birthday"=>"11/30/1986","Years"=>"7"),
		array("Num" => 14, "Picture"=>"http://stats.nba.com/media/players/230x185/201604.png", "Name" => "Chris Douglas-Roberts", "Pos" => "SG", "Height" => "6-7", "Weight" => 200, "Birthday"=>"01/08/1987","Years"=>"5"),
		array("Num" => 0, "Picture"=>"http://stats.nba.com/media/players/230x185/201175.png", "Name" => "Glen Davis", "Pos" => "PF", "Height" => "6-9", "Weight" => 289, "Birthday"=>"01/01/1986","Years"=>"7"),
		array("Num" => 30, "Picture"=>"http://stats.nba.com/media/players/230x185/203912.png", "Name" => "C.J.Wilcox", "Pos" => "G", "Height" => "6-5", "Weight" => 195, "Birthday"=>"12/30/1990","Years"=>"R"),
		array("Num" => 15, "Picture"=>"http://stats.nba.com/media/players/230x185/2045.png", "Name" => "Hedo Turkoglu", "Pos" => "SF", "Height" => "6-10", "Weight" => 220, "Birthday"=>"03/19/1979","Years"=>"14"),
	)
);

$total = count($result['items']);
$row_count = isset($_GET['row_count']) && (int) $_GET['row_count'] > 0 ? (int) $_GET['row_count'] : 5;
$page = isset($_GET['page']) && (int) $_GET['page'] > 0 ? (int) $_GET['page'] : 1;
$pages = ceil($total / $row_count);
$page = ($page > $pages) ? $pages : $page;
$offset = ($page - 1) * $row_count;

foreach ($result['items'] as $key => $row) {
	$Num[$key] = $row['Num'];
	$Name[$key] = $row['Name'];
	$Pos[$key] = $row['Pos'];
	$Height[$key] = $row['Height'];
	$Weight[$key] = $row['Weight'];
	$Birthday[$key] = $row['Birthday'];
	$Years[$key] = $row['Years'];
	$Picture[$key] = $row['Picture'];
}
$cols = array('Num', 'Name', 'Pos', 'Height', 'Weight', 'Birthday', 'Years', 'Picture');
$col_name = 'Name';
$direction = 'asc';
if (isset($_GET['col_name']) && in_array($_GET['col_name'], $cols) && isset($_GET['direction'])) {
	$col_name = $_GET['col_name'];
	$direction = $_GET['direction'];
}
$sort_order = $direction === 'desc' ? SORT_DESC : SORT_ASC;
array_multisort($$col_name, $sort_order, $result['items']);

$result['items'] = array_slice($result['items'], $offset, $row_count);
$result['paginate'] = compact('page', 'pages', 'offset', 'row_count', 'total', 'col_name', 'direction');
     
header("Content-Type: application/json; charset=utf-8");
echo json_encode($result);
?>