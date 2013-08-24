<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css"/>


	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
		<!--<div style="margin-bottom:20px;margin-top: 100px;">	
		<div class="center_wrapper" class="span3"> -->
        <div class="row">
            <div class="span6 offset3">

        
			
			<?php echo $content; ?>
		</div><!-- content -->
		</div>
</body>
</html>
