<section id="navigation-main">  
<div class="navbar">
	<!--<div class="navbar-inner">
    <div class="container"> -->
       <!-- <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a> -->
  
          
		  <?php $this->widget('bootstrap.widgets.TbNavbar', array(
	
	'collapse'=>true, // requires bootstrap-responsive.css
	'brand'=>'<img src="/img/home.png" alt="Home" width="32" height="32">',
	'fixed'=>true,
	'items' => array(
	 array(
	  'class' => 'bootstrap.widgets.TbMenu',
	  'items' => array(
			
		 	array('label'=>'Bibliography', 'items'=> array(
				array('label'=>'Index', 'url'=>array('/catalog/index')),
				array('label'=>'New Bibliography', 'url'=>array('/catalog/create')),
				'___',
				array('label'=>'Add Contact', 'url'=>array('/contact/create')),
									)
								  ),
			array('label'=>'Circulation', 'items'=> array(
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
			array('label'=>'Membership', 'items'=>array(
			 	array('label'=>'View Inventory', 'url'=>array(
																'/inventory/index')),
				array('label'=>'Manage Inventory', 'url'=>array(
													'inventory/admin'),
													),
							 	)
							 
							 ),
			array('label'=>'Serial', 'items'=>array(
			 	array('label'=>'Client Statement', 'url'=>array(
																'/invoice/clientStatement')),
				array('label'=>'View Quotation', 'url'=>array('invoice/viewInvoice','q'=>'1')),
							 	)
							 
							 ),
			array('label'=>'News & Event', 'items'=>array(
			 	array('label'=>'Calendar', 'url'=>array(
																'/invoice/clientStatement')),
				array('label'=>'Blog', 'url'=>array('invoice/viewInvoice','q'=>'1')),
				array('label'=>'Facebook', 'url'=>'http://www.facebook.com/pages/Perpustakaanuitm/409911212624'),
				array('label'=>'Twitter', 'url'=>'http://www.facebook.com/pages/Perpustakaanuitm/409911212624'),
							 	)
							 
							 ),
			array('label'=>'About Us', 'items'=>array(
			 	array('label'=>'Vision and Mission', 'url'=>array('/setting/update')),
				array('label'=>'History', 'url'=>array('user/index')),
				array('label'=>'Membership', 'url'=>array('user/index')),
				array('label'=>'Circulation Policies', 'url'=>array('auth/')),
				array('label'=>'Library Systems', 'url'=>array('auth/')),								
							 )
							 
							 ),
			
			array('label'=>'Login', 'url'=>array(
							 		'/site/login'), 
									'visible'=>Yii::app()->user->isGuest),
		    	array('label'=>'Logout ('.Yii::app()->user->name.')', 
							 		'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
					 
			)
		),
		'<form class="navbar-search pull-right" action="/index.php/opac/index" method="get">
        <input name="q" type="text" class="search-query" placeholder="search">
		 </form>'
		
	)
)); 

?>
	



			
    	
   <!-- </div>
	</div> -->
</div>

</section><!-- /#navigation-main -->
