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
        'tutorial-0-introduccion-a-java-y-netbeans' => 'curso/java/como-instalar-java',
        'tutorial-1-java-hola-mundo' => 'curso/java/primer-programa-hola-mundo',
        'tutorial-2-java-estructuras-secuenciales' => 'curso/java/condicionales-java',
        'tutorial-3-java-estructuras-condicionales-y-excepciones' => 'curso/java/condicionales-java',
        'tutorial-4-bucles' => 'curso/java/bucles-for-java',
        'tutorial-5-java-cadenas-de-caracteres' => 'curso/java/variables',
        'tutorial-6-java-definicion-de-clases-y-objetos' => 'curso/java/como-definir-clase-java',
        'tutorial-7-java-vectores' => 'curso/java/arrays',
        'tutorial-8-java-vectores-parte-2' => 'curso/java/arrays',
        'tutorial-9-java-vectores-parte-3' => 'curso/java/arrays',
        'tutorial-10-java-matrices' => 'curso/java/matrices',
        'tutorial-11-java-constructor-de-la-clase' => 'curso/java/constructor-clase-java',
        'tutorial-12-java-uso-de-varias-clases' => 'curso/java/como-usar-varias-clases',
        'tutorial-13-java-herencia' => 'curso/java/herencia-java',
    ];

    public function redirect(Request $request)
    {
        if (array_key_exists($request->path(), $this->redirections)) {
            return redirect($this->redirections[$request->path()], 301);
        }
    }
}
