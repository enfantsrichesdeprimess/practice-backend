<?php
namespace Controller;
use Src\Request;
use Src\View;
use Model\Department;
use Model\Worker;
use Illuminate\Database\Capsule\Manager as DB;

class DepartmentController {
    public function index(): string {
        return (new View('departments.index', [
            'departments' => Department::withCount('workers')->get()
        ]))->render();
    }

    public function create(Request $request): string {
        if ($request->method === 'GET') return (new View('departments.create'))->render();
        Department::create($request->all());
        app()->route->redirect('/departments');
        return '';
    }

    public function show($id): string {
        $dept = Department::findOrFail($id);
        $workers = Worker::with('post')->whereHas('departments', fn($q) => $q->where('department_id', $id))->get();
        
        $avgAge = 0;
        if ($workers->count() > 0) {
            $total = array_sum(array_map(fn($w) => (new \DateTime())->diff(new \DateTime($w->birthday))->y, $workers->toArray()));
            $avgAge = round($total / $workers->count(), 1);
        }

        $available = Worker::whereNotIn('id', DB::table('workers_in_departments')->where('department_id', $id)->pluck('worker_id'))->get();

        return (new View('departments.show', [
            'department' => $dept, 'workers' => $workers,
            'avg_age' => $avgAge, 'available_workers' => $available
        ]))->render();
    }

    public function attach($id, Request $request): string {
        $dept = Department::findOrFail($id);
        if ($request->workers) {
            foreach ($request->workers as $wid) $dept->workers()->attach($wid);
        }
        app()->route->redirect('/departments/' . $id);
        return '';
    }
}