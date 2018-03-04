<?php
namespace Framework;

class EntryPoint {
    private $route;
    private $method;
    private $routes;

    public function __construct(string $route, string $method, Routes $routes) {
        $this->route = $route;
        $this->routes = $routes->getRoutes();
        $this->method = $method;
        $this->checkUrl();
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

        $page = $controller->$action();

        $title = $page['title'];

        if (isset($page['variables'])) {
            $output = $this->loadTemplate($page['template'], $page['variables']);
        }
        else {
            $output = $this->loadTemplate($page['template']);
        }

        include  __DIR__ . '/../../templates/layout.html.php';
    }
}