<?
$conn = pg_pconnect("host=localhost dbname=township user=www password=www") or exit('Error de conexion a township');

include_once('../classes/class_item.php');
include_once('../classes/class_factory.php');
include_once('../classes/class_item_recipe.php');
