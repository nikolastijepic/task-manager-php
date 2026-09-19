<?php

namespace App\Controllers;

abstract class Controller
{
    protected function render(string $view, array $data = []): void
    {
        extract($data);

        $viewPath = __DIR__ . '/../../views/' . $view . '.php';

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            echo "Greška: View fajl <strong>{$view}.php</strong> ne postoji.";
        }
    }

    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}
