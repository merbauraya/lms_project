<div class="span12">
	<div class="form-wrapper">
	<form id="paste-marc" class="form-horizontal" method="get" action="<?php echo Yii::app()->
			createUrl('/search')?>"
			<div class="control-group ">
				<label class="control-label" for="Invoice_date_entered">Search</label>
				<div class="controls">
					<select name="opac_search" id="Invoice_client_id">
						<option value="1">Catalog</option>
						<option value="2">Title</option>
						<option value="3">Author</option>
						<option value="4">Subject</option>
						<option value="5">ISBN</option>
						<option value="6">Series</option>
						<option value="7">Call Number</option>
					</select>
					<div class="input-append">
						<input type="text" autocomplete="on" name="q"/>
						<span class="add-on"><i class="icon-search"></i></span>
					</div>
					<?php
						echo CHtml::submitButton('GO',array("class"=>
					"btn btn-primary")); ?>
				</div>
			</div>
		</form>
	</div>
	<div class="row">
		<div class="span10">
			<div id="searchResults">
			</div>
			<!-- content -->
		</div>
		<div class="span2">
			<?php $this->
			widget('bootstrap.widgets.TbMenu', array( 'type'=>'list', 'items' => array( array('label'=>'Related Search', 'itemOptions'=>array('class'=>'nav-header')), array('label'=>'Home', 'url'=>'#'), array('label'=>'Library', 'url'=>'#'), array('label'=>'Applications', 'url'=>'#'), array('label'=>'Keywords', 'itemOptions'=>array('class'=>'nav-header')), array('label'=>'Profile', 'url'=>'#'), array('label'=>'Settings', 'url'=>'#'), '', array('label'=>'Help', 'url'=>'#'), ) )); ?>
		</div>
		</div>
		</div>