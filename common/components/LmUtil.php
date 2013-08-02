<?php

class LmUtil
{
	
    /**
     * List of settings
     * 
     */
     
    const PASSWORD_HASH_ALGO = 'PASSWORD_HASH_ALGO';
    const DB_DATEFORMAT = 'Y-m-d H:i:s' ; 
    const YII_DISPLAY_DATEFORMAT = 'dd/MM/yyyy'; //yii equivalent date format 
    
    public static function getDBDateFormat()
    {
		return 'yyyy-MM-dd HH:mm:ss';
		
	}
    public static function displayDateFormat()
    {
		return self::YII_DISPLAY_DATEFORMAT;
	}
	/**
	 * Parse date range as entered by user and return range which are safe for DB comparison
	 * @range array/string for the date to be parsed
	 * 
	 */
	public static function ConvertToDBDate($range)
	{
		if (is_array($range))
		{
			$val = array();
			foreach ($range as $value)
				$val[] = self::ToDbDate($value);
				
			return $val;
			
		}else
		{
			return self::ToDbDate($range);
		}
		
	}
	/*
	 * Convert date to format which is Database safe
	 * 
	 */
	private static function ToDbDate($value)
	{
		$val= CDateTimeParser::parse(trim($value),self::displayDateFormat());
        return Yii::app()->dateFormatter->format(LmUtil::getDBDateFormat(),$val); 
		
	}
	
	/**
	* Return current date in a format that can used during DB operation
	*
	*/
	public static function CurrentDate()
	{
		return date('Y/m/d');
	}
	/**
	* Return current logged user ID
	* Note that the different between User ID and username
	* User ID is integer value stored as PK in user/patron table
	* Username is the log in id used by user during logging process
	* For more detail pls, check patron table
	*/
	public static function UserId()
	{
		
		$ret = Yii::app()->user->getId();
		return $ret;
	}
	public static function UserLibraryId()
	{
	    return Yii::app()->user->getLibraryId();
	    
	}
	public static function le($controller,$message)
	{
		self::logError('DB Error : ' .$message,$controller->id.$controller->action->id);
	}
    public static function successFlash($message)
    {
        Yii::app()->user->setFlash('success', $message);
    }
    public static function errorFlash($message)
    {
        Yii::app()->user->setFlash('error', $message);
    }
	public static function LogError($message,$category)
	{
		Yii::log($message,'error',$category);
	}
	/**
	 * This is a helper function that generates a place holder for sql param binding
	 * when the value to bind is an array
	 * This is a hack where pdo bind param does not support array for
     * sql in condition
	 * 
	 * @param id string name of the param place holder
	 * @param array vals Array of value to be bind
	 * Usage Example
	 * sqlInConditionArrayPlaceHolder('po_id',array)
	 * It will returns
	 * :po_id1,po_id2,po_idn  ...depending on the size of the array
	 */
	public static function sqlInConditionArrayPlaceHolder($name,$vals)
	{
		$ret='';
		for ($i = 0; $i < count($vals);++$i)
		{
			$ret .= ':'.$name.$i;
			//check if we at the last array item
			if ($i+1 < count($vals))
				$ret .=',';
		}
		return $ret;
			
			
	
	}
    /*
     * Return date format as specified in main configuration
     * 
     */ 
    public static function getDateFormat()
    {
        return Yii::app()->params['dateFormat'];
        
    }
	/*
	 * return current date safe for sql 
	 **/
	public static function dBCurrentDateTime()
	{
		$time = time();
        
        return date("Y-m-d H:i:s", $time);
	}
	public static function dbNOWexpression()
	{
		return new CDbExpression('NOW()');	
		
	}
    /**
     * Remove all characters except numbers
     * 
     * @param string $string
     * @return string
     */ 
    public static function stripNonNumeric($string)
    {
        return preg_replace( "/[^0-9]/", "", $string );
        
    }    	
	public static function formatDate($value,$inFormat,$outFormat)
    {
        
        return Yii::app()->dateFormatter->format($outFormat,  CDateTimeParser::parse($value,$inFormat));
        
    }


}



?>
