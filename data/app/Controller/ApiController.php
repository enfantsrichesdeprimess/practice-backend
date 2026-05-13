<?php
namespace Controller;

use DateTime;
use Model\Post;
use Model\Worker;
use Practice\Validation\Validator;
use Src\Auth\Auth;
use Src\Request;
use Src\View;

class ApiController
{
    public function index(): void
    {
        (new View())->toJSON(Post::all()->toArray());
    }

    public function echo(Request $request): void
    {
        (new View())->toJSON($request->all());
    }

    public function login(Request $request): void
    {
        $validator = new Validator($request->all(), [
            'login' => ['required'],
            'password' => ['required'],
        ], [
            'required' => 'Поле :field обязательно',
        ]);

        if ($validator->fails()) {
            (new View())->toJSON([
                'message' => 'Ошибка валидации',
                'errors' => $validator->errors(),
            ], 422);
        }

        if (!Auth::attempt($request->all())) {
            (new View())->toJSON([
                'message' => 'Неверный логин или пароль',
            ], 401);
        }

        $user = Auth::user();
        $token = Auth::issueToken($user);

        (new View())->toJSON([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'login' => $user->login,
                'role' => $user->role,
            ],
        ]);
    }

    public function workers(Request $request): void
    {
        $query = Worker::with(['post', 'departments', 'address']);
        $search = trim((string)$request->get('q'));

        if ($search !== '') {
            $query->where(function ($builder) use ($search) {
                $builder->where('surname', 'like', '%' . $search . '%')
                    ->orWhere('name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%');
            });
        }

        if ($request->get('department_id')) {
            $query->whereHas('departments', fn($q) => $q->where('department_id', $request->get('department_id')));
        }

        $workers = $query->get()->map(function ($worker) {
            return [
                'id' => $worker->id,
                'full_name' => $worker->fullName(),
                'gender' => $worker->gender,
                'birthday' => $worker->birthday,
                'age' => $worker->birthday ? (new DateTime())->diff(new DateTime($worker->birthday))->y : null,
                'post' => $worker->post->name ?? null,
                'departments' => $worker->departments->pluck('name')->values()->all(),
                'address' => [
                    'town' => $worker->address->town ?? null,
                    'home' => $worker->address->home ?? null,
                    'home_number' => $worker->address->home_number ?? null,
                    'flat' => $worker->address->flat ?? null,
                ],
                'photo_url' => $worker->photoUrl(),
            ];
        })->all();

        (new View())->toJSON([
            'user' => [
                'id' => Auth::user()->id,
                'login' => Auth::user()->login,
                'role' => Auth::user()->role,
            ],
            'filters' => [
                'q' => $search,
                'department_id' => $request->get('department_id'),
            ],
            'data' => $workers,
        ]);
    }
}
