<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserInterface
{
    public function getAll(int $limit): LengthAwarePaginator;

    public function getByName(string $name, int $limit): LengthAwarePaginator;

    public function getByEmail(string $email): User;
}
