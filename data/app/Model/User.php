<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface {
    public $timestamps = false;
    protected $fillable = ['name', 'login', 'password', 'role'];

    protected static function booted() {
        static::created(fn($u) => $u->update(['password' => md5($u->password)]));
    }

    public function findIdentity(int $id) { return self::find($id); }
    public function getId(): int { return $this->id; }
    public function attemptIdentity(array $c) {
        return self::where('login', $c['login'])->where('password', md5($c['password']))->first();
    }
}