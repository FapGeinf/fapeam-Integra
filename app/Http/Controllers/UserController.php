<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
    }

    public function painel()
    {
        try {
            $users = $this->userService->indexUsers();
            return view('users.painel', compact('users'));

        } catch (Exception $e) {
            Log::error('Erro ao carregar painel de usuários', ['error' => $e->getMessage()]);
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
            $newUser = $this->userService->storeNewUser($validatedData);

            Log::info("Inserção de Usuário realizada", [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?? 'Visitante',
                'new_user_id' => $newUser->id ?? null,
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
        try {
            $user = $this->userService->returnUserbyId($id);
            return view('users.editUser', compact('user'));
        } catch (Exception $e) {
            Log::error('Erro ao editar usuário', ['error' => $e->getMessage(), 'target_user_id' => $id]);
            return redirect()->back()->with('error', 'Erro ao carregar dados do usuário.');
        }
    }

    public function updateUser(UpdateUserRequest $request, $id)
    {
        try {
            $user = $this->userService->returnUserById($id);

            $validatedData = $request->validated();
            $this->userService->updateUser($id, $validatedData);

            Log::info("Atualização de Usuário realizada", [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?? 'Visitante',
                'updated_user_id' => $user->id ?? $id,
                'updated_user_name' => $user->name ?? null,
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
            Log::error('Houve um erro ao retornar a tela de alteração de senha do usuário', ['error' => $e->getMessage()]);
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

            Log::info("Atualização de Senha realizada", [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?? 'Visitante',
            ]);

            return redirect()->route('riscos.index')->with('status', $response['message']);

        } catch (Exception $e) {
            Log::error('Houve um erro ao atualizar a senha de um usuário', [
                'error' => $e->getMessage(),
                'usuario_id' => Auth::id(),
            ]);
            return back()->with('error', 'Erro ao atualizar a senha. Tente novamente.');
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = $this->userService->returnUserById($id);
            $this->userService->destroyUser($id);

            Log::info("Exclusão de Usuário realizada", [
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name ?? 'Visitante',
                'deleted_user_id' => $id,
                'deleted_user_name' => $user->name ?? null,
            ]);

            return redirect()->back()->with('success', 'Usuário deletado com sucesso.');

        } catch (Exception $e) {
            Log::error('Houve um erro ao deletar um registro de um usuário.', ['error' => $e->getMessage(), 'usuario_id' => $id]);
            return redirect()->back()->with('error', 'Erro ao deletar o usuário. Tente novamente.');
        }
    }

    public function usersRelatorio()
    {
        try {
            return $this->userService->pdfUsers();
        } catch (Exception $e) {
            Log::error('Erro ao gerar relatório PDF de usuários', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Houve um erro inesperado ao gerar o pdf de usuarios, tente novamente');
        }
    }
}