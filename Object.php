<?php

/**
 * This is an abstract object class.
 * This should never be instantiated but always extended by other objects in this library.
 * 
 * @author Mike Hart
 * 
 * @version 0.1
 * 
 * @package
 * @subpackage
 * 
 * @license MIT
 *
 */
abstract class Object
{
	/**
	 * Holds all the fields in the child object.
	 * 
	 * @var array
	 */
	protected $fields;
	
	/**
	 * Holds all the table name of the child object.
	 *
	 * @var string
	 */
	protected $tableName;
	
	/**
	 * Is this a new object
	 * 
	 * @var int
	 */
	private $isNew = 0;
	
	/**
	 * Holds the value of the primary key field
	 * 
	 * @var string
	 */
	private $primaryKeyField;
	
	/**
	 * Holds the value of the primary
	 *
	 * @var mixed
	 */
	private $primaryKey;
	
	
	/**
	 * Sets the value of tableName
	 */
	abstract public function setTableName();
	
	/**
	 * Sets the values of the fields
	 */
	public function setFields()
	{
		$cols = $this->getColumns();
		
		foreach( $cols as $col ){
			$this->fields[] = $this->makeVarFromField( $col );
		}
	}

	/**
	 * Constructs the object
	 */
	public function __construct( $id = null )
	{
		$this->setTableName();
		$this->setFields();
		$this->setPrimaryKeyField();
		
		if( $id == null ){
			$this->isNew = 1;
		} else{
			$query = "SELECT * FROM ".$this->tableName." WHERE ".$this->getPrimaryKeyField()." = ".$id." LIMIT 1";
			
			$result = mysql_query($query);
			
			$row = mysql_fetch_assoc($result);
			
			if(!is_array( $row )) throw new Exception( "Could not find record ".$id." in ".$this->tableName );
			
			foreach($row as $key => $value){
				$method = $this->prepareVarForGetSet( $this->makeVarFromField( $key ), "set" );
				
				if( $key == $this->getPrimaryKeyField() ) $this->setPrimaryKey( $value );
				
				$this->$method( $value );
			}
		}
		
		return $this;
	}
	
	/**
	 * Get the fields in the object
	 * 
	 * @return array
	 */
	public function getFields()
	{
		return $this->fields;
	}
	
	/**
	 * Outputs the fields in an array format.
	 */
	public function toArray()
	{
		$array = array();
		
		foreach( $this->fields as $field ){
			
			$method = $this->prepareVarForGetSet( $field, "get" );
			$array[$field] = $this->$method();
			
		}
		
		return $array;
	}
	
	/**
	 * Outputs the fields in JSON format.
	 */
	public function toJson()
	{
		return json_encode( $this->toArray() );
	}
	
	private function prepareVarForGetSet( $var, $mode = "get" )
	{
		$varAsArray = substr( $var, 0, 1 );
		
		$firstLetter = strtoupper( $varAsArray[0] );
		
		$restOfVar = substr( $var, 1 );
		
		$method = $mode.$firstLetter.$restOfVar;
		
		return $method;
	}
	
	private function makeVarFromField( $col )
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
	
	public function save()
	{
		$fields = $this->getColumns();
		
		if( $this->isNew ){
			
			$sql = "INSERT INTO ".$this->tableName." (`".implode('`, `', $fields)."`) VALUES (";
			
			foreach ($this->fields as $f){
				$method = $this->prepareVarForGetSet( $this->makeVarFromField( $f ) );
				$sql .= "'".$this->$method()."', ";
			}
			
			$sql = substr_replace($sql, '', -2);
			
			$sql .= ");";
		} else{
			$sql = "UPDATE ".$this->tableName." SET ";
			
			foreach( $fields as $f ){
				$method = $this->prepareVarForGetSet( $this->makeVarFromField( $f ) );
				$sql .= $f." = '".$this->$method()."', ";
			}
			
			$sql = substr_replace($sql, '', -2);
			
			$method = $this->prepareVarForGetSet( $this->getPrimaryKeyField() );
			
			$sql .= " WHERE ".$this->getPrimaryKeyField()." = ".$this->$method();
		}
		
		mysql_query( $sql );
	}
	
	public function getColumns()
	{
		$sql = "SHOW FIELDS FROM ".$this->tableName;
		
		$query = mysql_query($sql);
		
		$fields = array();
		
		while( $result = mysql_fetch_object($query) ){
			$fields[] = $result->Field;
		}
		
		return $fields;
	}
	
	private function setPrimaryKeyField()
	{
		$query = "SHOW INDEX FROM ".$this->tableName;
		
		$result = mysql_query($query);
		
		while ($row = mysql_fetch_object($result)){
			$this->primaryKeyField = $row->Column_name;
		}
	}
	
	
	/**
	 * Gets the primary key of the object
	 */
	public function getPrimaryKey()
	{
		return $this->primaryKey;
	}
	
	/**
	 * Sets the primary key of the object
	 */
	public function setPrimaryKey( $pk )
	{
		$this->primaryKey = $pk;
	}
	
	protected function getPrimaryKeyField()
	{
		return $this->primaryKeyField;
	}
	
	public function isNew()
	{
		return $this->isNew;
	}
	
	public function getTableName()
	{
		return $this->tableName;
	}
	
	public function delete()
	{
		if ( $this->isNew() ) throw new Exception("Cannot delete a record that does not yet exist");

		mysql_query( $query = "DELETE FROM ".$this->getTableName()." WHERE ".$this->getPrimaryKeyField()." = ".$this->getPrimaryKey() );
	}
}