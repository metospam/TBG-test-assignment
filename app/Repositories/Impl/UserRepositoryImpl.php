<?php

namespace App\Repositories\Impl;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserRepositoryImpl implements UserRepository
{
    /**
     * Get users based on search criteria.
     *
     * @param array $data An associative array containing search parameters:
     *                    - 'search': The search string (optional).
     *                    - 'page': The page number for pagination (optional, default is 1).
     *                    - 'per_page': Number of items per page for pagination (optional, default is 10).
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated list of users.
     */
    public function getUsers(array $data): LengthAwarePaginator
    {
        $search = $data['search'] ?? '';
        $page = $data['page'] ?? 1;
        $perPage = $data['per_page'] ?? 10;

        $query = User::query();
        if($search){
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('to_send', 'like', '%' . $search . '%');
        }

        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Save a new user.
     *
     * @param array $data An associative array containing user data.
     * @return User The created user instance.
     */
    public function save(array $data): User
    {
        return User::query()->create($data);
    }

    /**
     * Update a user's information.
     *
     * @param User $user The user instance to be updated.
     * @param array            $data An associative array containing updated user data.
     * @return bool True if the update was successful, false otherwise.
     */
    public function update(User $user, $data): bool
    {
        return $user->update($data);
    }

    /**
     * Find a user by a specific column value.
     *
     * @param string $column The column name to search by.
     * @param mixed  $value  The value of the column to search for.
     * @return User The found user instance.
     *
     * @throws ModelNotFoundException If no matching user is found.
     */
    public function findByColumn(string $column, mixed $value): User
    {
        return User::query()->where($column, $value)->firstOrFail();
    }
}
