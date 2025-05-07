<?php

use App\Exceptions\Category\CategoryNotFoundException;
use App\Exceptions\Category\CategoryAlreadyExistsException;
use App\Exceptions\Entry\EntryNotFoundException;
use App\Exceptions\Entry\InvalidDateRangeException;
use App\Exceptions\Product\ProductAlreadyExistsException;
use App\Exceptions\Product\ProductNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->renderable(function (CategoryNotFoundException $e, $request) {
            return response()->json([
                'error'=> $e->getMessage(),
            ], $e->getCode());
        });

        $exceptions->renderable(function (CategoryAlreadyExistsException $e, $request) {
            return response()->json([
                'error'=> $e->getMessage(),
            ], $e->getCode());
        });

        $exceptions->renderable(function (ProductAlreadyExistsException $e, $request) {
            return response()->json([
                'error'=> $e->getMessage(),
            ], $e->getCode());
        });

        $exceptions->renderable(function (ProductNotFoundException $e, $request) {
            return response()->json([
                'error'=> $e->getMessage(),
            ], $e->getCode());
        });

        $exceptions->renderable(function (EntryNotFoundException $e, $request) {
            return response()->json([
                'error'=> $e->getMessage(),
            ], $e->getCode());
        });

        $exceptions->renderable(function (InvalidDateRangeException $e, $request) {
            return response()->json([
                'error'=> $e->getMessage(),
            ], $e->getCode());
        });

    })->create();
