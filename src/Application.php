<?php

declare(strict_types=1);

namespace App;

use App\Controller\MainController;

class Application
{
    /**
     * Web Application routes
     *
     * @var array
     */
    private $routesGET = [
        '/' => [
            'controller' => MainController::class,
            'action' => 'index'
        ],
        '/api/redis' => [
            'controller' => MainController::class,
            'action' => 'getAllCache'
        ]
    ];

    private $routesDelete = [
        '/api/redis' => [
            'controller' => MainController::class,
            'action' => 'removeCachedElement'
        ]
    ];

    /**
     * Runs Application
     */
    public function run(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        $url = $_SERVER['REQUEST_URI'] ?? '';
        $urlInfo = parse_url($url);
        $path = $urlInfo['path'];

        if ($method === 'GET') {
            if (!isset($this->routesGET[$path])) {

                echo '404 not found';
                return;
            }

            $route = $this->routesGET[$path];
        } elseif ($method === 'DELETE') {

            $matches = [];
            preg_match('/(\/api\/redis)\/[a-z0-9]+/', $_SERVER['REQUEST_URI'] ?? '', $matches);

            if (isset($matches[1])) {
                $path = $matches[1];
            }

            if (!isset($this->routesDelete[$path])) {
                echo '404 not found ' . $url;
                return;
            }

            $route = $this->routesDelete[$path];
        } else {

            echo "undefined method";
            return;
        }

        $controller = $route['controller'];
        $action = $route['action'];

        try {
            $data = (new $controller)->$action();
        } catch (\Throwable $exception) {
            echo json_encode(
                [
                    'status' => false,
                    'code' => 500,
                    'data' => [
                        'message' => $exception->getMessage()
                    ]
                ]);
            exit(1);
        }

        if ($data) {
            echo json_encode(
                [
                    'status' => true,
                    'code' => 200,
                    'data' => $data
                ]);
        }
    }
}