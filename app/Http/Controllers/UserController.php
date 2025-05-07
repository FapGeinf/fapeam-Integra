<?php

namespace App\Http\Controllers;

use App\Services\LogService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    protected $log;
    protected $userService;

    public function __construct(LogService $log, UserService $userService)
    {
        $this->middleware('auth');
        $this->log = $log;
        $this->userService = $userService;
    }

    public function painel()
    {
        try {
            $users = $this->userService->indexUsers();
            $usuarioNome = Auth::user()->name;

            $this->log->insertLog([
                'acao' => 'Acesso',
                'descricao' => "O usuário $usuarioNome acessou a tela de usuários",
                'user_id' => Auth::user()->id,
            ]);

            return view('users.painel', compact('users'));

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erro ao carregar a tela de usuários. Tente novamente.');
        }
    }

    public function insertUser(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'cpf' => 'required|unique:users,cpf',
                'password' => 'required|string|confirmed|min:8',
                'unidadeIdFK' => 'required|exists:unidades,id',
            ]);

            $this->userService->storeNewUser($request->all());

            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Inserção',
                'descricao' => "O usuário $usuarioNome inseriu um novo usuário no sistema",
                'user_id' => Auth::user()->id,
            ]);

            return redirect()->back()->with('success', 'Usuário inserido com sucesso');

        } catch (Exception $e) {
            return redirect()->back()
                ->withErrors('Erro ao inserir o usuário. Tente novamente.')
                ->withInput();
        }
    }

    public function updateUser(Request $request, $id)
    {
        try {
            $user = $this->userService->returnUserById($id);

            $rules = [
                'name' => 'nullable|string',
                'email' => 'nullable|email|unique:users,email,' . $user->id,
                'cpf' => 'nullable|unique:users,cpf,' . $user->id,
                'password' => 'nullable|min:8',
                'password_confirmation' => 'nullable|required_with:password|same:password|min:8',
                'unidadeIdFK' => 'nullable|exists:unidades,id',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $this->userService->updateUser($user, $request->all());

            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Atualização',
                'descricao' => "O usuário $usuarioNome atualizou o usuário $user->name (ID: $user->id)",
                'user_id' => Auth::user()->id,
            ]);

            return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar o usuário. Tente novamente.');
        }
    }

    public function changePassword()
    {
        try {
            return view('users.password');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erro ao carregar a tela de alteração de senha. Tente novamente.');
        }
    }

    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'old_password' => 'required',
                'new_password' => 'required|confirmed|min:8',
            ]);

            $response = $this->userService->newPassword($request->only(['old_password', 'new_password']));

            if ($response['status'] === 'error') {
                return back()->with('error', $response['message']);
            }

            return redirect()->route('riscos.index')->with('status', $response['message']);

        } catch (Exception $e) {
            return back()->with('error', 'Erro ao atualizar a senha. Tente novamente.');
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = $this->userService->returnUserById($id);
            $this->userService->destroyUser($id);

            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Exclusão',
                'descricao' => "O usuário $usuarioNome deletou o usuário $user->name (ID: $user->id)",
                'user_id' => Auth::user()->id,
            ]);

            return redirect()->back()->with('success', 'Usuário deletado com sucesso.');

        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Erro ao deletar o usuário. Tente novamente.');
        }
    }
}
