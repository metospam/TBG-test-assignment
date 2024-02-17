<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface UserRepository
{
    public function getUsers(array $data): LengthAwarePaginator;
    public function findByColumn(string $column, mixed $value): User;
    public function save(array $data): User;
    public function update(User $user, $data): bool;
}
