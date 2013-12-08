<?php

class AuthorController extends Controller
{
	public $actions = array('index', 'update', 'delete');

	public function actionView($id)
	{
		$this->render('view', array('model' => $this->loadModel($id)));
	}
}
