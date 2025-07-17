<?php

namespace App\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface UserInterface
{
    public function getAll(): Builder;

    public function getByName(string $name): Builder;

    public function getByEmail(string $email): User;
}
