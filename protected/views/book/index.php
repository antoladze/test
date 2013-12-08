<?php
$this->pageTitle = 'Книги';

$this->breadcrumbs = array(
	'Книги',
);

$this->widget('bootstrap.widgets.TbButton',
	array(
		 'label' => 'Добавить книгу',
		 'icon' => 'plus',
		 'url' => array('update'),
	));

$this->renderPartial('_data-grid', array('model' => $model));
