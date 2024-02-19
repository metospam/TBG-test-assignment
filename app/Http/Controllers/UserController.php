<?php

namespace App\Http\Controllers;

use App\Factories\SendServiceFactory;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\GetUsersRequest;
use App\Http\Requests\SendRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use App\Services\TelegramService;
use App\Services\UploadService;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     * @param TelegramService $telegramService
     * @param SendServiceFactory $sendServiceFactory
     * @param UploadService $uploadService
     */
    public function __construct(
        protected UserRepository     $userRepository,
        protected TelegramService    $telegramService,
        protected SendServiceFactory $sendServiceFactory,
        protected UploadService      $uploadService,
    )
    {
    }

    /**
     * Handle the request to get a list of users.
     *
     * @param GetUsersRequest $request
     *
     * @return JsonResponse
     */
    public function handleGetUsers(GetUsersRequest $request): JsonResponse
    {
        $data = $request->validated();
        $users = $this->userRepository->getUsers($data);

        return response()->json([
            'items' => $users->items(),
            'total' => $users->lastPage(),
        ]);
    }

    /**
     * Handle the request to delete a user by ID.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function handleDeleteUser(int $id): JsonResponse
    {
        $user = $this->userRepository->findByColumn('id', $id);
        $user->delete();

        return response()->json();
    }

    /**
     * Handle the request to update a user by ID.
     *
     * @param UpdateUserRequest $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function handleUpdateUser(UpdateUserRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        $user = $this->userRepository->findByColumn('id', $id);
        $this->userRepository->update($user, $data);

        return response()->json();
    }

    /**
     * Handle the request to create a new user.
     *
     * @param CreateUserRequest $request
     *
     * @return JsonResponse
     */
    public function handleCreateUser(CreateUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $this->userRepository->save($data);

        return response()->json();
    }

    /**
     * Handles the sending of a file to a user via the appropriate service.
     *
     * @param SendRequest $request The HTTP request containing the necessary data for sending the file.
     * @return \Illuminate\Http\JsonResponse A JSON response indicating the success or failure of the operation.
     */
    public function handleSendFile(SendRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = $this->userRepository->findByColumn('id', $data['user_id']);
        $path = $data['file_path'];

        $this->sendServiceFactory
            ->create($user->type)
            ->sendFile($user->to_send, $path);

        $this->uploadService->unlink($path);
        return response()->json();
    }

}
