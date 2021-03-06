<?php

namespace Framework;

use Manager\ManagerRoutes;

/**
 * Class EntryPoint
 * @package Framework
 */
class EntryPoint
{

    /**
     * @var string
     */
    private $route;
    /**
     * @var string
     */
    private $method;
    /**
     * @var array
     */
    private $routes;
    /**
     * @var
     */
    private $routevars;


    /**
     * EntryPoint constructor.
     * @param string $route
     * @param string $method
     * @param ManagerRoutes $routes
     */
    public function __construct(string $route, string $method, ManagerRoutes $routes)
    {
        $this->route = $route;
        $this->method = $method;

        $this->routes = $routes->getRoutes();

        if (preg_match("/[\/]/", $this->route)) {
            $this->processUrl();
        }

        $this->checkUrl();
    }

    private function processUrl()
    {
        $args = explode('/', $this->route);
        $this->route = array_shift($args);
        $this->routevars = $args;
    }

    private function checkUrl()
    {

        if ($this->route !== strtolower($this->route)) {
            http_response_code(301);
            header('Location: ' . strtolower($this->route));
        }
        if (!array_key_exists(strtolower($this->route), $this->routes)) {
            http_response_code(404);
            header('Location: /');
        }
    }

    /**
     * @param $templateFileName
     * @param array $variables
     * @return string
     */
    private function loadTemplate($templateFileName, $variables = [])
    {
        extract($variables);

        ob_start();

        if (isset($templateFileName)) {
            include __DIR__ . '/../../templates/' . $templateFileName;
        }

        return ob_get_clean();
    }

    public function run()
    {
        $controller = $this->routes[$this->route][$this->method]['controller'];
        $action = $this->routes[$this->route][$this->method]['action'];

        if (isset($this->routes[$this->route][$this->method]['urlVars'])) {
            $page = $controller->$action($this->routevars);
        } else {
            $action = (string)$action;
            $page = $controller->$action();
        }

        $title = $page['title'];

        if (isset($page['variables'])) {
            $output = $this->loadTemplate($page['template'], $page['variables']);
        } else {
            $output = $this->loadTemplate($page['template']);
        }

        include __DIR__ . '/../../templates/layout.html.php';
    }
}