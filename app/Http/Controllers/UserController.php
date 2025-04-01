<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserInsertRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Services\UserService;
use Exception;
use Log;

class UserController extends Controller
{
    protected $userService;

    public function painel()
    {
        $users = $this->userService->indexUsers();
        return view('users.painel', ['users' => $users]);
    }

    public function insertUser(UserInsertRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $this->userService->store($validatedData);
            return redirect()->back()->with('success', 'Foi inserido um usuário com sucesso');
        } catch (Exception $e) {
            Log::error('Erro ao inserir usuário', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->withErrors('Houve um erro inesperado ao inserir um novo usuário. Tente novamente.')->withInput();
        }
    }
    
    public function updateUser(UserUpdateRequest $request, $id)
    {
        try {
            $validatedData = $request->validated();
            $this->userService->update($id, $validatedData);
            return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso');
        } catch (Exception $e) {
            Log::error('Erro ao atualizar usuário', [
                'user_id' => $id,
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
            return redirect()->route('usuarios.index')->with('error', 'Ocorreu um erro ao atualizar o usuário. Tente novamente mais tarde.');
        }
    }
    
    public function changePassword()
    {
        return view('users.password');
    }
    
    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            $result = $this->userService->updatePassword($request->validated());
    
            if ($result !== true) {
                return back()->with('error', $result);
            }
    
            return redirect()->route('riscos.index')->with('status', 'Senha alterada com sucesso');
        } catch (Exception $e) {
            Log::error('Erro ao alterar senha', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'Ocorreu um erro ao alterar a senha. Tente novamente mais tarde.');
        }
    }
    
    public function destroy($id)
    {
        try {
            $this->userService->delete($id);
            return redirect()->back()->with('success', 'Usuário deletado com sucesso.');
        } catch (Exception $e) {
            Log::error('Erro ao deletar usuário', [
                'user_id' => $id,
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Ocorreu um erro ao excluir o usuário. Tente novamente mais tarde.');
        }
    }
    

    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
    }
}
