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
	<!link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	
		<?php
	Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl.'/js/common.js'); ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div id="page">

	

	<div class="row" id="mainmenu">
		<?php $this->widget('bootstrap.widgets.TbNavbar', array(
	
	'collapse'=>true, // requires bootstrap-responsive.css
	'brand'=>'Home',
    'fixed' => false,
	'items' => array(
	 array(
	  'class' => 'bootstrap.widgets.TbMenu',
	  'items' => array(
			array('label'=>'Cataloging', 'items'=>array(
			 	array('label'=>'New Catalog', 'items'=>array(
					array('label'=>'Catalog Template', 'url'=>array(
													'/catalog/createbytemplate')),
					array('label'=>'Upload Marc', 'url'=>array(
													'/catalog/upload')),
					array('label'=>'Copy Cataloging', 'items'=>array(
						array('label'=>'Z3950 SRU','url'=>array('/catalog/z3950sru')),							
						array('label'=>'Z3950 Service', 'url'=>array(
													'/catalog/z3950')),									
						array('label'=>'OAI/PMH', 'url'=>array(
													'/catalog/oaipmh')),	
						),
					),
													
				)),
				
				array('label'=>'Authorities', 'url'=>array('authority/create')),										
				'___',
                
                array('label'=>'Import Marc', 'items'=>array(
                    array('label'=>'Import Bibliography','url'=>array('/catalog/importbiblio')),							
                    array('label'=>'Import Authority', 'url'=>array(
                                                '/catalog/importauth')),									
                    	
                    ),
                ),
				'___',
                array('label'=>'Search Catalog', 'url'=>array('catalog/search','q'=>'1')),
				'___',
				array('label'=>'New Items', 'url'=>array(
													'/catalogitem/create')),	
				
				)
			),
			array('label'=>'Acquisition', 'items'=>array(
			 	array('label'=>'Suggestion','items'=>array(
					array('label'=>'New Suggestion','url'=>
					array('acquisitionSuggestion/create')),
					array('label'=>'List Suggestion','url'=>array('acquisitionSuggestion/index')),
					)),
					
			array('label'=>'Request','items'=>array(
					array('label'=>'New Request','url'=>
					array('acquisitionRequest/create')),
					array('label'=>'List Request','url'=>array('acquisitionRequest/index')),
					'___',
					array('label'=>'Request Approval','url'=>array('acquisitionRequest/approvallist')),
					)),
				
				
				
				'___',
			array('label'=>'Purchase Order','items'=>array(
					array('label'=>'New Purchase Order','url'=>'/purchaseorder/create'),
					array('label'=>'Purchase Order List','url'=>
					'/purchaseorder/index'),
					'___',
					array('label'=>'Release Purchase Order','url'=>
					'/purchaseorder/release'),
				)
				
				),
			array('label'=>'Receiving','items'=>array(
			array('label'=>'New Purchase Order','url'=>'/purchaseorder/create'),
			array('label'=>'Purchase Order List','url'=>
			'/purchaseorder/index'),
			'___',
			array('label'=>'Release Purchase Order','url'=>
			'/purchaseorder/release'),
			)
			
			),	
			)
							 
		),
			array('label'=>'Circulation', 'items'=>array(
			 	array('label'=>'Checkout', 'url'=>array(
											'/circulation/checkout')),
				array('label'=>'Check In', 'url'=>array(
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
			array('label'=>'Serial', 'items'=>array(
			 	array('label'=>'Client Statement', 'url'=>array(
																'/invoice/clientStatement')),
				array('label'=>'View Quotation', 'url'=>array('invoice/viewInvoice')),
							 	)
			),
	
			array('label'=>'Settings', 'items'=>array(
			 	array('label'=>'Systems', 'url'=>array('/setting/update')),
				array('label'=>'Budget','items'=>array(
					array('label'=>'Budget Account','url'=>
						array('budgetaccount/admin')),
					array('label'=>'Budget Transaction Type','url'=>
						array('budgettransactionType/admin')),
					array('label'=>'Budget Source','url'=>
						array('budgetsource/admin')),
					array('label'=>'Budget Transaction','url'=>
						array('budgettransaction/admin')),
					
					)),
				array('label'=>'Patron Management', 'items'=>array(
						array('label'=>'Patron Category','url'=>
							array('patroncategory/admin')),
						array('label'=>'Patron Status','url'=>
							array('patronstatus/admin')),
						array('label'=>'Create Patron','url'=>
							array('patron/create')),
						array('label'=>'Manage Patron','url'=>
							array('patron/admin')),
						array('label'=>'Patron Authorization','url'=>
							array('auth/')),
						)
				
				),
				array('label'=>'Circulation', 'items'=>array(
					array('label'=>'Circulation Rule','url'=>
						array('circulationrule/admin')),
					)
				),
				array('label'=>'Authorization', 'url'=>array('auth/')),
				array('label'=>'Cataloging', 'items'=>array(
					array('label'=>'Bibliography Template','url'=>
						array('catalogTemplate/catalogtype')),
                    array('label'=>'Authority Template','url'=>
						array('authority/authoritytype')),    
					)
				),
				
			)),
			array('label'=>'Report', 'items'=>array(
			 	array('label'=>'Budget','items'=>array(
					array('label'=>'Budget Summary','url'=>
						array('budgetaccount/admin')),
					array('label'=>'Budget Comparison','url'=>
						array('budgettransactionType/admin')),
					array('label'=>'Budget Utilisation','url'=>
						array('budgetsource/admin')),
					array('label'=>'Budget Transaction','url'=>
						array('budgettransaction/admin')),
					
					)),
				array('label'=>'Expenditure', 'items'=>array(
					array('label'=>'Analysis','url'=>
						array('budgetaccount/admin')),
				
				
					)
				),
				array('label'=>'Authorization', 'url'=>array('auth/')),
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
	<div class="span12">

	</div> <!--span12-->
	<section class="main-body">
		<div class="container">
			<div class="row-fluid">
				<?php echo $content; ?>
			</div> <!--row-fluid-->
		</div>
	</section>
<div class="clear"></div>
<div class="row-fluid">
	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by Merbau LMS Sdn. Bhd.<br/>
		All Rights Reserved.<br/>
		<?php //echo Yii::powered(); ?>
	</div><!-- footer -->
	</div> <!--row-->
</div><!-- page container -->

</body>
</html>
