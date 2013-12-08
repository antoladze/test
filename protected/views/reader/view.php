<?php
$this->breadcrumbs = array('Читатели' => array('index'), $model->name);
$this->pageTitle = 'Читатель &laquo;' . $model->name . '&raquo;';

echo $this->getNavTabs('view', $model);

$this->widget('bootstrap.widgets.TbDetailView',
	array(
		 'data' => $model,
		 'attributes' => array(
			 'name',
			 'create:datetime',
			 'update:datetime',
		 ),
	));
