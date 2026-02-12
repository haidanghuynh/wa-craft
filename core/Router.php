<?php
/**
 * Router - URL Routing
 * Định tuyến URL / URLルーティング
 */

class Router
{
    private array $routes = [];

    /**
     * Đăng ký route GET
     */
    public function get(string $pattern, string $controller, string $method): void
    {
        $this->routes[] = [
            'method' => 'GET',
            'pattern' => $pattern,
            'controller' => $controller,
            'action' => $method,
        ];
    }

    /**
     * Đăng ký route POST
     */
    public function post(string $pattern, string $controller, string $method): void
    {
        $this->routes[] = [
            'method' => 'POST',
            'pattern' => $pattern,
            'controller' => $controller,
            'action' => $method,
        ];
    }

    /**
     * Dispatch - Xử lý request / リクエスト処理
     */
    public function dispatch(string $url): void
    {
        $url = trim($url, '/');
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            // Chuyển pattern thành regex
            $pattern = $this->patternToRegex($route['pattern']);

            if (preg_match($pattern, $url, $matches)) {
                // Lấy các params từ URL
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                $controllerName = $route['controller'];
                $actionName = $route['action'];

                // Load controller
                $controllerFile = APP_PATH . '/controllers/' . $controllerName . '.php';
                if (!file_exists($controllerFile)) {
                    $this->notFound("Controller not found: {$controllerName}");
                    return;
                }

                require_once $controllerFile;

                // Lấy tên class (basename, bỏ path)
                $className = basename($controllerName);

                if (!class_exists($className)) {
                    $this->notFound("Class not found: {$className}");
                    return;
                }

                $controller = new $className();

                if (!method_exists($controller, $actionName)) {
                    $this->notFound("Method not found: {$className}::{$actionName}");
                    return;
                }

                // Gọi action với params
                call_user_func_array([$controller, $actionName], $params);
                return;
            }
        }

        // Không tìm thấy route
        $this->notFound();
    }

    /**
     * Chuyển pattern URL thành regex
     * VD: 'blog/{slug}' -> '#^blog/(?P<slug>[^/]+)$#'
     */
    private function patternToRegex(string $pattern): string
    {
        $pattern = trim($pattern, '/');
        // Thay {param} thành named group
        $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $pattern);
        return '#^' . $pattern . '$#';
    }

    /**
     * 404 Not Found
     */
    private function notFound(string $message = 'Page Not Found'): void
    {
        http_response_code(404);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            header('Content-Type: application/json');
            echo json_encode(['error' => $message]);
        } else {
            echo "<h1>404 - {$message}</h1>";
        }
        exit;
    }
}
