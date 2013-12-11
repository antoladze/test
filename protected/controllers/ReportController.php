<?php

class ReportController extends Controller
{
	public $defaultAction = 'report1';

	public function actionReport1()
	{
		$this->render('report1', array('model' => new Book));
	}

	public function actionReport2()
	{
		$this->render('report2', array('model' => new Book));
	}

	public function actionReport3()
	{
		$this->render('report3', array('model' => new Book));
	}

	public function getNavTabsItems($model)
	{
		return array(
			1 => '<a href="' . $this->createUrl('report1') . '">Отчет #1</a>',
			2 => '<a href="' . $this->createUrl('report2') . '">Отчет #2</a>',
			3 => '<a href="' . $this->createUrl('report3') . '">Отчет #3</a>',
		);
	}
}
