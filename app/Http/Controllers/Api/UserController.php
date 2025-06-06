<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of users.
     */
    public function index(): JsonResponse
    {
        $users = $this->userRepository->paginate(10);
        return response()->json($users);
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->only([
            'first_name', 'last_name', 'address', 'postcode',
            'contact_phone', 'username', 'email', 'password'
        ]);

        $validator = Validator::make($data, [
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'address'        => 'required|string|max:255',
            'postcode'       => 'required|string|max:20',
            'contact_phone'  => 'required|string|max:20',
            'username'       => 'required|string|max:255|unique:users,username',
            'email'          => 'required|email|max:255|unique:users,email',
            'password'       => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = $this->userRepository->create($data);

        return redirect()->route('dashboard')->with('success', 'User created successfully');
    }

    /**
     * Display a specific user.
     */
    public function show(string $id): JsonResponse
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    /**
     * Update a specific user.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $data = $request->only([
            'first_name', 'last_name', 'address', 'postcode',
            'contact_phone', 'username', 'email', 'password'
        ]);

        $validator = Validator::make($data, [
            'first_name'     => 'sometimes|required|string|max:255',
            'last_name'      => 'sometimes|required|string|max:255',
            'address'        => 'sometimes|required|string|max:255',
            'postcode'       => 'sometimes|required|string|max:20',
            'contact_phone'  => 'sometimes|required|string|max:20',
            'username'       => 'sometimes|required|string|max:255|unique:users,username,' . $id,
            'email'          => 'sometimes|required|email|max:255|unique:users,email,' . $id,
            'password'       => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $updated = $this->userRepository->update($id, $data);
        if (!$updated) {
            return redirect()->back()
                ->with('error', 'User not found or update failed');
        }

        return redirect()->route('dashboard')->with('success', 'User updated successfully');
    }


    /**
     * Remove a specific user.
     */
    public function destroy(string $id): JsonResponse
    {
        $deleted = $this->userRepository->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'User not found or could not be deleted'], 404);
        }

        return response()->json(['message' => 'User deleted successfully']);
    }

    /**
     * Remove multiple users.
     */
    public function destroyMultiple(Request $request): JsonResponse
    {
        $ids = $request->input('ids');

        if (!is_array($ids) || empty($ids)) {
            return response()->json(['message' => 'No user IDs provided'], 400);
        }

        $deletedCount = $this->userRepository->deleteMultiple($ids);

        return response()->json(['message' => "$deletedCount users deleted successfully"]);
    }
}
