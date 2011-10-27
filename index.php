<?php
/**
 * This script will create generic PHP model objects. For full information on how to use,
 * please visit http://www.mikedhart.co.uk/2011/10/26/php-object-generator/
 *
 * Also please remember to make sure you have an active mysql connection!
 * 
 * @author Mike Hart
 *
 * @copyright MIT
 *
 * @version 1.2
 *
 * @package object_generator
 */

if( isset( $_POST['class_name'] ) ){

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

				
				$c = str_replace($firstWord, '', $c);
				
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
		$formattedVar = self::getVarFromColumnName( $var );
		
		$firstLetter = substr( $formattedVar, 0, 1 );
		
		$restOfVar = substr( $formattedVar, 1 );
		
		$firstLetter = strtoupper( $firstLetter );
		
		$setter = "	public function set".$firstLetter.$restOfVar."( \$".$formattedVar." )\n	{\n		\$this->".self::getVarFromColumnName( $var )." = \$".self::getVarFromColumnName( $var ).";\n	}";
		
		return $setter;
	}
	
	public function getTopComment()
	{
		return "<?php \n\n/**\n * @author Mike Hart\n *\n * @version 0.1\n *\n * @copyright \n *\n * @package\n *\n * @subpackage\n *\n * @see Object, Database\n */\n\n";
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
			$setters .= "\n\n   /**\n 	* Sets the value of ".$col['Field']."\n 	*\n 	* @var ".self::getVarType( $col['Type'] )." ".self::getVarFromColumnName( $col['Field'] )."\n 	*/\n";
			
			$setters .= self::generateSetter( $col['Field'] );
		}
		
		return $setters;
	}
	
	public static function generateConstructor( $tableName, $colsArray )
	{
		$c = "   /**\n	* Constructs the object\n	*\n	* @param int \$id\n	*/\n	public function __construct()\n	{\n		// construct the parent before performing custom construction.\n		parent::__construct();\n\n		// custom code here.\n	}";
		
		return $c;
	}
	
	public static function generatePrimaryKeyConstant()
	{
		return "   /**\n	* Represents the primary key of this object\n	*/\n	const PRIMARY_KEY = \"id\";\n\n";
	}
	
	private static function getVarType( $var )
	{
		if( strstr( $var, "int" ) ){
			return "int";
		} elseif( strstr( $var, "bool" ) ){
			return "bool";
		} else{
			return "string";
		}
	}
	
	public static function generateAbstractMethods( $tableName )
	{
		return "\n\n   /**\n	* Sets the table name for this object\n	*/\n	public function setTableName()\n	{\n		\$this->tableName = \"".$tableName."\";\n	}\n";
	}
}

Database::connect();

$comment = ModelGenerator::getTopComment();

$className = "require_once \"path_to_base_object\";\nclass ".$_POST['class_name']." extends Object\n{\n";

$cols = ModelGenerator::getCols( $_POST['table_name'] );

$colsArray = array();

foreach ($cols as $col){
	$colsArray[] = ModelGenerator::getVarFromColumnName( $col['Field'] );
}

$pk = ModelGenerator::generatePrimaryKeyConstant();

$constructor = ModelGenerator::generateConstructor( $_POST['table_name'], $colsArray );

$getters = ModelGenerator::generateGetters( $colsArray );

$setters = ModelGenerator::generateSetters( $cols );

$vars = "";

foreach( $colsArray as $var ){
	$vars .= "   /**\n 	* Description...\n 	*\n 	* @var type\n 	*/\n	private $".$var.";\n\n";
}

$abstractMethods = ModelGenerator::generateAbstractMethods( $_POST['table_name'] );

$file = fopen($_POST['class_name'].".php", "w"); fwrite($file, $comment.$className.$pk.$vars.$constructor.$abstractMethods.$getters.$setters."\n}");

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