<?php
$this->menu = array(
    array(
        'label' => 'Biblio',
        'itemOptions' => array(
            'class' => 'nav-header'
        )
    ),
    array(
        'label' => 'Add Biblio',
        'url' => Yii::app()->controller->createUrl("biblio/create")
    ),
    array(
        'label' => 'List Biblio',
        'url' => Yii::app()->controller->createUrl("biblio/admin")
    ),
    array(
        'label' => 'Items',
        'itemOptions' => array(
            'class' => 'nav-header'
        )
    ),
    array(
        'label' => 'Create Items',
        'url' => Yii::app()->controller->createUrl("items/invoice")
    ),
    array(
        'label' => 'List Item',
        'url' => Yii::app()->controller->createUrl("item/index")
    ),
    array(
        'label' => 'Data Management',
        'itemOptions' => array(
            'class' => 'nav-header'
        )
    ),
    array(
        'label' => 'MARC Upload',
        'url' => Yii::app()->controller->createUrl("marcUpload/create")
    ),
    array(
        'label' => 'Settings',
        'url' => '#'
    )
    
);
?>