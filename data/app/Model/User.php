<?php
namespace Model;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class User extends Model implements IdentityInterface {
    public $timestamps = false;
    protected $fillable = ['login', 'password', 'role', 'api_token'];

    protected static function booted() {
        static::created(fn($u) => $u->update(['password' => md5($u->password)]));
    }

    public function findIdentity(int $id) { return self::find($id); }
    public function getId(): int { return $this->id; }
    public function attemptIdentity(array $c) {
        return self::where('login', $c['login'])->where('password', md5($c['password']))->first();
    }
    public function attemptIdentityByToken(string $token) {
        return self::where('api_token', $token)->first();
    }
    public function storeAccessToken(string $token): void {
        $this->update(['api_token' => $token]);
    }
}
