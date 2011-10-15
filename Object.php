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
	 * Sets the value of fields
	 */
	abstract public function setFields();
	
	public function __construct()
	{
		$this->setFields();
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
}