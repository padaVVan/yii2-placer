<?php

namespace padavvan\placer;

use yii\helpers\Html;

class Collection extends AbstractPlace
{
    /**
     * Стэк
     */
    private array $_children = [];

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
        return $this;
    }

    /**
     * @param $config
     */
    public function pushPortlet($config)
    {
        return $this->push(Portlet::create($config));
    }

    /**
     * @param $config
     */
    public function pushCollection($config)
    {
        return $this->push(Collection::create($config));
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
        if (!$this->isView()) {
            return;
        }

        $collection = [];

        /** @var AbstractPlace $child */
        foreach ($this->_children as $child) {
            $collection[] = $child->render();
        }

        $out = implode($this->delimiter, $collection);

        if (null === $this->tag) {
            return $out;
        } else {
            return Html::tag($this->tag, $out, $this->options);
        }
    }

    /**
     * @inheritdoc
     */
    public function __get($name)
    {
        $getter = 'get' . $name;

        if (method_exists($this, $getter)) {
            return $this->$getter();

        } elseif (isset($this->_children[$name])) {
            return $this->_children[$name];

        } else {
            $collection = static::create(['name' => $name]);
            $this->push($collection);
            return $collection;
        }
    }
}
