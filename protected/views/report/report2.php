<?php
$this->pageTitle = 'Отчет #2';
$this->breadcrumbs = array('Отчёты');
echo $this->getNavTabs(2);
?>

<p>Список авторов, чьи книги в данный момент читает более трех читателей.</p>

<?php
$this->widget('bootstrap.widgets.TbGridView',
	array(
		 'id' => 'data-grid',
		 'dataProvider' => $model->report2(),
		 'enableSorting' => false,
		 'htmlOptions' => array('style' => 'padding-top:0;'),
		 'columns' => array(
			 array(
				 'header' => 'Автор',
				 'name' => 'name',
			 ),
			 array(
				 'header' => 'Книги',
				 'value' => 'implode(", ", $data["books"])',
			 ),
		 ),
		 'type' => 'bordered striped',
	));