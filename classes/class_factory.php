<?

class factory {
	public function __construct($factoryId = null) {
		global $conn;
		if ($factoryId) {
			$q="select * from factory where id = $factoryId";
			$c=pg_exec($conn, $q);
			if (pg_num_rows($c)) {
				$arr = pg_fetch_array($c);
				foreach ($arr as $key => $value) {
					$this->$key = $value;
				}
				//$this->name = $arr
			} else return false;
		}
	}	

	public function getAllFactory ($ord = 'name', $ordType = 'asc') {
		global $conn;
		if (!$isRes) $w = " and is_resource = 'f' ";
		$q = "select * from factory order by $ord $ordType";
		//echo "q:".$q;
		$c=pg_exec($conn, $q);
		if (pg_num_rows($c)) {
			while ($arr = pg_fetch_array($c)) {
				$res[$arr['id']] = $arr;
			}
			return $res;
		} else return false;
	}

	function save() {
		global $conn;
		if ($this->id) {
			$q_up = "update factory set name='".$this->name."' where id = ".$this->id;
			$c_up = pg_exec($conn, $q_up);
		} else {
			$q_ins = "insert into factory (name) values ('".$this->name."')";
			$c_ins = pg_exec($conn, $q_ins);
		}
	}

	function setAttributes($attr) {
		foreach ((array)$attr as $name => $value) {
			$this->$name = $value;
		}
	}
}