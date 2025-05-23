<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\LogService;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Log;

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

    public function createUser()
    {
        return view('users.createUser');
    }

    public function insertUser(StoreUserRequest $request)
    {
        try {

            $validatedData = $request->validated();
            $this->userService->storeNewUser($validatedData);

            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Inserção',
                'descricao' => "O usuário $usuarioNome inseriu um novo usuário no sistema",
                'user_id' => Auth::user()->id,
            ]);

            return redirect()->route('usuarios.index')->with('success', 'Usuario Inserido com sucesso');

        } catch (Exception $e) {
            Log::error('Houve um erro inesperado ao inserir um novo usuário', ['error' => $e->getMessage()]);
            return redirect()->back()
                ->withErrors('Erro ao inserir o usuário. Tente novamente.')
                ->withInput();
        }
    }

    public function editUser($id)
    {
        $user = $this->userService->returnUserbyId($id);
        return view('users.editUser', compact('user'));
    }

    public function updateUser(UpdateUserRequest $request, $id)
    {
        try {
            $user = $this->userService->returnUserById($id);

            $validatedData = $request->validated();

            $this->userService->updateUser($id, $validatedData);

            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Atualização',
                'descricao' => "O usuário $usuarioNome atualizou o usuário $user->name (ID: $user->id)",
                'user_id' => Auth::user()->id,
            ]);

            return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso');

        } catch (Exception $e) {
            Log::error('Houve um erro ao atualizar um registro de um servidor.', ['error' => $e->getMessage(), 'usuario_id' => $id]);
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

    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $response = $this->userService->newPassword($validatedData);

            if ($response['status'] === 'error') {
                return back()->with('error', $response['message']);
            }

            return redirect()->route('riscos.index')->with('status', $response['message']);

        } catch (Exception $e) {
            Log::error('Houve um erro ao atualizar a senha de um usuário', [
                'error' => $e->getMessage(),
                'usuario_id' => auth()->user()->id,
            ]);
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
            Log::error('Houve um erro ao deletar um registro de um usuário.', ['error' => $e->getMessage(), 'usuario_id' => $id]);
            return redirect()->back()->with('error', 'Erro ao deletar o usuário. Tente novamente.');
        }
    }
}
