<?php

namespace padavvan\placer;

use yii\helpers\Html;
use yii\web\MethodNotAllowedHttpException;

class Portlet extends AbstractPlace
{
	/**
	 * Контент
	 * @var string
	 */
	public $content;

	/**
	 * @inheritdoc
	 */
	public function push(AbstractPlace $place)
	{
		throw new MethodNotAllowedHttpException('Do not use this method');
	}

	/**
	 * @inheritdoc
	 */
	public function remove(AbstractPlace $place)
	{
		throw new MethodNotAllowedHttpException('Do not use this method');
	}

	/**
	 * @inheritdoc
	 */
	public function render()
	{
		if (!$this->isView()) {
					return;
		}

		if (null === $this->tag) {
					return $this->content;
		} else {
					return Html::tag($this->tag, $this->content, $this->options);
		}
	}
}