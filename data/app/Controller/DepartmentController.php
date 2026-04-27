<?php
namespace Controller;
use Src\Request;
use Src\View;
use Model\Department;
use Model\Worker;
use Illuminate\Database\Capsule\Manager as DB;

class DepartmentController {
    public function index(): string {
        return (new View('site.departments.index', [
            'departments' => Department::withCount('workers')->get()
        ]))->render();
    }

    public function create(Request $request): string {
        if ($request->method === 'GET') return (new View('site.departments.create'))->render();
        Department::create($request->all());
        app()->route->redirect('/departments');
        return '';
    }

    public function show($id): string {
        $dept = Department::findOrFail($id);
        $workers = Worker::with('post')->whereHas('departments', fn($q) => $q->where('department_id', $id))->get();

        $avgAge = $workers->count()
            ? round($workers->avg(fn($worker) => (new \DateTime())->diff(new \DateTime($worker->birthday))->y), 1)
            : 0;

        $available = Worker::whereNotIn('id', DB::table('workers_in_departments')->where('department_id', $id)->pluck('worker_id'))->get();

        return (new View('site.departments.show', [
            'department' => $dept, 'workers' => $workers,
            'avg_age' => $avgAge, 'available_workers' => $available
        ]))->render();
    }

    public function attach($id, Request $request): string {
        $dept = Department::findOrFail($id);

        if ($request->method === 'GET') {
            $available = Worker::whereNotIn('id', DB::table('workers_in_departments')->where('department_id', $id)->pluck('worker_id'))->get();

            return (new View('site.departments.attach', [
                'department' => $dept,
                'available_workers' => $available
            ]))->render();
        }

        if ($request->workers) {
            $dept->workers()->syncWithoutDetaching($request->workers);
        }
        app()->route->redirect('/departments/' . $id);
        return '';
    }
}
