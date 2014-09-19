<?php
namespace padavvan\placer;

use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: padawan
 * Date: 17.09.14
 * Time: 18:15
 */
class Place extends Component
{
	private $_data = [];

	public $option = ['class' => 'box'];
	public $tagName = 'div';

	public function push($config)
	{
		array_push($this->_data, $this->normalizePortlet($config));
	}

	public function unshift($config)
	{
		array_unshift($this->_data, $this->normalizePortlet($config));
	}

	public function normalizePortlet($config)
	{
		if (!is_array($config))
			throw new InvalidConfigException('$config must be an array');

		$name = array_shift($config);
		$content = array_shift($config);

		return ['name' => $name, 'content' => $content];
	}

	public function renderAll()
	{
		$data = ArrayHelper::getColumn($this->_data, 'content');
		$content = join('', $data);
		if(!empty($content))
			return Html::tag($this->tagName, join('', $data), $this->option);
	}
}