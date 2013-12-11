<?php
$this->pageTitle = 'Отчет #3';
$this->breadcrumbs = array('Отчёты');
echo $this->getNavTabs(3);
?>

<p>Пять случайных книг.</p>

<?php
$this->widget('bootstrap.widgets.TbGridView',
	array(
		 'id' => 'data-grid',
		 'dataProvider' => $model->report3(),
		 'enableSorting' => false,
		 'htmlOptions' => array('style' => 'padding-top:0;'),
		 'columns' => array(
			 array(
				 'header' => 'Книга',
				 'name' => 'title',
			 ),
			 array(
				 'header' => 'Авторы',
				 'value' => 'implode(", ", $data["authors"])',
			 ),
			 array(
				 'header' => 'Читатели',
				 'value' => 'implode(", ", $data["readers"])',
			 ),
		 ),
		 'type' => 'bordered striped',
	));