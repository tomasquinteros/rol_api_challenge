<?php

namespace App\Models;

use App\Interfaces\UserInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\LengthAwarePaginator;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Collection\Collection;

class User extends Authenticatable implements UserInterface
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getAll(int $limit): LengthAwarePaginator
    {
        $users = self::paginate($limit);

        if (empty($users)) abort(404, "No se han encontrado usuarios.");

        return $users;
    }

    public function getByName(string $name, int $limit): LengthAwarePaginator
    {
        $users = self::where('name', 'like' ,"%$name%")->paginate($limit);
        if ($users->count() === 0) abort(404, "No se han encontrado usuarios con el nombre: $name");

        return $users;
    }

    public function getByEmail(string $email): User
    {
        $user = self::where('email', $email)->first();

        if (empty($user)) abort(404, "No se han encontrado usuarios con el email: $email");

        return $user;
    }
}
