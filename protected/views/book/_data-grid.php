<?php
$this->widget('bootstrap.widgets.TbGridView',
	array(
		 'id' => 'data-grid',
		 'dataProvider' => $model->search(),
		 'filter' => $model,
		 'columns' => array(
			 'title',
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