<div class="result catalog-result">
<div class="result result-link">	
<?php		$this->widget('bootstrap.widgets.TbButtonGroup', array(
				'type' => 'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
				'size' => 'small',
				'buttons' => array(
					array('label' => 'View Detail', 
					      'url' => $this->createUrl('catalog/view',array('id'=>$data->id))), // this makes it split :)
					array('items' => array(
						array('label' => 'Show Copy', 'url' => '#'),
						array('label' => 'Booking', 'url' => '#'),
						array('label' => 'Recommend This', 'url' => '#'),
						'---',
						array('label' => 'Review', 'url' => '#'),
					)),
				),
		));
	?>
</div>
	<div class="cover">
	<?php
		//svar_dump($row);
		//echo $data->id;
		echo CHtml::imageButton(Yii::app()->baseUrl."/images/nocover/nocover.gif");
		//CHtml::link('',$this->createUrl('catalog/view',array('id'=>$data->id)))
		//echo $data->title_245a;
		//var_dump($data);
	?> </div>
	<div class="book_info">
		<p class="title">
			<?php
				echo CHtml::link($data->title_245a,$this->createUrl('catalog/view',array('id'=>$data->id)))
			?>
		</p>
		<p>Full title: <?php echo $data->title_245a.' '. $data->title_245b. ' ' . $data->title_245c ;?>
		</p>
		<p>By <?php
				
			?>
		</p>
		<p>
			Published by: <?php  echo $data->publisher; ?>
			
		</p>
			<p>
			Published Date: <?php  echo
			(isset($data->year_publish)) ? $data->year_publish : 'Not available';
			//echo (if(isset($data->year_publish)) ? $data->year_publish : 'Not available') ; 
			?>
			
		</p>
	</div>
	
</div>
