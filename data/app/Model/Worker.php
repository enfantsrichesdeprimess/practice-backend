<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class Worker extends Model implements IdentityInterface {
    public $timestamps = false;
    protected $fillable = ['surname', 'name', 'last_name', 'gender', 'birthday', 'address_id', 'post_id'];
    public function address() { return $this->belongsTo(Address::class); }
    public function post() { return $this->belongsTo(Post::class); }
    public function departments() { return $this->belongsToMany(Department::class, 'workers_in_departments', 'worker_id', 'department_id'); }
    public function fullName(): string { return trim($this->surname . ' ' . $this->name . ' ' . ($this->last_name ?? '')); }
    public function photoUrl(): ?string {
        foreach (['jpg', 'jpeg', 'png', 'gif', 'webp'] as $extension) {
            $relativePath = '/uploads/workers/' . $this->id . '.' . $extension;
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $relativePath)) {
                return app()->route->getUrl($relativePath);
            }
        }
        return null;
    }
    public function findIdentity(int $id) { return self::find($id); }
    public function getId(): int { return $this->id; }
    public function attemptIdentity(array $c) { return null; }
}
