<?php

namespace padavvan\placer\dependencies;

use yii\base\Object;

abstract class Dependency extends Object
{

	/**
	 * Вычисление зависимости
	 * @return bool
	 */
	public function evaluateDependency()
	{
		return (bool)$this->getResult();
	}

	abstract protected function getResult();
}