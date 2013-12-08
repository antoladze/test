<?php
$this->pageTitle = 'Ошибка ' . $code;
?>

<h2><?= 'Ошибка ' . $code ?></h2>

<div class="error">
	<?= CHtml::encode($message) ?>
</div>
<br>
<?php $this->widget('bootstrap.widgets.TbButton',
	array(
		 'url' => 'javascript:window.history.back()',
		 'size' => 'large',
		 'label' => 'Назад',
		 'icon' => 'circle-arrow-left',
	)) ?>