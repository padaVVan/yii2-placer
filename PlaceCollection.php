<?php
namespace padavvan\placer;

use yii\base\Component;

class PlaceCollection extends Component
{
	public $defaultPlace = [];
	public $attachedClass = '\padavvan\placer\Place';

	private $_places = [];

	public function init()
	{
		$this->_places = array_keys($this->defaultPlace);
		foreach ($this->defaultPlace as $place)
			$this->createPlace($place);
	}

	/**
	 * @param string $name
	 * @return mixed|\padavvan\placer\Place
	 * @throws \yii\base\UnknownPropertyException
	 */
	public function __get($name)
	{
		if (isset($this->_places[$name]) || array_key_exists($name, $this->_places))
			return $this->_places[$name];

		parent::__get($name);
	}

	/**
	 * @param $name
	 * @param array $config
	 */
	public function createPlace($name, $config = [])
	{
		$this->_places[$name] = new $this->attachedClass($config);
	}
}