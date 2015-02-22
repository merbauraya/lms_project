<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/sprite-icons.css" />

	<?php
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/common.js'); 
        Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/jquery.nicescroll.min.js'); 
    ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>


	

	
		<?php $this->widget('bootstrap.widgets.TbNavbar', array(
	
	'collapse'=>true, // requires bootstrap-responsive.css
	'brand'=>'Home',
    'fixed' => 'top',
    'type' =>'inverse',
	'items' => array(
	 array(
	  'class' => 'bootstrap.widgets.TbMenu',
	  'items' => array(

			array('label'=>'Library', 'items'=>array(
			 	array('label'=>'Registered Patron', 'url'=>array(
											'/report/library/registeredPatron')),
				array('label'=>'Patron by Status', 'url'=>array(
											'circulation/checkin'),
													),
				array('label'=>'Renewal', 'url'=>array(
											'circulation/renewal'),
													),													
				array('label'=>'Reservation', 'url'=>array(
											'circulation/reservation'),
													),
				array('label'=>'Recall', 'url'=>array(
											'circulation/reservation'),
													),							
				)
							 
			),
		
			array('label'=>'Catalog', 'items'=>array(
			 	array('label'=>'Non Indexed Catalog', 'url'=>array(
											'/report/catalog/NonIndex')),
				array('label'=>'Summary By SMD', 'url'=>array(
											'circulation/checkin'),
													),
				array('label'=>'Renewal', 'url'=>array(
											'circulation/renewal'),
													),													
				array('label'=>'Reservation', 'url'=>array(
											'circulation/reservation'),
													),
				array('label'=>'Recall', 'url'=>array(
											'circulation/reservation'),
													),							
				)
							 
			),
            
			array('label'=>'Circulation', 'items'=>array(
			 	array('label'=>'Overdue Item', 'url'=>array(
											'/report/circulation/overdue')),
				array('label'=>'Summary by Category', 'url'=>array(
											'circulation/checkin'),
													),
				array('label'=>'Renewal', 'url'=>array(
											'circulation/renewal'),
													),													
				array('label'=>'Reservation', 'url'=>array(
											'circulation/reservation'),
													),
				array('label'=>'Recall', 'url'=>array(
											'circulation/reservation'),
													),							
				)
							 
			),
            array('label'=>'Acquisition', 'items'=>array(
			 	array('label'=>'Received vs Release', 'url'=>array(
											'/report/circulation/overdue')),
				array('label'=>'Summary by Category', 'url'=>array(
											'circulation/checkin'),
													),
				array('label'=>'Renewal', 'url'=>array(
											'circulation/renewal'),
													),													
				array('label'=>'Reservation', 'url'=>array(
											'circulation/reservation'),
													),
				array('label'=>'Recall', 'url'=>array(
											'circulation/reservation'),
													),							
				)
							 
			),
  			 
			array('label'=>'Login', 'url'=>array(
							 		'/site/login'), 
									'visible'=>Yii::app()->user->isGuest),
		    	array('label'=>'Logout ('.Yii::app()->user->name.')', 
							 		'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),

		            

					 
					 
			)
		)
	)
)); 

?>

<!-- close any jui dialog when click elsewhere -->
<script type="text/javascript">	
	$(document).ready(function()
{
    $(document.body).on("click", ".ui-widget-overlay", function()
    {
        $.each($(".ui-dialog"), function()
        {
            var $dialog;
            $dialog = $(this).children(".ui-dialog-content");
            if($dialog.dialog("option", "modal"))
            {
                $dialog.dialog("close");
            }
        });
    });;
});
</script>	
		<div class="container main-content">
			<div class="row-fluid">
				<?php echo $content; ?>
			</div> <!--row-fluid-->
		
	

<div class="row-fluid">
	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Merbau LMS Sdn. Bhd.<br/>
		All Rights Reserved.<br/>
		<?php //echo Yii::powered(); ?>
	</div><!-- footer -->
	</div> <!--row-->
  </div>  

</body>
</html>
<?php
    $this->widget('extcommon.loading.LoadingWidget');

?>
