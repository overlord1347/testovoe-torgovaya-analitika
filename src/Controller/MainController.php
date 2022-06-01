<?php

declare(strict_types=1);

namespace App\Controller;

use App\Cache\CacheWorker;

class MainController
{
    /**
     * Main page
     *
     * @return void
     */
    public function index(): void
    {
        $this->render('index');
    }

    /**
     * Getting all from cache
     *
     * @return array
     */
    public function getAllCache():array {

        return CacheWorker::getAllKeyValues();
    }

    /**
     * Remove element from cache
     *
     * @return array
     */
    public function removeCachedElement(): array {
        $matches = [];
        preg_match('/\/api\/redis\/([a-z0-9]+)/', $_SERVER['REQUEST_URI'] ?? '', $matches);

        if (isset($matches[1])) {
            CacheWorker::deleteValue($matches[1]);
        }

        return ['success'];
    }


    /**
     * Outputs view with params
     *
     * @param string $template - View layer file
     */
    protected function render(string $template): void
    {
        ob_start();
        include '../src/View/' . $template . '.html';
        ob_flush();
    }
}