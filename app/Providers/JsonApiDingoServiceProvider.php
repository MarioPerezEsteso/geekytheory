<?php

namespace App\Providers;

use App\Course;
use App\Transformers\CourseTransformer;
use app\Transformers\UserTransformer;
use App\User;
use Dingo\Api\Transformer\Adapter\Fractal;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;

class JsonApiDingoServiceProvider extends ServiceProvider
{
    /**
     * Register service provider.3
     */
    public function register()
    {
        $this->app->bind('\League\Fractal\Manager', function($app) {
            $fractal = new Manager();
            $serializer = new JsonApiSerializer();
            $fractal->setSerializer($serializer);

            return $fractal;
        });

        $this->app->bind('Dingo\Api\Transformer\Adapter\Fractal', function($app) {
            $fractal = $app->make('\League\Fractal\Manager');

            return new Fractal($fractal);
        });

        /*
         * Transformers registration
         */
        $this->app['Dingo\Api\Transformer\Factory']->register(
            Course::class,
            CourseTransformer::class,
            ['key' => Course::RESOURCE_TYPE,]
        );
        $this->app['Dingo\Api\Transformer\Factory']->register(
            User::class,
            UserTransformer::class,
            ['key' => User::RESOURCE_TYPE,]
        );
    }
}