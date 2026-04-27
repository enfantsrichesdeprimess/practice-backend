<?php
namespace Controller;
use Src\Request;
use Src\View;
use Src\Auth\Auth;
use Model\User;
use Src\Validator\Validator;

class AuthController {
    public function login(Request $request): string {
        if ($request->method === 'GET') return (new View('auth.login'))->render();

        $validator = new Validator($request->all(), [
            'login' => ['required'], 'password' => ['required']
        ], ['required' => 'Поле :field обязательно']);

        if ($validator->fails()) {
            return (new View('auth.login', ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]))->render();
        }

        if (Auth::attempt($request->all())) {
            app()->route->redirect('/workers');
            return '';
        }
        return (new View('auth.login', ['message' => 'Неверный логин или пароль']))->render();
    }

    public function logout(): void {
        Auth::logout();
        app()->route->redirect('/login');
    }

    public function register(Request $request): string {
        if ($request->method === 'GET') return (new View('auth.signup'))->render();

        $validator = new Validator($request->all(), [
            'name' => ['required'],
            'login' => ['required', 'unique:users,login'],
            'password' => ['required', 'min:6'],
            'role' => ['required', 'in:admin,hr']
        ], [
            'required' => 'Поле :field обязательно',
            'unique' => 'Логин занят',
            'min' => 'Минимум :min символов'
        ]);

        if ($validator->fails()) {
            return (new View('auth.signup', ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]))->render();
        }

        User::create($request->all());
        app()->route->redirect('/login');
        return '';
    }
}