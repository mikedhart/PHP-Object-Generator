<?php

if( isset( $_POST['class_name'] ) ){

require_once 'Database.php';

class ModelGenerator
{	
	private static function getHydrateStatement( $tableName, $colsArray )
	{
		return "\"SELECT `".implode( '`, `', $colsArray )."` FROM `".$tableName."` WHERE `id` = \".\$id.\" LIMIT 1\";";
	}
	
	public static function getVarFromColumnName( $col )
	{
		if( strstr( $col, "_" ) ){
			$col = explode( "_", $col );
			
			$firstWord = $col[0];
			
			foreach( $col as $c ){
				$firstLetter = substr( $c, 0, 1 );
				$restOfVar = substr( $c, 1 );
				
				$firstWord .= strtoUpper( $firstLetter ).$restOfVar;
			}
			
			$col = $firstWord;
		}
		
		return $col;
	}
	
	private static function generateGetter( $var )
	{
		$firstLetter = substr( $var, 0, 1 );
		
		$restOfVar = substr( $var, 1 );
		
		$firstLetter = strtoupper( $firstLetter );
		
		$getter = "	public function get".$firstLetter.$restOfVar."()\n	{\n		return \$this->".$var.";\n	}";
		
		return $getter;
	}
	
	private static function generateSetter( $var )
	{
		$firstLetter = substr( $var, 0, 1 );
		
		$restOfVar = substr( $var, 1 );
		
		$firstLetter = strtoupper( $firstLetter );
		
		$setter = "	public function set".$firstLetter.$restOfVar."( ".$var." )\n	{\n		\$this->".$var." = ".$var.";\n	}";
		
		return $setter;
	}
	
	public function getTopComment()
	{
		return "<?php \n\n /**\n *\n * @author Mike Hart\n *\n * @version 0.1\n *\n * @copyright \n *\n * @package\n *\n * @subpackage\n *\n **/\n\n";
	}
	
	public function setClassMeta(array $array)
	{
		foreach($array as $key => $value){
			$this->classMeta[$key] = $value;
		}
	}
	
	public function setTableName($string)
	{
		$this->tableName = $string;
	}
	
	public function setColumns(array $array)
	{
		foreach($array as $col){
			array_push($this->columns, $col);
		}
	}
	
	public function getClassMeta($formatted = true)
	{
		if($formatted === true){
			return $this->generateClassMeta();
		} else{
		
		}
	}
	
	private function generateClassMeta()
	{
		$meta = "/**\n *\n";
		
		foreach($this->getClassMeta() as $m){
		
		}
		
	}
	
	public static function getCols( $tableName )
	{
		$sql = "SHOW COLUMNS FROM `".$tableName."`";

		return Database::fetchAll($sql);
	}
	
	public static function generateGetters( $colsArray )
	{
		$getters = "";
		
		foreach( $colsArray as $col ){
			$getters .= "\n\n   /**\n 	* Gets the value of ".$col."\n 	*\n 	* @var type\n 	*/\n";
			
			$getters .= self::generateGetter( $col );
		}
		
		return $getters;
	}
	
	public static function generateSetters( $colsArray )
	{
		$setters = "";
		
		foreach( $colsArray as $col ){
			$setters .= "\n\n   /**\n 	* Sets the value of ".$col."\n 	*\n 	* @var type\n 	*/\n";
			
			$setters .= self::generateSetter( $col );
		}
		
		return $setters;
	}
	
	public static function generateConstructor( $tableName, $colsArray )
	{
		$c = "   /**\n	* Constructs the object\n	*\n	* @param int \$id\n	*/\n	public function __construct( \$id = null )\n	{";
		$c .= "\n		\$sql = ".self::getHydrateStatement( $tableName, $colsArray );
		$c .= "\n		\$query = mysql_query( \$sql )\n\n";
		$c .= "		while( \$row = mysql_fetch_row( \$query ) ){\n	";
		
		foreach( $colsArray as $col ){
			$c .= "\$row[\'".$col."\'] = 
		}
		
		return $c;
	}
	
	public static function generatePrimaryKeyConstant()
	{
		return "   /**\n	* Represents the primary key of this object\n	*/\n	const PRIMARY_KEY = \"id\";\n\n";
	}
}

Database::connect();

$comment = ModelGenerator::getTopComment();

$className = "class ".$_POST['class_name']."\n{\n";

$cols = ModelGenerator::getCols( $_POST['table_name'] );

$colsArray = array();

foreach ($cols as $col){
	$colsArray[] = ModelGenerator::getVarFromColumnName( $col['Field'] );
}

$pk = ModelGenerator::generatePrimaryKeyConstant();

$constructor = ModelGenerator::generateConstructor( $_POST['table_name'], $colsArray );

$getters = ModelGenerator::generateGetters( $colsArray );

$setters = ModelGenerator::generateSetters( $colsArray );

$vars = "";

foreach( $colsArray as $var ){
	$vars .= "   /**\n 	* Description...\n 	*\n 	* @var type\n 	*/\n	private $".$var."\n\n";
}

$file = fopen("test.php", "w"); fwrite($file, $comment.$className.$pk.$vars.$constructor.$getters.$setters."\n}");

} else{
?>

<table>
<form method="post">
<tr>
	<td>Class name</td>
	<td><input type="text" name="class_name"></td>
</tr>
<tr>
	<td>Table name</td>
	<td><input type="text" name="table_name"></td>
</tr>
<tr>
	<td />
	<td><input type="submit" /></td>
</tr>
</form>
</table>

<?php } ?>