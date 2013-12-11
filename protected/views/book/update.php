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

<div class="control-group ">
	<label class="control-label">Авторы</label>

	<div class="controls">
		<ul class="active-list">
			<?php
			$authors = $model->authors;
			if (!$authors)
				$authors[] = null;
			foreach ($authors as $author) {
				?>
				<li<?= $author ? '' : ' class="hide"' ?>>
					<?= Chtml::activeHiddenField($model, 'newAuthors[]', array('value' => $author ? $author->id : 0)) ?>
					<?= $author ? $author->getLink() : '<a></a>' ?>
					<i class="icon-remove"></i><i class="icon-plus"></i>
				</li>
				<?php
			}
			?>
		</ul>

		<div class="add-item-control">
			<input type="text" class="span2" placeholder="Укажите автора" data-url="<?= $this->createUrl('/author/dropdown') ?>">
			<a href="<?= $this->createUrl('addAuthor') ?>" class="btn hide"><i class="icon-plus"></i></a>
			<div class="dropdown"></div>
		</div>
	</div>
</div>

<div class="control-group ">
	<label class="control-label">Читатели</label>

	<div class="controls">
		<ul class="active-list">
			<?php
			$readers = $model->readers;
			if (!$readers)
				$readers[] = null;
			foreach ($readers as $reader) {
				?>
				<li<?= $reader ? '' : ' class="hide"' ?>>
					<?= Chtml::activeHiddenField($model, 'newReaders[]', array('value' => $reader ? $reader->id : 0)) ?>
					<?= $reader ? $reader->getLink() : '<a></a>' ?>
					<i class="icon-remove"></i><i class="icon-plus"></i>
				</li>
				<?php
			}
			?>
		</ul>

		<div class="add-item-control">
			<input type="text" class="span2" placeholder="Укажите читателя" data-url="<?= $this->createUrl('/reader/dropdown') ?>">
			<a href="<?= $this->createUrl('addReader') ?>" class="btn hide"><i class="icon-plus"></i></a>
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
				 'htmlOptions' => array('class' => 'pull-right', 'onclick' => 'return confirm("Вы уверены, что желаете удалить данную книгу?");')
			));
	?>
</div>

<?php $this->endWidget() ?>