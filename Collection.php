<?php

namespace padavvan\placer;

use yii\helpers\Html;

class Collection extends AbstractPlace
{
	/**
	 * Стэк
	 * @var array
	 */
	private $_children = [];

	/**
	 * Разделитель
	 * @var string
	 */
	public $delimiter = '';

	/**
	 * @inheritdoc
	 */
	public function push(AbstractPlace $place)
	{
		$this->_children[$place->name] = $place;
	}

	/**
	 * @inheritdoc
	 */
	public function remove(AbstractPlace $place)
	{
		unset($this->_children[$place->name]);
	}

	/**
	 * @inheritdoc
	 */
	public function render()
	{
		if (!$this->isView())
			return;

		$collection = [];

		/** @var AbstractPlace $child */
		foreach ($this->_children as $child)
			$collection[] = $child->render();

		$out = implode($this->delimiter, $collection);

		if (null === $this->tag)
			return $out;
		else
			return Html::tag($this->tag, $out, $this->options);
	}

	/**
	 * @inheritdoc
	 */
	public function __get($name) {
		if (isset($this->_children[$name]))
			return $this->_children[$name];
		else parent::__get($name);
	}
}