<?php

namespace padavvan\placer;

use padavvan\placer\dependencies\Dependency;
use yii\base\InvalidConfigException;

abstract class AbstractPlace extends \yii\base\Object
{
	/**
	 * Place name
	 * @var string
	 */
	protected $name;

	/**
	 * Wrap tag name
	 * @var null|string
	 */
	public $tag = null;

	/**
	 * Wrap tag config
	 * @var array
	 */
	public $options = [];

	/**
	 * @var \padavvan\placer\dependencies\Dependency[]
	 */
	private $_dependencies = null;

	/**
	 * @param string $name
	 * @param array $config
	 */
	public function __construct($name, $config = [])
	{
		$this->name = $name;

		parent::__construct($config);
	}

	/**
	 * Add new place
	 * @param AbstractPlace $place
	 */
	public abstract function push(AbstractPlace $place);

	/**
	 * Remove place
	 * @param AbstractPlace $place
	 */
	public abstract function remove(AbstractPlace $place);

	/**
	 * Render place
	 * @return string|void
	 */
	public abstract function render();

	/**
	 * Dependency setter
	 * @param $values
	 * @throws InvalidConfigException
	 * @internal param $value
	 */
	public function setDependency($values)
	{
		foreach ($values as $value) {
			if (!($value instanceof Dependency))
				throw new InvalidConfigException('Param must be a Dependency object');
		}

		$this->_dependencies = (array)$values;
	}

	/**
	 * Display place or not.
	 * For this pass on all the dependencies and evaluate the value.
	 * If at least one dependency is not satisfied then returns false.
	 * @return bool
	 */
	protected function isView()
	{
		if ($this->_dependencies === null)
			return true;

		$evaluate = true;
		foreach ($this->_dependencies as $dependency) {
			$evaluate = $evaluate && $dependency->evaluateDependency();
		}
		return $evaluate;
	}

}