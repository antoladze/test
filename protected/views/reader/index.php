<?php
$this->pageTitle = 'Читатели';

$this->breadcrumbs = array(
	'Читатели',
);

$this->widget('bootstrap.widgets.TbButton',
	array(
		 'label' => 'Добавить читателя',
		 'icon' => 'plus',
		 'url' => array('update'),
	));

$this->renderPartial('_data-grid', array('model' => $model));
