<?php

$model = new AcquisitionSuggestion;
if ($status != 0)
    $model->status = $status;
$this->widget('bootstrap.widgets.TbGridView', array(
    'type' => 'striped bordered condensed',
    'dataProvider' => $model->search(),
    'template' => "{items}\n{pager}",
    'columns' => array(
        array(
            'name' => 'title',
            'header' => 'Title'
        ),
        
        array(
            'name' => 'author',
            'header' => 'Author'
        ),
        array(
            'name' => 'isbn_issn',
            'header' => 'ISBN/ISSN'
        ),
        array(
            'name' => 'publisher',
            'header' => 'Publisher'
        ),
        array(
            'name' => 'suggested_by',
            'header' => 'By'
        ),
        array(
            'name' => 'budget_id',
            'header' => 'Budget',
            'value' => '$data->budget->name'
        ),
        array(
            'name' => 'suggest_date',
            'header' => 'Suggestion Date'
        ),
        array(
            'name' => 'status',
            'header' => 'Status',
            'value' => array(
                $this,
                'showTextStatus'
            )
        ),
        array(
            'header' => '',
            'value' => function()
            {
                Yii::app()->controller->widget('bootstrap.widgets.TbButtonGroup', array(
                    'size' => 'medium',
                    'type' => 'primary',
                    'buttons' => array(
                        array(
                            'label' => 'Action',
                            'items' => array(
                                array(
                                    'label' => 'Approved',
                                    'url' => '#'
                                ),
                                array(
                                    'label' => 'Rejected',
                                    'url' => '#'
                                ),
                                array(
                                    'label' => 'Keep in View',
                                    'url' => '#'
                                ),
                                '---',
                                array(
                                    'label' => 'Delete',
                                    'url' => '#'
                                )
                            )
                        )
                    )
                ));
            }
            
        )
    )
));

?>