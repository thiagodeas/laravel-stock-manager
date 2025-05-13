<?php

use App\Exceptions\Auth\InvalidCredentialsException;
use App\Exceptions\Auth\LogoutFailedException;
use App\Exceptions\Auth\UserAlreadyExistsException;
use App\Exceptions\Auth\UserNotAuthenticatedException;
use App\Exceptions\Category\CategoryNotFoundException;
use App\Exceptions\Category\CategoryAlreadyExistsException;
use App\Exceptions\Entry\EntryNotFoundException;
use App\Exceptions\InvalidDateRangeException;
use App\Exceptions\Output\OutputNotFoundException;
use App\Exceptions\Product\InsufficientStockException;
use App\Exceptions\Product\ProductAlreadyExistsException;
use App\Exceptions\Product\ProductNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

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
        $exceptions->render(function (Throwable $e, Request $request) {
            $statusCode = $e->getCode() ? : 500;
        
            return response()->json([
                'error' => $e->getMessage(),
            ], $statusCode);
        });

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

        $exceptions->renderable(function (InsufficientStockException $e, $request) {
            return response()->json([
                'error'=> $e->getMessage(),
            ], $e->getCode());
        });

        $exceptions->renderable(function (OutputNotFoundException $e, $request) {
            return response()->json([
                'error'=> $e->getMessage(),
            ], $e->getCode());
        });

        $exceptions->renderable(function (UserNotAuthenticatedException $e, $request) {
            return response()->json([
                'error'=> $e->getMessage(),
            ], $e->getCode());
        });

        $exceptions->renderable(function (LogoutFailedException $e, $request) {
            return response()->json([
                'error'=> $e->getMessage(),
            ], $e->getCode());
        });

        $exceptions->renderable(function (InvalidCredentialsException $e, $request) {
            return response()->json([
                'error'=> $e->getMessage(),
            ], $e->getCode());
        });

        $exceptions->renderable(function (UserAlreadyExistsException $e, $request) {
            return response()->json([
                'error'=> $e->getMessage(),
            ], $e->getCode());
        });

    })->create();
