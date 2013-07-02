<?php
class BookWS extends CComponent
{
	public $url='';
	public $isbn='';
	public $title='';
	public $author='';
	public $publisher='';
	public $subject='';
	public $lccn='';
	public $oclc ='';
	protected $rawData;
	protected $result; //result in php array
	
	protected $_title;
	protected $_authors;
	protected $_subject;
	protected $_isbn10;
	protected $_isbn13;
	protected $_publisher;
	protected $_publishedDate;
	protected $_subtitle;
	protected $_description;
	protected $_price;
	protected $_thumbnail;
	protected $_smallthumbnail;
	protected $_recordExist;

	function __construct()
	{
		$this->_authors='';
		$this->_recordExist = false;
	
	}
	public function query()
	{
		
	}
	protected function parse()
	{
		
	}
	public function getAuthor()
	{
		return $this->_authors;
	}
	public function getTitle()
	{
		return $this->_title;	
	}
	public function getPublisher()
	{
		return $this->_publisher;
	}
	public function getPrice()
	{
		
	}
	public function getSubTitle()
	{
 	       return $this->_subtitle;
	}
	public function getPublishedDate()
	{
               return $this->_publishedDate;
	}
	public function getISBN10()
	{
		return $this->_isbn10;	
	}
	public function getISBN13()
	{
		return $this->_isbn13;
	}
	public function getDescription()
	{
			return $this->_description;
	}
	public function getThumbnail()
	{
               return $this->_thumbnail;
        }
    public function getSmallThumbnail()
        {
               return $this->_smallthumbnail;
        }

	protected function _isInfoExist($info)
	{
		if (is_null($info))
			return '';
		else
			return $info;
	}
}
?>