<?php
class AcqSuggestionView extends CWidget
{
	public $status = 0; //load all suggestion
	public function run()
	{
		$this->render('acqsuggestionview')
	}
}

?>