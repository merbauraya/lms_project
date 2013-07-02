<section class="main-body">    
	<div class="container">
	<div class="row-fluid">
		<div class="span3">
<?php			
// we render login form if user is not logged on/guest
if (Yii::app()->user->isGuest)
{
	

	$this->widget('bootstrap.widgets.TbBox', array(
    'title' => 'Login',
    'headerIcon' => 'icon-user',
    'content' => $this->renderPartial('login',array('model'=>$patron),true)
	));
} else //authenticated user, we show my library widget
{
	$x = '250000.20';
	$val =  Yii::app()->format->formatNumber($x);
	$this->widget('bootstrap.widgets.TbBox', array(
    'title' => 'My Library',
    'headerIcon' => 'icon-user',
    'content' =>'Test '.$val ,
	));
}	
	
 ?>

<?php			

	$this->widget('bootstrap.widgets.TbBox', array(
    'title' => 'Online Apps',
    'headerIcon' => 'icon-road',
    'content' => $this->renderPartial('_online',null,true) ,
	
	
)); ?>

<?php			

	$this->widget('bootstrap.widgets.TbBox', array(
    'title' => 'Resources',
    'headerIcon' => 'icon-qrcode',
    'content' => $this->renderPartial('_online',null,true) 
	
	
)); ?>
		</div>
		<div class="span9">
					
<?php			
	$this->renderPartial('_latest_portlet',array('model'=>$patron),true);
	
	$this->widget('bootstrap.widgets.TbBox', array(
    'title' => 'Latest...',
    'headerIcon' => 'icon-th',
    'content' => $this->renderPartial('_latest_portlet',array('model'=>$patron),true) ,
	
	
)); ?>
	<?php			

	$this->widget('bootstrap.widgets.TbBox', array(
    'title' => 'Access',
    'headerIcon' => 'icon-bookmark',
    'content' => $this->renderPartial('_access',array('model'=>$patron),true) ,
	
	
)); ?>	
	</div>
	
          
		</div><!--/row-fluid-->
	</div> <!-- container -->
 </section>       
   