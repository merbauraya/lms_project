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
		<div class="container-fluid" id="page">
			<div class="row">
				<div class="page-header" style="text-align:center">
					<h1>Welcome to OPAC</small></h1>
				</div>
			</div>
			
				
			<div class="row">
				<?php echo $content; ?>
			</div>
			<div class="clear"></div>
			<div class="row">
				<div id="footer">
					Copyright &copy; <?php echo date('Y'); ?> by Company LMS Sdn. Bhd.<br/>
					All Rights Reserved.<br/>
				<?php //echo Yii::powered(); ?>
				</div><!-- footer -->
			</div>
		</div>
	</body>
</html>