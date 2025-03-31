<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserInsertRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Services\UserService;
use Exception;

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
            return redirect()->back()->with('success', 'Foi inserido um usuario com sucesso');

        } catch (Exception $e) {
            return redirect()->back()->withErrors('Houve um erro inesperado ao inserir um novo usuario. Tente Novamente')->withInput();
        }
    }

    public function updateUser(UserUpdateRequest $request, $id)
    {
        $validatedData = $request->validated();

        $this->userService->update($id, $validatedData);

        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso');
    }


    public function changePassword()
    {
        return view('users.password');
    }


    public function updatePassword(UpdatePasswordRequest $request)
    {
        $result = $this->userService->updatePassword($request->validated());

        if ($result !== true) {
            return back()->with('error', $result);
        }

        return redirect()->route('riscos.index')->with('status', 'Senha alterada com sucesso');
    }


    public function destroy($id)
    {
        try {
            $this->userService->delete($id);
            return redirect()->back()->with('success', 'User deleted successfully.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the user.');
        }
    }

    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
    }
}
