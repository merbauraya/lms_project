<?php

class AmazonWS
{
	private $url = 'http://webservices.amazon.com/onca/xml?';
	public $service = 'AWSECommerceService';
	public $operation = 'ItemLookup';
	public $ResponseGroup='Large';
	public $searchindex = 'All';
	public $idType = 'ISBN';
	public $ItemId='';
	public $AWSAccessKeyId = 'AKIAJNUGZIWA3MLNHAWA';
	
}

?>