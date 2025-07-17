<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserInterface
{
    public function getAll(): LengthAwarePaginator;

    public function getByName(string $name): LengthAwarePaginator;

    public function getByEmail(string $email): User;
}
