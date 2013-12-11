<?php

/**
 * Пользовательский класс для построения критериев отбора данных из модели.
 */
class DbCriteria extends CDbCriteria
{
	/**
	 * Диапазоны дат.
	 * @var array
	 */
	public static $ranges = array('today' => 'Сегодня', 'yesterday' => 'Вчера', 'week' => 'Эта неделя', 'month' => 'Последний месяц', 'year' => 'Последний год', 'old' => 'Более года');

	/**
	 * Метод производит сравнение даты с диапазоном.
	 *
	 * @param string $column
	 * @param string $value
	 * @param string $operator
	 *
	 * @return DbCriteria
	 */
	public function compareDate($column, $value, $operator = 'AND')
	{
		switch ($value) {
			case 'today':
				$condition = self::dateDiff('day', $column, 0);
				break;
			case 'yesterday':
				$condition = self::dateDiff('day', $column, 1);
				break;
			case 'week':
				$condition = self::dateDiff('week', $column, 0);
				break;
			case 'month':
				$condition = self::dateDiff('month', $column, 0);
				break;
			case 'year':
				$condition = self::dateDiff('year', $column, 0);
				break;
			case 'old':
				$condition = self::dateDiff('year', $column, 0, '>');
				break;
		}

		if (isset($condition))
			$this->addCondition($condition, $operator);

		return $this;
	}

	/**
	 * Метод возвращает часть sql-запроса сравнения даты.
	 * @static
	 *
	 * @param string $type
	 * @param string $column
	 * @param string $range
	 * @param string $operator
	 *
	 * @return string
	 */
	protected static function dateDiff($type, $column, $range, $operator = '=')
	{
		return 'TIMESTAMPDIFF(' . $type . ', ' . $column . ', NOW()) ' . $operator . ' ' . $range;
	}

	/**
	 * Метод производит полнотекстовый поиск.
	 *
	 * @param string $column
	 * @param string $value
	 * @param bool   $sortByRelevance
	 * @param string $operator
	 *
	 * @return DbCriteria
	 */
	public function fulltextSearch($column, $value, $sortByRelevance = false, $operator = 'AND')
	{
		if ($value !== null && $value !== '' && $value !== array()) {
			if (is_array($column))
				$column = implode(',', $column);

			if (is_array($value))
				$value = implode(' ', $value);

			$value = '+' . preg_replace('/\s+/', '* +', trim($value)) . '*';

			$condition = 'MATCH(' . $column . ') AGAINST (' . self::PARAM_PREFIX . self::$paramCount . ' IN BOOLEAN MODE)';

			$this->addCondition($condition . ' > 0', $operator);
			$this->params[self::PARAM_PREFIX . self::$paramCount++] = $value;

			//Сортировка по релевантности.
			if ($sortByRelevance === true)
				$this->order = $condition . ' DESC';
		}

		return $this;
	}
}