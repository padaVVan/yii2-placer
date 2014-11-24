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
	protected $name = null;

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

	public function init()
	{
		if ($this->name === null)
			throw new InvalidConfigException('Must name');
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
	 * @param mixed $values
	 * @return $this
	 * @throws InvalidConfigException
	 * @internal param $value
	 */
	public function setDependency($values)
	{
		if ($values instanceof Dependency) {
			$deps[] = $values;
		}
		elseif(is_array($values))
			$deps = $values;
		else
			return $this;

		foreach ($deps as $value) {
			if (!($value instanceof Dependency))
				throw new InvalidConfigException('Param must be a Dependency object');
		}

		$this->_dependencies = $deps;

		return $this;
	}

	/**
	 * Name setter
	 * @param string $value
	 */
	public function setName($value)
	{
		$this->name = $value;
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

	/**
	 * @param $tagName
	 * @param $options
	 * @return $this
	 */
	public function wrap($tagName, $options)
	{
		$this->tag = $tagName;
		$this->options = (array)$options;

		return $this;
	}

	/**
	 * @param $config
	 * @return static
	 */
	public static function create($config)
	{
		return new static($config);
	}
}