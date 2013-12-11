<?php
$this->breadcrumbs = array('Авторы' => array('index'));

if ($model->isNewRecord) {
	$this->pageTitle = 'Добавить автора';
	$this->breadcrumbs[] = 'Добавить';
} else {
	$this->pageTitle = 'Редактировать автора &laquo;' . $model->name . '&raquo;';
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

<div class="control-group ">
	<label class="control-label">Книги</label>

	<div class="controls">
		<ul class="active-list">
			<?php
			$books = $model->books;
			if (!$books)
				$books[] = null;
			foreach ($books as $book) {
				?>
				<li<?= $book ? '' : ' class="hide"' ?>>
					<?= Chtml::activeHiddenField($model, 'newBooks[]', array('value' => $book ? $book->id : 0)) ?>
					<?= $book ? $book->getLink() : '<a></a>' ?>
					<i class="icon-remove"></i><i class="icon-plus"></i>
				</li>
				<?php
			}
			?>
		</ul>

		<div class="add-item-control">
			<input type="text" class="span2" placeholder="Укажите книгу" data-url="<?= $this->createUrl('/book/dropdown') ?>">
			<div class="dropdown"></div>
		</div>
	</div>
</div>

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
				 'htmlOptions' => array('class' => 'pull-right', 'onclick' => 'return confirm("Вы уверены, что желаете удалить автора?");')
			));
	?>
</div>

<?php $this->endWidget() ?>