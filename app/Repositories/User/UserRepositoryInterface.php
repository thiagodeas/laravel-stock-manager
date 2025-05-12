<?php

namespace App\Repositories\User;

interface UserRepositoryInterface
{
    public function create(array $data);
    public function findByEmail(string $email);
}