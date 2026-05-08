<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;
use Practice\Collect\Collect;

class Worker extends Model implements IdentityInterface {
    public $timestamps = false;
    protected $fillable = ['surname', 'name', 'last_name', 'gender', 'birthday', 'address_id', 'post_id'];
    public function address() { return $this->belongsTo(Address::class); }
    public function post() { return $this->belongsTo(Post::class); }
    public function departments() { return $this->belongsToMany(Department::class, 'workers_in_departments', 'worker_id', 'department_id'); }
    public function fullName(): string {
        return Collect::make([$this->surname, $this->name, $this->last_name])
            ->filter(fn($part) => (string)$part !== '')
            ->implode(' ');
    }
    public function photoUrl(): ?string {
        $file = Collect::make(['jpg', 'jpeg', 'png', 'gif', 'webp'])
            ->map(fn($extension) => [
                'relative' => '/uploads/workers/' . $this->id . '.' . $extension,
                'absolute' => app()->settings->getPublicPath() . '/uploads/workers/' . $this->id . '.' . $extension,
            ])
            ->first(fn($item) => file_exists($item['absolute']));

        return $file ? app()->route->getUrl($file['relative']) : null;
    }
    public function findIdentity(int $id) { return self::find($id); }
    public function getId(): int { return $this->id; }
    public function attemptIdentity(array $c) { return null; }
}
