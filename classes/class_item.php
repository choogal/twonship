<?

class item {


	public function __construct($itemId = null) {
		global $conn;
		if ($itemId) {
			$this->id = $itemId;
			$q="select * from items where id = ".$this->id;
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

	public function getAllItems ($type = 'all', $ord = 'items.name', $ordType = 'asc') {
		global $conn;
		if ($type == 'res') $w = " and is_resource = 't' ";
		else if ($type == 'prod') $w = " and is_resource = 'f' ";
		$q = "select items.*, factory.name as factory_name, factory.id as factory_id from items, factory where factory.id=items.fk_factory_id $w order by $ord $ordType";
		//echo "q:".$q;
		$c=pg_exec($conn, $q);
		if (pg_num_rows($c)) {
			while ($arr = pg_fetch_array($c)) {
				$res[$arr['id']] = $arr;
			}
			return $res;
		} else return false;
	}
	public function getItemById($id) {
		global $conn;
		$q="select * from items where id = $id";
		//echo $q."  dfd";
		$c=pg_exec($conn, $q);
		if (pg_num_rows($c)) return pg_fetch_array($c);
		else return false;
 	}

 	public function getItemsByFactoryId($factory_id) {
 		global $conn;
 		$q="select * from items where fk_factory_id=$factory_id";
 		$c=pg_exec($conn,$q);
 		if (pg_num_rows($c)) {
 			while ($arr = pg_fetch_array($c)) {
 				$res[] = $arr;
 			}
 			return $res;
 		} else return false;

 	}

	function save() {
		global $conn;
		
		if ($this->id) {
			$q_up = "update items set name='".$this->name."', fk_factory_id=".$this->fk_factory_id.", make_time=".$this->make_time.", valor=".$this->valor.",is_resource = '".$this->is_resource."' where id = ".$this->id;
			echo "$q_up <br>";
			if (pg_exec($conn, $q_up)) {
				return true;
			} else {
				return false;
			}
		} else {
			pg_exec($conn, "BEGIN WORK");
			$q_ins = "insert into items (name, fk_factory_id, make_time, valor, is_resource) values ('".$this->name."',".$this->fk_factory_id.",".$this->make_time.",".$this->valor.",'".$this->is_resource."')";
			$c_ins = pg_exec($conn, $q_ins);
			$q = "select id from items order by id desc limit 1";
			$c = pg_exec($conn, $q);
			$id = pg_fetch_result($c, 0, 0);
			pg_exec($conn, "END WORK");
			var_dump($id);
			if ($id) {
				$this->id = $id;
				return true;
			} else return false;
		}
	}

	function setAttributes($attr) {
		foreach ((array)$attr as $name => $value) {
			$this->$name = $value;
		}
	}

	public function delete($id) {
		global $conn;
		$q_del = "delete from items where id= $id";
		
		if (pg_exec($conn, $q_del)) return true;
		else return false;
	}
}