<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Pemakaian di Routes: ['filter' => 'auth']              -> harus login
 *                      ['filter' => 'auth:admin']        -> harus login dan role admin
 *                      ['filter' => 'auth:admin,laboran']-> role salah satu dari daftar
 */
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        if (! empty($arguments) && ! in_array(session()->get('role'), $arguments, true)) {
            return redirect()->to('/dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman tersebut.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
