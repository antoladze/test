<?php
$this->breadcrumbs = array('Книги' => array('index'), $model->title);
$this->pageTitle = 'Книга &laquo;' . $model->title . '&raquo;';

echo $this->getNavTabs('view', $model);

$this->widget('bootstrap.widgets.TbDetailView',
	array(
		 'data' => $model,
		 'attributes' => array(
			 'title',
			 'create:datetime',
			 'update:datetime',
			 array(
				'label' => 'Авторы',
				'type' => 'html',
				 'value' => $model->getAuthors('<br>'),
			 ),
			 array(
				 'label' => 'На руках',
				 'type' => 'html',
				 'value' => $model->getReaders('<br>'),
			 ),
		 ),
	));