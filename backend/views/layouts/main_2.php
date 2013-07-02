<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />


	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/grid.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css"/>
	
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="grid">
	<div class="gridrow space-top space-hbot">
			<?php
				echo CHtml::image(Yii::app()->request->baseUrl.'/images/hzlogo_small.jpg','Howzat Creation')
			?>
					
		</div>
	

	<div class="gridrow space-hbot" id="mainmenu">
		<?php $this->widget('bootstrap.widgets.TbNavbar', array(
	'fixed' =>true,
	'collapse'=>true, // requires bootstrap-responsive.css
	'brand'=>'Home',
	'items' => array(
	 array(
	  'class' => 'bootstrap.widgets.TbMenu',
	  'items' => array(
		 array('label'=>'Client', 'items'=> array(
			array('label'=>'View Client', 'url'=>array('/client/index')),
			array('label'=>'Add Client', 'url'=>array('/client/create')),
								 	'',
								 	array('label'=>'Add Contact', 'url'=>array('/contact/create')),
									)
								  ),
							array('label'=>'Invoice', 'items'=> array(
							array('label'=>'Delivery', 'items'=>array(
							 	array('label'=>'Add Delivery', 'url'=>array('/delivery/delivery')),
									array('label'=>'View Delivery', 'url'=>array('invoice/viewquote')),
							 		)
							 	),
						     	array('label'=>'Quotations', 'items'=>array(
							 		array('label'=>'Add Quotation', 'url'=>array('/invoice/quote')),
									array('label'=>'View Quotation', 'url'=>array('invoice/viewquote')),
							 		)
							 	),
							  	array('label'=>'Payment', 'items'=>array(
							     	array('label'=>'Add Payment','url'=>array('/payment/create')),
							     	array('label'=>'View Payment','url'=>array('/payment/index')),
							  		)
								), 					  
							  	array('label'=>'Create Invoice', 'url'=>array('/invoice/invoice')), 					            	array('label'=>'View Invoice', 'url'=>array('/invoice/viewInvoice')),
							  	array('label'=>'Print Invoice/Quotation', 'url'=>array(
															  'invoice/selectInvoice')),
							  	array('label'=>'Search Invoice', 'url'=>array('client/create')),
								)
							),
							 array('label'=>'Inventory', 'items'=>array(
							 	array('label'=>'View Inventory', 'url'=>array(
																'/inventory/index')),
								array('label'=>'Manage Inventory', 'url'=>array(
													'inventory/admin'),
													'visible'=>Yii::app()->user->isAdmin),
							 	)
							 
							 ),
						    array('label'=>'Reports', 'items'=>array(
							 	array('label'=>'Client Statement', 'url'=>array(
																'/invoice/clientStatement')),
								array('label'=>'View Quotation', 'url'=>array('invoice/viewInvoice','q'=>'1')),
							 	)
							 
							 ),
							  array('label'=>'Settings', 'items'=>array(
							 	array('label'=>'Systems', 'url'=>array('/setting/update')),
								array('label'=>'User Management', 'url'=>array('user/index'),
									  'visible'=>Yii::app()->user->isAdmin),
								array('label'=>'Authorization', 'url'=>array('auth/'),
									  'visible'=>Yii::app()->user->isAdmin),
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
	</div><!-- mainmenu -->
	<div class="c12">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	</div>
<div class="gridrow">
	<?php echo $content; ?>
</div>
	<div class="clear"></div>
	<div class="gridrow">
	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?>
	</div><!-- footer -->
	</div>
</div><!-- page -->
<?php
/**
* 
* Promot user about session expiration with and option
* to keep logged in out logout
*/
    $this->widget('ext.timeout-dialog.ETimeoutDialog', array(
        // Get timeout settings from session settings.
        'timeout' => Yii::app()->getSession()->getTimeout(),
        // Uncomment to test.
        // Dialog should appear 20 sec after page load.
        //'timeout' => 80,
        'keep_alive_url' => Yii::app()->controller->createUrl('/site/keepalive'),
        'logout_redirect_url' => Yii::app()->controller->createUrl('/site/logout'),
    ));
?>


</body>
</html>
