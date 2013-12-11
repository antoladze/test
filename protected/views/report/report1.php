<?php
$this->pageTitle = 'Отчет #1';
$this->breadcrumbs = array('Отчёты');
echo $this->getNavTabs(1);
?>

<p>Список книг, находящихся на руках у читателей, и имеющих не менее трех со-авторов.</p>

<?php
$this->widget('bootstrap.widgets.TbGridView',
	array(
		 'id' => 'data-grid',
		 'dataProvider' => $model->report1(),
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