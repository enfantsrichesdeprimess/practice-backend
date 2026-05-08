<?php
namespace Controller;
use DateTime;
use Src\Request;
use Src\View;
use Model\Worker;
use Model\Department;
use Model\Post;
use Model\Address;
use Practice\Validation\Validator;

class WorkerController {
    public function index(Request $request): string {
        $query = Worker::with(['post', 'address', 'departments']);
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

        return (new View('site.workers.index', [
            'workers' => $query->get(),
            'departments' => Department::all(),
            'filters' => [
                'q' => $search,
                'department_id' => (string)$request->get('department_id'),
            ],
        ]))->render();
    }

    public function create(): string {
        return (new View('site.workers.create', [
            'posts' => Post::all(),
            'departments' => Department::all()
        ]))->render();
    }

    public function show($id): string {
        $worker = Worker::with(['post', 'address', 'departments'])->findOrFail($id);

        return (new View('site.workers.show', [
            'worker' => $worker,
            'photo_url' => $worker->photoUrl(),
            'age' => (new DateTime())->diff(new DateTime($worker->birthday))->y,
        ]))->render();
    }

    public function store(Request $request): string {
        $data = array_merge($request->all(), [
            'photo' => $request->file('photo'),
        ]);

        $validator = new Validator($data, [
            'surname' => ['required'], 'name' => ['required'],
            'gender' => ['required', 'in:male,female'], 'birthday' => ['required', 'date'],
            'photo' => ['image', 'max_file:2048'],
        ], [
            'required' => 'Поле :field обязательно',
            'image' => 'Можно загружать только изображения JPG, PNG, GIF или WEBP',
            'max_file' => 'Размер изображения не должен превышать 2048 КБ',
        ]);

        if ($validator->fails()) {
            return (new View('site.workers.create', [
                'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE),
                'posts' => Post::all(), 'departments' => Department::all()
            ]))->render();
        }

        $address = Address::create([
            'town' => $request->town, 'home' => $request->home,
            'home_number' => $request->home_number, 'flat' => $request->flat
        ]);

        $worker = Worker::create([
            'surname' => $request->surname, 'name' => $request->name,
            'last_name' => $request->last_name, 'gender' => $request->gender,
            'birthday' => $request->birthday, 'address_id' => $address->id,
            'post_id' => $request->post_id ?: null
        ]);

        if ($request->department_id) $worker->departments()->attach($request->department_id);
        $this->savePhoto($worker, $request->file('photo'));
        app()->route->redirect('/workers');
        return '';
    }

    private function savePhoto(Worker $worker, ?array $photo): void {
        if (!is_array($photo) || ($photo['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
            return;
        }

        $extension = strtolower(pathinfo($photo['name'] ?? '', PATHINFO_EXTENSION));
        if (!$extension) {
            $extension = 'jpg';
        }

        $directory = app()->settings->getPublicPath() . '/uploads/workers';
        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        foreach (glob($directory . '/' . $worker->id . '.*') ?: [] as $oldFile) {
            @unlink($oldFile);
        }

        move_uploaded_file($photo['tmp_name'], $directory . '/' . $worker->id . '.' . $extension);
    }
}
