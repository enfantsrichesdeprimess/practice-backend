<?php
namespace Controller;
use Src\Request;
use Src\View;
use Model\Worker;
use Model\Department;
use Model\Post;
use Model\Address;
use Src\Validator\Validator;

class WorkerController {
    public function index(Request $request): string {
        $query = Worker::with(['post', 'address', 'departments']);
        if ($request->get('department_id')) {
            $query->whereHas('departments', fn($q) => $q->where('department_id', $request->get('department_id')));
        }
        return (new View('workers.index', [
            'workers' => $query->get(),
            'departments' => Department::all()
        ]))->render();
    }

    public function create(): string {
        return (new View('workers.create', [
            'posts' => Post::all(),
            'departments' => Department::all()
        ]))->render();
    }

    public function store(Request $request): string {
        $validator = new Validator($request->all(), [
            'surname' => ['required'], 'name' => ['required'],
            'gender' => ['required', 'in:male,female'], 'birthday' => ['required', 'date']
        ], ['required' => 'Поле :field обязательно']);

        if ($validator->fails()) {
            return (new View('workers.create', [
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
        app()->route->redirect('/workers');
        return '';
    }
}