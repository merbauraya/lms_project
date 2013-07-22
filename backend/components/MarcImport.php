<?php
/**
 * MarcImport.php
 *
 * Handling importing marc into the catalog
 * 
 */      

require_once('File/MARC.php');
require_once('File/MARCXML.php');
class MarcImport
{
   private $marc; //our internal Marc Record instance
   private $catalogId ; //system catalog id, for tag 001
   private $marcAr; //marcActiveRecord instance
   
   
   private $uploadBatch ; //
   private $matchingRule ; //import matching rule
   private $matchedRule ; //matched rule
   private $nonMatchedRule ; //non matched rule
   
   private $importSummary = array();
   /**
    * constructor
    * @param marcUpload an instance of MarcUpload
    * 
    */ 
	function __construct($marcUpload)
    {
        if (!$marcUpload instanceof MarcUpload)
            throw new Exception('Invalid class. Expecting instance of MarcUpload');
       
        $this->uploadBatch = $marcUpload;
        //$this->marc = $marc;
        //$this->marcAr = MarcActiveRecord::setMarc($marc);
    }
    /**
     * 
     * 
     * Return true if successul, otherwise false will be returned;
     */ 
    public function import()
    {
        //load upload items
        $items = MarcUploadItem::model()->findAllByAttribute(
                        array(),
                        'marc_upload_id = :id',
                        array(':id'=>$this->uploadBatch->id)
                   
                    );
        //loop thru items and grab marcxml stored and process them
        //according to the import rule
        foreach ($items as $item)
        {
            $marc = new File_MARCXML($item->marc_xml, File_MARC::SOURCE_STRING);
            $record = $marc->next();
            $marcRecord = MarcActiveRecord::setMarc($record);
            $this->processRecord($marcRecord);
            
            
        }
        
    }
    /**
     * Process individu marc record for import against the import rule
     * 
     * @param marcRecord an instance of MarcActiveRecord
     */  
    private function processRecord($marcRecord)
    {
        $exists = false; //our exist flag
        $catalog = new Catalog();
        
        switch ($this->uploadBatch->matchingRule)
        {
            case MarcUpload::MATCHING_RULE_NO_MATCHING:
                $catalog=null;
                break;
                
            case MarcUpload::MATCHING_RULE_ISBN:
                $ident = $marcRecord->getISBN();
                $catalog = Catalog::model()->findByISBN($ident)
                break;
                
            case MarcUpload::MATCHING_RULE_ISSN
                $ident = $marcRecord->getISSN();
                $catalog = Catalog::model()->findByISSN($ident);
                break;
        }
        if ($catalog) // we have existing record
            $this->processMatched($catalog,$marcRecord);
        else //no matching
            $this->processNonMatched($marcRecord);
        
        
        
    }
    /**
     * Process non match record, e.g. we are trying to import record which not already
     * exists in our catalog. Check non match rule, and proceed accordingly
     * 
     * @param marcRecord an instance of MarcActiveRecord to be processed/imported
     */ 
    private function processNonMatched($marcRecord)
    {
        switch ($this->batchUpload->action_if_no_match)
        {
            case MarcUpload::NO_MATCHED_ADD:
                addNewCatalog($marcRecord);
                break;
                
            case MarcUpload::NO_MACTHED_IGNORE:
                break;
            
        }
        
    }
    /**
     * Process matched record, e.g. we are trying to import marc
     * which already exists in our catalog. Check matched rule, and proceed accordingly
     * 
     * @param catalog  an instance of Catalog 
     * @param marcRecord an instance of MarcActiveRecord to be processed/imported
     */ 
    private function processMatched($catalog,$marcRecord)
    {
        switch ($this->batchUpload->action_if_matched)
        {
            case MarcUpload::MATCHED_REPLACED_EXISTING: //overwrite/replace existing record
                $this->replaceCatalog($catalog,$marcRecord);
                break;
                
            case MarcUpload::MATCHED_ADD_NEW: //add new record
                $this->addNewCatalog($marcRecord);
                break;
                
            case MarcUpload::MATCHED_IGNORE: //do nothing
                break;
            
            
        }
        
        
    }
    /**
     * 
     * Add new catalog
     * @param marcRecord an instance of MarcActiveRecord to be imported/added
     * 
     */
    private function addNewCatalog($marcRecord)
    {
        
        
        
    }
    private function replaceCatalog($catalog,$marcRecord)
    {
        
        
    }
}

