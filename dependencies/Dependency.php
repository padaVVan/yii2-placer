<?php

namespace padavvan\placer\dependencies;

use yii\base\BaseObject;

abstract class Dependency extends BaseObject
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