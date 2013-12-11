<?php
$this->widget('bootstrap.widgets.TbGridView',
	array(
		 'id' => 'data-grid',
		 'dataProvider' => $model->search(),
		 'filter' => $model,
		 'columns' => array(
			 'name',
			 array(
				 'header' => 'Книги',
				 'type' => 'html',
				 'value' => '$data->getBooks()',
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
				 'deleteConfirmation' => 'Вы уверены, что желаете удалить автора?',
			 ),
		 ),
		 'type' => 'bordered striped condensed',
	));