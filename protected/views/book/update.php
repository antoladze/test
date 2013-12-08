<?php
$this->breadcrumbs = array('Книги' => array('index'));

if ($model->isNewRecord) {
	$this->pageTitle = 'Добавить книгу';
	$this->breadcrumbs[] = 'Добавить';
} else {
	$this->pageTitle = 'Редактировать книгу &laquo;' . $model->title . '&raquo;';
	$this->breadcrumbs[$model->title] = array('view', 'id' => $model->id);
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

<?= $form->textFieldRow($model, 'title', array('class' => 'span5', 'maxlength' => 128)) ?>

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
				 'htmlOptions' => array('class' => 'pull-right', 'onclick' => 'return confirm("Вы уверены, что желаете удалить данную книгу?");')
			));
	?>
</div>

<?php $this->endWidget() ?>