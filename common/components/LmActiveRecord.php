<?php
class LmActiveRecord extends CActiveRecord
{

 /*
  DateTimeI18NBehavior - Automatically convert date column for display
  and database saving
 */
	public function behaviors()
	{
    	return array('datetimeI18NBehavior' =>
					array('class' => 'common.extensions.DateTimeI18NBehavior')); 
	}
	

}


?>
