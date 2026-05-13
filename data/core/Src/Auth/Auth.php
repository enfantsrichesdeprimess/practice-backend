<?php
namespace Src\Auth;
use Src\Session;

class Auth {
    private static IdentityInterface $identity;
    private static ?IdentityInterface $resolvedUser = null;

    public static function init(IdentityInterface $user): void {
        self::$identity = $user;
        self::$resolvedUser = self::user();
    }

    public static function login(IdentityInterface $user): void {
        self::$resolvedUser = $user;
        Session::set('id', $user->getId());
    }

    public static function authorize(IdentityInterface $user): void {
        self::$resolvedUser = $user;
    }

    public static function attempt(array $credentials): bool {
        if ($user = self::$identity->attemptIdentity($credentials)) {
            self::login($user);
            return true;
        }
        return false;
    }

    public static function attemptToken(?string $token): bool {
        if (!$token || !method_exists(self::$identity, 'attemptIdentityByToken')) {
            return false;
        }

        $user = self::$identity->attemptIdentityByToken($token);
        if ($user) {
            self::authorize($user);
            return true;
        }

        return false;
    }

    public static function user() {
        if (self::$resolvedUser) {
            return self::$resolvedUser;
        }

        $id = Session::get('id') ?? 0;
        return self::$identity->findIdentity($id);
    }

    public static function check(): bool { return (bool)self::user(); }

    public static function logout(): bool {
        self::$resolvedUser = null;
        Session::clear('id');
        return true;
    }

    public static function issueToken(IdentityInterface $user): string {
        $token = bin2hex(random_bytes(32));

        if (method_exists($user, 'storeAccessToken')) {
            $user->storeAccessToken($token);
        }

        return $token;
    }

    public static function generateCSRF(): string {
        $token = md5(time() . rand());
        Session::set('csrf_token', $token);
        return $token;
    }
}
