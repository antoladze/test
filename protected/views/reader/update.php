<?php
$this->breadcrumbs = array('Читатели' => array('index'));

if ($model->isNewRecord) {
	$this->pageTitle = 'Добавить читателя';
	$this->breadcrumbs[] = 'Добавить';
} else {
	$this->pageTitle = 'Редактировать читателя &laquo;' . $model->name . '&raquo;';
	$this->breadcrumbs[$model->name] = array('view', 'id' => $model->id);
	$this->breadcrumbs[] = 'Редактировать';

	echo $this->getNavTabs('update', $model);
}
?>

<?php $this->widget('bootstrap.widgets.TbAlert') ?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',
	array(
		 'id' => 'data-form',
		 'type' => 'horizontal',
		 'enableClientValidation' => true,
	)) ?>

<?= $form->errorSummary($model) ?>

<?= $form->textFieldRow($model, 'name', array('class' => 'span5', 'maxlength' => 64)) ?>

<div class="form-actions">
	<?php
	$this->widget('bootstrap.widgets.TbButton',
		array(
			 'buttonType' => 'submit',
			 'type' => 'primary',
			 'label' => $model->isNewRecord ? 'Добавить' : 'Сохранить',
			 'icon' => 'ok white',
		));
	if (!$model->isNewRecord)
		$this->widget('bootstrap.widgets.TbButton',
			array(
				 'url' => array('delete', 'id' => $model->id),
				 'label' => 'Удалить',
				 'type' => 'warning',
				 'icon' => 'trash white',
				 'htmlOptions' => array('class' => 'pull-right', 'onclick' => 'return confirm("Вы уверены, что желаете удалить читателя?");')
			));
	?>
</div>

<?php $this->endWidget() ?>