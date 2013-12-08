<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<meta name="language" content="en"/>

	<link rel="stylesheet" type="text/css" href="<?= Yii::app()->theme->baseUrl ?>/css/styles.css"/>

	<title><?= CHtml::encode($this->pageTitle) ?></title>

	<?php Yii::app()->bootstrap->register() ?>
</head>

<body>

<?php $this->widget('bootstrap.widgets.TbNavbar',
	array(
		 'items' => array(
			 array(
				 'class' => 'bootstrap.widgets.TbMenu',
				 'items' => array(
					 array('label' => 'Читатели', 'url' => array('/reader')),
					 array('label' => 'Книги', 'url' => array('/book')),
					 array('label' => 'Авторы', 'url' => array('/author')),
					 array('label' => 'Отчеты', 'url' => array('/report')),
				 ),
			 ),
		 ),
	)) ?>

<div class="container" id="page">

	<?php if (isset($this->breadcrumbs)) $this->widget('bootstrap.widgets.TbBreadcrumbs', array('links' => $this->breadcrumbs)) ?>

	<?= $content ?>
</div>

</body>
</html>
