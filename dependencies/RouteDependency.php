<?php

namespace padavvan\placer\dependencies;

class RouteDependency extends Dependency
{
    private ?array $_routes = null;

    /**
     * Исключить если есть совпадения
     */
    private bool $_except = false;

    /**
     * @param array $routes роуты для сравнения
     * @param bool $except
     * @param array $config
     */
    public function __construct($routes, $except = false, $config = [])
    {
        $this->_routes = (array)$routes;
        $this->_except = (bool)$except;

        parent::__construct($config);
    }

    /**
     * Вычисляем результат
     * @return bool
     */
    protected function getResult()
    {
        $currentRoute = \Yii::$app->controller->getRoute();

        foreach ($this->_routes as $route) {

            $pattern = $this->normalizeRoute($route);

            if (preg_match('/' . $pattern . '/', (string) $currentRoute)) {
                return !$this->_except;
            }

        }
        return $this->_except;
    }

    /**
     * Нормализуем роут
     * @param string $route
     * @return mixed|string
     */
    public function normalizeRoute($route)
    {
        $pattern = $route;
        $pattern = ltrim($pattern, '/');
        $pattern = str_replace('*', '[\w\d_-]+', $pattern);

        return addcslashes($pattern, '/');
    }
}
