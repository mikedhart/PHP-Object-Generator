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

require_once "Object.php";
class SliderItem extends Object
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
	private $itemName;

   /**
 	* Description...
 	*
 	* @var type
 	*/
	private $itemDesc;

   /**
 	* Description...
 	*
 	* @var type
 	*/
	private $itemLinkTo;

   /**
 	* Description...
 	*
 	* @var type
 	*/
	private $itemImage;

   /**
 	* Description...
 	*
 	* @var type
 	*/
	private $itemAltText;

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
		$this->tableName = "slider_items";
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
 	* Gets the value of itemName
 	*
 	* @var type
 	*/
	public function getItemName()
	{
		return $this->itemName;
	}

   /**
 	* Gets the value of itemDesc
 	*
 	* @var type
 	*/
	public function getItemDesc()
	{
		return $this->itemDesc;
	}

   /**
 	* Gets the value of itemLinkTo
 	*
 	* @var type
 	*/
	public function getItemLinkTo()
	{
		return $this->itemLinkTo;
	}

   /**
 	* Gets the value of itemImage
 	*
 	* @var type
 	*/
	public function getItemImage()
	{
		return $this->itemImage;
	}

   /**
 	* Gets the value of itemAltText
 	*
 	* @var type
 	*/
	public function getItemAltText()
	{
		return $this->itemAltText;
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
 	* Sets the value of item_name
 	*
 	* @var string itemName
 	*/
	public function setItemName( $itemName )
	{
		$this->itemName = $itemName;
	}

   /**
 	* Sets the value of item_desc
 	*
 	* @var string itemDesc
 	*/
	public function setItemDesc( $itemDesc )
	{
		$this->itemDesc = $itemDesc;
	}

   /**
 	* Sets the value of item_link_to
 	*
 	* @var string itemLinkTo
 	*/
	public function setItemLinkTo( $itemLinkTo )
	{
		$this->itemLinkTo = $itemLinkTo;
	}

   /**
 	* Sets the value of item_image
 	*
 	* @var string itemImage
 	*/
	public function setItemImage( $itemImage )
	{
		$this->itemImage = $itemImage;
	}

   /**
 	* Sets the value of item_alt_text
 	*
 	* @var string itemAltText
 	*/
	public function setItemAltText( $itemAltText )
	{
		$this->itemAltText = $itemAltText;
	}
}

mysql_connect("localhost", "root", "root");
mysql_select_db("web101-dazguitar");

$item = new SliderItem();
$item->setItemAltText("hghghgh");var_dump($item);
$item->save();