<?php
$this->pageTitle = 'Авторы';

$this->breadcrumbs = array(
	'Авторы',
);

$this->widget('bootstrap.widgets.TbButton',
	array(
		 'label' => 'Добавить автора',
		 'icon' => 'plus',
		 'url' => array('update'),
	));

$this->renderPartial('_data-grid', array('model' => $model));
