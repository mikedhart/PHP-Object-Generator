<?php 

/**
 * @author Mike Hart
 *
 * @version 0.1
 *
 * @copyright 
 *
 * @package
 *
 * @subpackage
 *
 * @see Object, Database
 */

require_once "path_to_base_object";
class Slider extends Object
{
   /**
	* Represents the primary key of this object
	*/
	const PRIMARY_KEY = "id";

   /**
 	* Description...
 	*
 	* @var type
 	*/
	private $id;

   /**
 	* Description...
 	*
 	* @var type
 	*/
	private $sliderName;

   /**
 	* Description...
 	*
 	* @var type
 	*/
	private $sliderDesc;

   /**
 	* Description...
 	*
 	* @var type
 	*/
	private $sliderMaxItems;

   /**
	* Constructs the object
	*
	* @param int $id
	*/
	public function __construct()
	{
		// construct the parent before performing custom construction.
		parent::__construct();

		// custom code here.
	}

   /**
	* Sets the table name for this object
	*/
	public function setTableName()
	{
		$this->tableName = "sliders";
	}


   /**
 	* Gets the value of id
 	*
 	* @var type
 	*/
	public function getId()
	{
		return $this->id;
	}

   /**
 	* Gets the value of sliderName
 	*
 	* @var type
 	*/
	public function getSliderName()
	{
		return $this->sliderName;
	}

   /**
 	* Gets the value of sliderDesc
 	*
 	* @var type
 	*/
	public function getSliderDesc()
	{
		return $this->sliderDesc;
	}

   /**
 	* Gets the value of sliderMaxItems
 	*
 	* @var type
 	*/
	public function getSliderMaxItems()
	{
		return $this->sliderMaxItems;
	}

   /**
 	* Sets the value of id
 	*
 	* @var int id
 	*/
	public function setId( $id )
	{
		$this->id = $id;
	}

   /**
 	* Sets the value of slider_name
 	*
 	* @var string sliderName
 	*/
	public function setSliderName( $sliderName )
	{
		$this->sliderName = $sliderName;
	}

   /**
 	* Sets the value of slider_desc
 	*
 	* @var string sliderDesc
 	*/
	public function setSliderDesc( $sliderDesc )
	{
		$this->sliderDesc = $sliderDesc;
	}

   /**
 	* Sets the value of slider_max_items
 	*
 	* @var int sliderMaxItems
 	*/
	public function setSliderMaxItems( $sliderMaxItems )
	{
		$this->sliderMaxItems = $sliderMaxItems;
	}
}