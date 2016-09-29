<?
$conn = pg_pconnect("host=localhost dbname=township user=www password=www") or exit('Error de conexion a township');

$csv = file('township.csv',  FILE_IGNORE_NEW_LINES );

function to_int ($val) {
	if (empty($val)) $a = 0;
	else $a = $val;
	return $a;
}

foreach ($csv as $row) {
	$field = explode(',', $row	);
	echo "f: ".$field[4]. "  #";
	var_dump($field[4]);
	if ($field[4] == '1') $field[4] = 't';
	else $field[4] = 'f';
echo "f4:".$field[4]."\n";
	//ver si existe la factory
	$q="select * from factory where name = '".$field[2]."' limit 1";
	$c = pg_exec($conn, $q);
	if (pg_num_rows($c)) {
		$factoryId = pg_fetch_result($c, 0, 0);
	} else {
		//creo factoria
		pg_exec($conn, "BEGIN WORK");
		$f = "insert into factory (name) values ('".$field[2]."')";
		$cf = pg_exec($conn, $f);
		$q = "select id from factory order by id desc limit 1";
		$c = pg_exec($conn, $q);
		$factoryId = pg_fetch_result($c, 0, 0);
		pg_exec($conn, "END WORK");

	}
	if ($factoryId) {
		$ins = "insert into items (fk_factory_id,name,valor,make_time,is_resource) values ($factoryId,'".$field[0]."',".to_int($field[1]).",".to_int($field[3]).",'".$field[4]."')";
		echo $ins."\n";
		pg_exec($conn, $ins);

	} else echo "Inter ERROR $row \n";
	
}

