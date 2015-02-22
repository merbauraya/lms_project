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
    
    const SETTING_CATEGORY_CATALOGING = 'CATALOGING';
    const SETTING_CATEGORY_ACQUISITION = 'ACQUISITION';
    const SETTING_CATEGORY_CIRCULATION = 'CIRCULATION';
    const SETTING_CATEGORY_GENERAL = 'GENERAL';
    
    public static function getSettingGeneral($key)
    {
        return Yii::app()->config->get(self::SETTING_CATEGORY_GENERAL,$key);
    }
    public static function getSettingCirculation($key)
    {
        return Yii::app()->config->get(self::SETTING_CATEGORY_CIRCULATION,$key);
        
    }
    //get app setting for cataloging category for specific key
    public static function getSettingCataloging($key)
    {
        return Yii::app()->config->get(self::SETTING_CATEGORY_CATALOGING,$key);
        
    }
    //get app setting for acquisiion category for specific key
    public static function getSettingAcquisition($key)
    {
        return Yii::app()->config->get(self::SETTING_CATEGORY_ACQUISITION,$key);
        
    }   
    
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
	public static function yesNoBadges($value)
    {
        $type = $value ? 'info' : 'inverse';
        $label = $value ? 'Yes' : 'No';
        return '<span class="label label-'. $type .'">'. $label.'</span>';
        
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
		
		 return Yii::app()->user->getId();
		
	}
	public static function UserLibraryId()
	{
	    return Yii::app()->user->getLibraryId();
	    
	}
    public static function throw400Error($msg='Invalid request. Please do not repeat this request again.')
    {
        throw new CHttpException(400,$msg);
    }
	public static function le($controller,$message,$category='DB Error')
	{
		self::logError($category .' :: ' .$message,$controller->id.$controller->action->id);
	}
    public static function successFlash($message)
    {
        Yii::app()->user->setFlash('success', $message);
    }
    public static function errorFlash($message)
    {
        Yii::app()->user->setFlash('error', $message);
    }
    public static function logDebug($message)
    {
        Yii::log($message,'info','debug');
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
		//$time = time();
        
        return date("Y-m-d H:i:s", time());
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
    public static function createDbCommand($sql)
    {
        return Yii::app()->db->createCommand($sql);
        
    }
    /*
     * Check whether date is on weekend
     * 
     * ISO-8601 numeric representation of the day of the week (added in PHP 5.1.0)
     * 1 (for Monday) through 7 (for Sunday)
     * 
     * @param date date to be checked
     */
     
    public static function isWeekend($date) 
    {
        return (date('N', $date->getTimestamp()) >= 6);
    }
    
    public static function iconLink($text,$url,$icon,$htmlOptions=array())
    {
        if($url!=='')
            $htmlOptions['href']=CHtml::normalizeUrl($url);
        $link = 
        $buff = CHtml::tag('a',$htmlOptions,'',false);
        $buff .= CHtml::tag('i',array('class'=>'cus-'.strtolower($icon)),'',true);
        $buff .= $text;
        $buff .= CHtml::closeTag('a');
        return $buff;
    }
    public static function calculateOverdue($patron,$accessionId,$dueDate,$library)
    {
        $diff = 0;
        $rules = CirculationRule::getRule($patron,$accessionId,$library);
        $periodType='';
        foreach ($rules as $row)
        {
            
            $due = $row['loan_period'];
            $periodType = $row['period_type'];
            
            if ($row['ruletype'] == 'exact') //we found exact rule, use it and get out
                break;
            
        }
        if ($periodType == CirculationRule::PERIOD_DAY)
        {
            $diff = self::dateDiffInDays($dueDate,date('Y-m-d H:i:s'));
            return $diff;
        }
        
    }
    /**
     * calculate and return fine for an overdue catalog item
     * @param patron patron card id or user name
     * @param accessionId accession id
     * @param dueDate original due date
     * @library the library id
     * 
     */
    public static function calculateFine($patron,$accessionId,$dueDate,$library)
    {
        $rules = CirculationRule::getRule($patron,$accessionId,$library);
         //we could have default rule and/or the exact rule
        $due='';
        $periodType='';
        $gracePeriod='';
        $finePerPeriod='';
        $maxFine='';
        $fines = array();
        $newDue='';
        $isMaxFine = false;
        foreach ($rules as $row)
        {
            
            $due = $row['loan_period'];
            $periodType = $row['period_type'];
            $gracePeriod = $row['grace_period'];
            $finePerPeriod= $row['fine_per_period'];
            $maxFine = $row['max_fine'];
            if ($row['ruletype'] == 'exact') //we found exact rule, use it and get out
                break;
            
        }
        $pos = strpos($gracePeriod,',');
        if ($pos) 
        {
            $newDue ='';
            $periods = explode(',',$gracePeriod);
            for ($graceCount = 0;$graceCount < count($periods);$graceCount++)
            {
                $period = $periods[$graceCount];
                $totalGrace =$period;
                
                //calculate new due date based on grace period
                for ($graceIdx = $graceCount-1;$graceIdx == 0; $graceIdx--)
                {
                    $totalGrace += $periods[$graceIdx];
                }
                
                $newDue =  self::addDate($dueDate,$totalGrace,$periodType);
                self::logDebug($newDue->format('Y-m-d H:i:s'));
                self::LogError($newDue->format('Y-m-d H:i:s'),"due");
                
                if ($newDue < new DateTime())
                {
                    if ($graceCount+1 == count($periods)) //exceeds last grace period , set max fine
                        $isMaxFine = true;
                    $fines[$graceCount] = self::getFinePerGracePeriod($finePerPeriod,$graceCount);
                }
                    
            
                
            }
          
            
        }
        $totalFine = 0;
        if ($isMaxFine)
            $totalFine = $maxFine;
        else
        {
            for ($i = 0;$i<count($fines);$i++)
            {
                if (is_numeric($fines[$i]))
                    $totalFine = $totalFine + $fines[$i];
            }
        }
        return  $totalFine;
        
    }
    /**
     * Return fine amount for the specified grace period
     * @param finePerPeriod the fine per grace period,could be comma delimited for multiple grace period, or single value
     * @param graceIndex the index of the grace period
     * 
     */
    private static function getFinePerGracePeriod($finePerPeriod,$graceIndex)
    {
        if (strpos($finePerPeriod,',') > 0)
        {
            $fines = explode(',',$finePerPeriod);
            try{
                $fine = $fines[$graceIndex];
                return $fine;
            } catch (Exception $e)
            {
                return false;
            }
            
        }else
        {
            if (is_numeric($finePerPeriod))
                return $finePerPeriod;
            else
                return false;
            
        }
        
    }
   
    private static function dateDiffInDays($date1,$date2)
    {
         return round(abs(strtotime($date1)-strtotime($date2))/86400);
    }
    private static function addDate($date,$period,$periodType)
    {
        self::LogError($period.':'.$periodType.$date,'debug');
        $newDate = new DateTime($date);
        if ($periodType ==  CirculationRule::PERIOD_DAY)
            $retDate = $newDate->modify('+ '.$period. ' day');
        else
             $retDate->modify('+ ' .$period . ' hour' );
        
        self::LogError($retDate->format('Y-m-d H:i:s'),'debug');
        return $retDate;
    }

}



?>
