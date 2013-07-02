<?php
class GoogleBook extends BookWS
{
	private  $_url = 'https://www.googleapis.com/books/v1/volumes?q=';
	const isbnQ = 'isbn:';
	const authorQ = 'inauthor:';
	const titleQ = 'intitle:';
	const apikey = 'AIzaSyB_1F6zgI4TTzTgGoyrB2XiLZgX_XdqyoY';
	private $_gvolumeinfo;
	//https://www.googleapis.com/books/v1/volumes?q=isbn:1449319262

	public function init()
	{
		
	}
	/**
	* 
	* Run the query against google book API
	*/
	public function query()
	{
		
		$params='';
		if (isset($this->isbn))
			$params = self::isbnQ . $this->isbn;
                $params = $params .'&key=' . self::apikey;
		$wurl = $this->_url . $params;
		$this->rawData = file_get_contents($wurl);
		$this->result = json_decode($this->rawData);
		$this->parse();
	}
	protected function parse()
	{
		if ($this->result->totalItems == 1)
		{
			$this->_recordExist = true; //we found it
			$_gvolumeinfo = $this->result->items[0]->volumeInfo;
			$this->_title = $this->result->items[0]->volumeInfo->title;
			if (isset($this->result->items[0]->volumeInfo->authors))
				$this->_authors = $this->result->items[0]->volumeInfo->authors;
			else
				$this->_authors = '';
			$this->_subtitle = isset($_gvolumeinfo->subtitle) ? $_gvolumeinfo->subtitle : '';
			//$this->_subtitle =  $this->result->items[0]->volumeInfo->subtitle;
			if (isset($this->result->items[0]->volumeInfo->publisher))
				$this->_publisher = $this->result->items[0]->volumeInfo->publisher;
			$this->_publishedDate = $_gvolumeinfo->publishedDate;
			if (isset($_gvolumeinfo->description))
				$this->_description=$_gvolumeinfo->description;
			if (isset($_gvolumeinfo->imageLinks->thumbnail))
				$this->_thumbnail = $_gvolumeinfo->imageLinks->thumbnail;
			if (isset($_gvolumeinfo->imageLinks->smallThumbnail))
				$this->_smallthumbnail = $_gvolumeinfo->imageLinks->smallThumbnail;
			
			//grab both ISBNs
			$arrIdent = $_gvolumeinfo->industryIdentifiers;
			foreach ($arrIdent as $value)
			{
				
				switch ($value->type)
				{
					case 'ISBN_10':
						$this->_isbn10=$value->identifier;
						break;
					case 'ISBN_13':
						$this->_isbn13 = $value->identifier;
						break;
				}
				
			}
			
		}
		elseif ($this->result->totalItems == 0)
		{
			//no record found in google
			$this->_recordExist = false;
		
		}
		
		
	}
		
	
}
?>