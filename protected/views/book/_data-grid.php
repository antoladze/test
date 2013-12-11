<?php
$this->widget('bootstrap.widgets.TbGridView',
	array(
		 'id' => 'data-grid',
		 'dataProvider' => $model->search(),
		 'filter' => $model,
		 'columns' => array(
			 'title',
			 array(
				 'header' => 'Авторы',
				 'type' => 'html',
				 'value' => '$data->getAuthors()',
			 ),
			 array(
				 'header' => 'На руках',
				 'type' => 'html',
				 'value' => '$data->getReaders()',
			 ),
			 array(
				 'name' => 'create',
				 'type' => 'datetime',
				 'filter' => DbCriteria::$ranges,
			 ),
			 array(
				 'name' => 'update',
				 'type' => 'datetime',
				 'filter' => DbCriteria::$ranges,
			 ),
			 array(
				 'class' => 'bootstrap.widgets.TbButtonColumn',
				 'deleteConfirmation' => 'Вы уверены, что желаете удалить данную книгу?',
			 ),
		 ),
		 'type' => 'bordered striped condensed',
	));