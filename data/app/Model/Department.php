<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;
class Department extends Model {
    public $timestamps = false;
    protected $table = 'department';
    protected $fillable = ['name', 'type'];
    public function workers() { return $this->belongsToMany(Worker::class, 'workers_in_departments', 'department_id', 'worker_id'); }
}
