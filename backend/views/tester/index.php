<?php
/* @var $this TesterController */

$this->breadcrumbs=array(
	'Tester',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>

<form action="/tester/AjaxGetPatron" method="get">
    <input type="hidden" name="term" value ="haf">
    <input type="hidden" name="page_limit" value="10">
    <input type="submit">
    <input type="hidden" name="ret" value="uname">

</form>
