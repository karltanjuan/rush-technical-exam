<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\User;

interface UserRepositoryInterface
{
    /**
     * Get paginated list of users.
     */
    public function paginate(int $perPage = 15): LengthAwarePaginator;

    /**
     * Find a user by ID.
     */
    public function find(int $id): ?User;

    /**
     * Create a new user.
     */
    public function create(array $data): User;

    /**
     * Update user by ID.
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete user by ID.
     */
    public function delete(int $id): bool;

    /**
     * Delete multiple users by IDs.
     */
    public function deleteMultiple(array $ids): int;
}
