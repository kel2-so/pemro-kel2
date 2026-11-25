<?php

namespace App\Controllers;

/**
 * Controller dasar: memuat helper dan membungkus view dengan layout utama.
 */
abstract class AppController extends BaseController
{
    protected $helpers = ['form', 'url', 'inventaris'];

    protected function render(string $view, array $data = []): string
    {
        $data['content'] = view($view, $data);

        return view('layout/main', $data);
    }
}
