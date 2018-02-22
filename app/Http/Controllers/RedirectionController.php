<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RedirectionController extends Controller
{
    /**
     * @var array
     */
    private $redirections = [
        'introduccion-a-python-instalacion-y-hola-mundo' => 'curso/python-3/como-instalar-python-3-windows-linux-mac',
        'operadores-y-tipos-en-python' => 'curso/python-3/operadores-basicos',
        'variables-en-python' => 'curso/python-3/variables-tipos',
        'definicion-funciones-python' => 'curso/python-3/como-definir-funciones',
        'bucles-en-python' => 'curso/python-3/bucles-while',
        'la-funcion-range-en-python' => 'curso/python-3/bucles-for',
        'como-crear-una-lista-de-tareas-con-laravel-tutorial-php' => 'curso/laravel',
        'tutorial-vagrant-1-que-es-y-como-usarlo' => 'curso/vagrant',
        'json-i-que-es-y-para-que-sirve-json' => 'curso/json/que-es-y-para-que-sirve-json',
    ];

    public function redirect(Request $request)
    {
        if (array_key_exists($request->path(), $this->redirections)) {
            return redirect($this->redirections[$request->path()], 301);
        }
    }
}
