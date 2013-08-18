<?php

class LibraryController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}
    /**
     * 
     * Create new user. If successfull, user will be redirected to view page
     * 
     * 
     */ 
    
    /**
	 * Displays a particular model.
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		$this->render('view',array(
			'model'=>$model,
		));
	}
    public function actionRegisteredPatron()
    {
        $model = new ReportModel();
        if (isset($_GET['ReportModel']))
        {
            $model->attributes = $_GET['ReportModel'];
            $_d = explode('-',$model->daterange);
            $range = LmUtil::ConvertToDBDate($_d);
            $start = $range[0];
            $end = $range[1];
            
            $sql = 'select 1 as id,count(*) as total,department_id,b.name as dept_name,
					to_char(a.date_created,\'YYYY\') || to_char(a.date_created,\'MM\') as period

					from patron a,department b,patron_category c
					where 
					a.library_id = :id
					and a.patron_category_id = :category
					and patron_category_id = c.id
					and department_id = b.id 
					and a.date_created between :start and :end 
					and department_id is not null
					group by department_id,b.name,period';

			$count = 5;
			$dp=new CSqlDataProvider($sql,array(
				'totalItemCount'=>$count,
				'params'   => array(':id'=>$model->library_id,
									':category'=>$model->patron_category_id,
									':start'=>$start,
									':end'=>$end),
				'pagination' => array(
							'pageSize' => '20',
						)
					)
			);
			$columns = array(
				array('name'=>'dept_name','header'=>'Department'),
				array('name'=>'period','header'=>'Registration Period'),
				array('name'=>'total','header'=>'Member Total'),
			);
			$title = 'Membership registration by department';
			
			$export = isset($_GET['export']) ? $_GET['export'] : 'view';
			if ($export == 'view')
				$this->renderReport($dp,$columns,$title);
			else
            {
				$exportType = isset($_GET['exportType']) ? $_GET['exportType'] : 'Excel2007';
                $this->exportReport($dp,$columns,$title,$exportType);
            }
            
        }else
        
        {
			if (isset($_REQUEST['exportType'])) //we are exporting report
			{
				
				
			}else
				$this->render('registeredpatron',array('model'=>$model));
		}
    }
    protected function exportReport($dataProvider,$columns,$subject,$exportType)
    {
		
		echo $exportType;
        $this->widget('tlbExcelView', array(
			'dataProvider'=> $dataProvider,
			'id'=>'report-grid',
			'title'=>'report',
			'grid_mode'=>'export',
			'disablePaging'=>true,
			'autoWidth'=>false,
			'subject'=>$subject,
			'sheetTitle'=>'SheetTitle',
			'exportType' =>$exportType,
			//'export'=>'export',
			'columns'=>$columns,
			//'template'=>"{summary}\n{items}\n{exportbuttons}\n{pager}",
			'libPath'=>'extcommon.phpexcel.Classes.PHPExcel'
));
		
	}
    protected function renderReport($dataProvider,$columns,$title)
    {
		
		$this->widget('tlbExcelView', array(
			'dataProvider'=> $dataProvider,
			'title'=>'report',
			'autoWidth'=>false,
			'subject'=>$title,
            'grid_mode'=>'grid',
			//'exportType' =>'Excel2007',
			'exportButtons'=>array('Excel2007','PDF','CSV','HTML'),
			//'type'=>'bordered condensed stripped',
			'columns'=>$columns,
			'template'=>"{summary}\n{items}\n{exportbuttons}\n{pager}",
			'libPath'=>'extcommon.phpexcel.Classes.PHPExcel'
));
		
	}
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='patron-form')
        {
                echo CActiveForm::validate($model);
                Yii::app()->end();
        }
    }

}
