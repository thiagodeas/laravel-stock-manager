<?php

namespace App\Services\Auth;

use App\Exceptions\Auth\InvalidCredentialsException;
use App\Exceptions\Auth\LogoutFailedException;
use App\Exceptions\Auth\TokenNotProvidedException;
use App\Exceptions\Auth\UserAlreadyExistsException;
use App\Exceptions\Auth\UserNotAuthenticatedException;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data)
    {
        $user = $this->userRepository->findByEmail($data['email']);

        if ($user) {
            throw new UserAlreadyExistsException();
        }
        
        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'user';
        return $this->userRepository->create($data);
    }

    public function login(array $credentials)
    {
        if (!$token = JWTAuth::attempt($credentials)) {
            throw new InvalidCredentialsException();
        }

        return $token;
    }

    public function logout()
    {
        try {
            $token = JWTAuth::getToken();

            if (!$token) {
                throw new TokenNotProvidedException();
            }

            JWTAuth::invalidate($token);
        } catch (TokenNotProvidedException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new LogoutFailedException();
        }
    }

    public function getAuthenticatedUser()
    {
        try {
            $authUser = JWTAuth::user();

            if (!$authUser) {
                throw new TokenNotProvidedException();
            }

            return $authUser;
        } catch (TokenNotProvidedException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new UserNotAuthenticatedException();
        }
    }
}