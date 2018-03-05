<?php
namespace Framework;

use Manager\ManagerRoutes;

class EntryPoint {
    private $route;
    private $method;
    private $routes;
    private $routevars;

    public function __construct(string $route, string $method, ManagerRoutes $routes) {
        $this->route = $route;
        $this->method = $method;

        $this->routes = $routes->getRoutes();

        if (preg_match("/[\/]/", $this->route)) {
            $this->processUrl();
        }

        $this->checkUrl();
    }

    private function processUrl() {
        $args = explode("/", $this->route);
        $this->route = array_shift($args);
        $this->routevars = $args;
    }

    private function checkUrl() {

        // Ask about differences between httpie responses and browser.

        if ($this->route !== strtolower($this->route)) {
            http_response_code(301);
            header('location: ' . strtolower($this->route));
        }
        if (!array_key_exists(strtolower($this->route), $this->routes)){
            http_response_code(404);
//            die;
            header('location: /');
        }
    }

    private function loadTemplate($templateFileName, $variables = []) {
        extract($variables);

        ob_start();
        include  __DIR__ . '/../../templates/' . $templateFileName;

        return ob_get_clean();
    }

    public function run() {

        $controller = ($this->routes)[$this->route][$this->method]['controller'];
        $action = ($this->routes)[$this->route][$this->method]['action'];

        if (isset(($this->routes)[$this->route][$this->method]['urlVars'])) {
            $page = $controller->$action($this->routevars);
        } else {
            $page = $controller->$action();
        }

        $title = $page['title'];

        if (isset($page['variables'])) {
            $output = $this->loadTemplate($page['template'], $page['variables']);
        } else {
            $output = $this->loadTemplate($page['template']);
        }

        include  __DIR__ . '/../../templates/layout.html.php';
    }
}