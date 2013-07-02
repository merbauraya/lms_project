<?php
/* @var $this TestController */

$this->breadcrumbs=array(
	'Test',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>


<div class="row-fluid">
	<div class="span12">
		<span title="LEADER" class="marc-tag">000</span>
		<a href="#" onclick="expandTag();"> INTERNATIONAL STANDARD BOOK NUMBER</a>
		<div class="row-fluid" >
			<div class="span4">
				<span title="LEADER" class="marc-tag" style="float:left;">a</span>
				<label style="text-align:right;" class="control-label" for="020-__-a-3">International Standard Book Number</label>	
			</div>
				<div class="span8">
				<input type="text" class="span5">
				</div>
			
		</div>
		<div class="row-fluid" >
			<div class="span4">
				<span title="LEADER" class="marc-tag" style="float:left">b</span>
				<label style="text-align:right;" class="control-label" for="020-__-a-3">International Standard Book Number</label>	
			</div>
				<div class="span8">
				<input type="text" class="span5">
				</div>
			
		</div>
	</div>

</div>