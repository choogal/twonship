<?

class item_recipe {
	

	public function getItemRecipeOfItem ($itemId) {
		global $conn;
		
		$q = "select * from item_recipe where fk_items_id = $itemId";
		//echo "q:".$q;
		$c=pg_exec($conn, $q);
		if (pg_num_rows($c)) {
			while ($arr = pg_fetch_array($c)) {
				$res[$arr['id']] = $arr;
			}
			return $res;
		} else return false;
	}

	public function save($itemId, $recipeId, $amount) {
		global $conn;
		//if (!$this->id) {
			pg_exec($conn, "BEGIN WORK");
			$q_ins = "insert into item_recipe (fk_items_id, fk_recipe_id, amount) values ($itemId, $recipeId, $amount)";
			//$q_up = "update item_recipe set fk_items_id='". where id = ".$this->id;
			$c_ins = pg_exec($conn, $q_ins);
			$q = "select id from item_recipe order by id desc limit 1";
			$c = pg_exec($conn, $q);
			$id = pg_fetch_result($c, 0, 0);
			pg_exec($conn, "END WORK");
			//var_dump($id);
			if ($id) {
				return $id;
			} else return false;
		//} 
	}

	public function delete($id) {
		global $conn;
		$q_del = "delete from item_recipe where id= $id";
		if (pg_exec($conn, $q_del)) return true;
		else return false;
	}
}