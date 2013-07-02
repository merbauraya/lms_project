<div class="span12">
	<div class="form-wrapper">
	
		<?php
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
					'id' => 'inlineForm',
					'type' => 'inline',
					'method' => 'get',
					'clientOptions' => array(
									'validateOnSubmit' => true
					),
					'htmlOptions' => array(
									'class' => 'well'
					)
	));
	?>
	
	<div class="input-prepend">
		<span class="add-on">
			<i class="icon-search"></i>
		</span>
		<input class="span4" placeholder="Enter your search" name="q" id=q" type="text" />
	</div>

	<?php
	$this->widget('bootstrap.widgets.TbButton', array(
					'buttonType' => 'submit',
					'label' => 'GO',
					'htmlOptions' => array(
									'name' => 'go'
					)
	));
	?>
 
	<?php
	$this->endWidget();
	?>
	
		
	</div>
	<div class="row">
		<div class="span10">
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
</div>