	<div class="row-fluid">
		<div class="span2">
			<?php
$this->widget('bootstrap.widgets.TbMenu', array(
				'type' => 'list',
				'items' => array(
								array(
												'label' => 'Related Search',
												'itemOptions' => array(
																'class' => 'nav-header'
												)
								),
								array(
												'label' => 'Home',
												'url' => '#'
								),
								array(
												'label' => 'Library',
												'url' => '#'
								),
								array(
												'label' => 'Applications',
												'url' => '#'
								),
								array(
												'label' => 'Keywords',
												'itemOptions' => array(
																'class' => 'nav-header'
												)
								),
								array(
												'label' => 'Profile',
												'url' => '#'
								),
								array(
												'label' => 'Settings',
												'url' => '#'
								),
								'',
								array(
												'label' => 'Help',
												'url' => '#'
								)
				)
));
?>
		</div>
		<div class="span8">
	<?php	$this->widget('bootstrap.widgets.TbAlert', array(
    'block'=>true, // display a larger alert block?
    'fade'=>true, // use transitions?
    'closeText'=>'×', // close link text - if set to false, no close link is displayed
    'alerts'=>array( // configurations per alert type
	    'success'=>array('block'=>true, 'fade'=>true), // success, info, warning, error or danger
    ),
)); ?>
	
		
			<div id="searchResults">
				<?php
				$this->widget('bootstrap.widgets.TbAlert', array(
								'block' => true, // display a larger alert block?
								'fade' => true, // use transitions?
								'closeText' => '×', // close link text - if set to false, no close link is displayed
								'alerts' => array( // configurations per alert type
												'info' => array(
																'block' => true,
																'fade' => true,
																'closeText' => '×'
												) // success, info, warning, error or danger
								)
				));
				?>
			
				<?php
					if (isset($dataProvider)) 
					{
							$this->widget('bootstrap.widgets.TbGridView', array(
									'id' => 'client-grid',
									'type' => ' ',
									'dataProvider' => $dataProvider,
									'columns' => array(
													array(
													 'name' => 'desc',
													 'header'=>'',
													 'value' => array(
														$this,'gridOpacResult')
														  )
													  )
									));
					}
					?>
			
			
			
				
			</div>
			<!-- content -->
		</div>
		<div class="span2">
			<?php
$this->widget('bootstrap.widgets.TbMenu', array(
				'type' => 'list',
				'items' => array(
								array(
												'label' => 'Related Search',
												'itemOptions' => array(
																'class' => 'nav-header'
												)
								),
								array(
												'label' => 'Home',
												'url' => '#'
								),
								array(
												'label' => 'Library',
												'url' => '#'
								),
								array(
												'label' => 'Applications',
												'url' => '#'
								),
								array(
												'label' => 'Keywords',
												'itemOptions' => array(
																'class' => 'nav-header'
												)
								),
								array(
												'label' => 'Profile',
												'url' => '#'
								),
								array(
												'label' => 'Settings',
												'url' => '#'
								),
								'',
								array(
												'label' => 'Help',
												'url' => '#'
								)
				)
));
?>
		</div>
	</div>
