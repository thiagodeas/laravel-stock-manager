<?php

namespace Tests\Unit;

use App\Exceptions\Auth\InvalidCredentialsException;
use App\Exceptions\Auth\LogoutFailedException;
use App\Exceptions\Auth\TokenNotProvidedException;
use App\Exceptions\Auth\UserAlreadyExistsException;
use App\Exceptions\Auth\UserNotAuthenticatedException;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthServiceTest extends TestCase
{
    protected $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = Mockery::mock('App\Repositories\User\UserRepositoryInterface');
    }

    public function testRegister()
{
    $data = ['email' => 'test@example.com', 'password' => 'password123'];
    $hashedPassword = 'hashed_password';
    $user = (object) ['id' => 1, 'email' => 'test@example.com'];

    $this->userRepository
        ->shouldReceive('findByEmail')
        ->once()
        ->with($data['email'])
        ->andReturn(null);

    Hash::shouldReceive('make')
        ->once()
        ->with($data['password'])
        ->andReturn($hashedPassword);

    $this->userRepository
        ->shouldReceive('create')
        ->once()
        ->with(Mockery::on(function ($arg) use ($data, $hashedPassword) {
            return $arg['email'] === $data['email'] &&
                   $arg['password'] === $hashedPassword &&
                   $arg['role'] === 'user';
        }))
        ->andReturn($user);

    $authService = new AuthService($this->userRepository);
    $result = $authService->register($data);

    $this->assertEquals($user, $result);
}


    public function testLogin()
    {
        $credentials = ['email' => 'test@example.com', 'password' => 'password123'];
        $token = 'jwt_token';

        JWTAuth::shouldReceive('attempt')
            ->once()
            ->with($credentials)
            ->andReturn($token);

        $authService = new AuthService($this->userRepository);
        $result = $authService->login($credentials);

        $this->assertEquals($token, $result);
    }

    public function testLoginThrowsInvalidCredentialsException()
    {
        $this->expectException(InvalidCredentialsException::class);

        $credentials = ['email' => 'test@example.com', 'password' => 'wrong_password'];

        JWTAuth::shouldReceive('attempt')
            ->once()
            ->with($credentials)
            ->andReturn(false);

        $authService = new AuthService($this->userRepository);
        $authService->login($credentials);
    }

    public function testLogout()
    {
        JWTAuth::shouldReceive('getToken')
            ->once()
            ->andReturn('jwt_token');

        JWTAuth::shouldReceive('invalidate')
            ->once()
            ->with('jwt_token');

        $authService = new AuthService($this->userRepository);
        $authService->logout();
    }

    public function testLogoutThrowsLogoutFailedException()
    {
        $this->expectException(LogoutFailedException::class);

        JWTAuth::shouldReceive('getToken')
            ->once()
            ->andReturn('jwt_token');

        JWTAuth::shouldReceive('invalidate')
            ->once()
            ->with('jwt_token')
            ->andThrow(new \Exception());

        $authService = new AuthService($this->userRepository);
        $authService->logout();
    }

    public function testGetAuthenticatedUser()
    {
        $user = (object) ['id' => 1, 'email' => 'test@example.com'];

        JWTAuth::shouldReceive('user')
            ->once()
            ->andReturn($user);

        $authService = new AuthService($this->userRepository);
        $result = $authService->getAuthenticatedUser();

        $this->assertEquals($user, $result);
    }

    public function testGetAuthenticatedUserThrowsUserNotAuthenticatedException()
    {
        $this->expectException(UserNotAuthenticatedException::class);

        JWTAuth::shouldReceive('user')
            ->once()
            ->andThrow(new \Exception());

        $authService = new AuthService($this->userRepository);
        $authService->getAuthenticatedUser();
    }
    
    public function testRegisterThrowsUserAlreadyExistsException()
    {
        $this->expectException(UserAlreadyExistsException::class);

        $data = ['email' => 'test@example.com', 'password' => 'password123'];
        $existingUser = (object) ['id' => 1, 'email' => 'test@example.com'];

        $this->userRepository
            ->shouldReceive('findByEmail')
            ->once()
            ->with($data['email'])
            ->andReturn($existingUser);

        $authService = new AuthService($this->userRepository);
        $authService->register($data);
    }

    public function testRegisterCreatesNewUserWhenEmailDoesNotExist()
    {
        $data = ['email' => 'test@example.com', 'password' => 'password123'];
        $hashedPassword = 'hashed_password';
        $user = (object) ['id' => 1, 'email' => 'test@example.com'];

        // Configurar o mock para findByEmail
        $this->userRepository
            ->shouldReceive('findByEmail')
            ->once()
            ->with($data['email'])
            ->andReturn(null);

        // Configurar o mock para Hash::make
        Hash::shouldReceive('make')
            ->once()
            ->with($data['password'])
            ->andReturn($hashedPassword);

        // Configurar o mock para create
        $this->userRepository
            ->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($arg) use ($data, $hashedPassword) {
                return $arg['email'] === $data['email'] &&
                       $arg['password'] === $hashedPassword &&
                       $arg['role'] === 'user';
            }))
            ->andReturn($user);

        $authService = new AuthService($this->userRepository);
        $result = $authService->register($data);

        $this->assertEquals($user, $result);
    }

    public function testLogoutThrowsTokenNotProvidedException()
    {
        $this->expectException(TokenNotProvidedException::class);

        JWTAuth::shouldReceive('getToken')
            ->once()
            ->andReturn(null);

        $authService = new AuthService($this->userRepository);
        $authService->logout();
    }

    public function testGetAuthenticatedUserThrowsTokenNotProvidedException()
    {
        $this->expectException(TokenNotProvidedException::class);

        JWTAuth::shouldReceive('user')
            ->once()
            ->andReturn(null);

        $authService = new AuthService($this->userRepository);
        $authService->getAuthenticatedUser();
    }
}
