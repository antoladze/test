jQuery(function($) {
	var keyupInterval;

	/**
	 * Пометка свзанных элементов удаленными.
	 */
	$('.active-list').on('click', 'i', function() {
		var $parent = $(this).parent(),
			$input = $parent.children('input:hidden');

		$parent.toggleClass('deleted');

		if (!$parent.hasClass('deleted'))
			$input.removeAttr('disabled');
		else
			$input.attr('disabled', 'disabled');
	});

	/**
	 * Обработка ввода с клавиатуры названий связанных данных.
	 */
	$('.add-item-control > input').on('keyup', function(e) {
		var $input = $(this),
			text = $input.val(),
			$button = $input.siblings('a'),
			$dropdown = $input.siblings('div.dropdown'),
			ids = [];

		$input.parents('.control-group').find('.active-list input:hidden').each(function() {
			ids.push($(this).val());
		});

		//Удаление существующего интервала.
		if (typeof keyupInterval !== "undefined")
			clearInterval(keyupInterval);

		//Через 200мс после нажатия клавиши запрос на сервер.
		keyupInterval = setTimeout(function() {
			if (text)
				$.get($input.attr('data-url'), {text:text, exclude:ids.join(',')}, function(data) {
					if (data) {
						$dropdown.html(data).children('ul').show(0);
						$button.addClass('hide');
					} else {
						$dropdown.html('');
						$button.removeClass('hide');
					}
				});
			else {
				$button.addClass('hide');
				$dropdown.html('');
			}
		}, 200);

		if (e.keyCode === 13)
			return false;
	});

	/**
	 * Скрытие списка элементов.
	 */
	$(document).on('click', function(e) {
		if ($(e.target).closest('.add-item-control').length === 0)
			$('.add-item-control > div.dropdown > ul').hide();
	});

	/**
	 * Показ уже найденных элементов.
	 */
	$('.add-item-control > input').on('focus', function() {
		var $list = $(this).siblings('div.dropdown').children('ul');
		if ($(this).val() !== '' && $list.length > 0)
			$list.show();
	});

	/**
	 * Добавление элемента в список.
	 * @param $activeList
	 * @param $input
	 * @param $dropdown
	 * @param id
	 * @param text
	 * @param url
	 */
	var appendToActiveList = function($activeList, $input, $dropdown, id, text, url) {
		var $item = $activeList.children('li:last');

		if (!$item.hasClass('hide'))
			$item = $item.clone();

		$item.children('input:hidden').val(id).removeAttr('disabled');
		$item.children('a').attr('href', url).text(text);
		$item.removeClass('deleted');

		if ($item.hasClass('hide'))
			$item.removeClass('hide');
		else
			$item.appendTo($activeList);

		$input.val('');
		$dropdown.html('');
	};

	/**
	 * Обработка выбора элемента из списка.
	 */
	$('.add-item-control > div.dropdown').on('click', 'ul > li > a', function() {
		var $parent = $(this).parents('.add-item-control');

		appendToActiveList(
			$parent.parents('.control-group').find('.active-list'),
			$parent.children('input'),
			$parent.children('div.dropdown'),
			$(this).attr('data-id'),
			$(this).text(),
			$(this).attr('href')
		);
		return false;
	});

	/**
	 * Обработка нажатия кнопки создания записи.
	 */
	$('.add-item-control > a').on('click', function() {
		var $button = $(this),
			$input = $button.siblings('input');

		//Запрос на добавление записи.
		$.getJSON($button.attr('href'), {text:$input.val()}, function(data) {
			if (data.error) {
				$input.val('');
				alert(data.error);
			} else
				appendToActiveList(
					$button.parents('.control-group').find('.active-list'),
					$input,
					$button.siblings('div.dropdown'),
					data.id,
					data.name,
					data.url
				);
			$button.addClass('hide');
		});

		return false;
	});
});