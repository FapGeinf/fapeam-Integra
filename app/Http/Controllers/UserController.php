<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function painel()
    {
        $users = User::all();

        return view('users.painel', ['users' => $users]);
    }

    public function updateUser(Request $request, $id)
    {

        $user = User::findOrFail($id);

        $rules = [
            'name' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'cpf' => 'nullable|digits:11|unique:users,cpf,' . $user->id,
            'password' => 'nullable|min:8',
            'password_confirmation' => 'nullable|required_with:password|same:password|min:8',
            'unidadeIdFK' => 'nullable|exists:unidades,id',
        ];


        $validator = Validator::make($request->all(), $rules);


        if ($request->filled('password') && !$request->filled('password_confirmation')) {
            $validator->errors()->add('password_confirmation', 'A confirmação da senha é obrigatória quando a senha é fornecida.');
        }

        if ($request->filled('password_confirmation') && $request->filled('password') && $request->input('password') !== $request->input('password_confirmation')) {
            $validator->errors()->add('password_confirmation', 'A confirmação da senha deve corresponder à senha.');
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $data = [];

        if ($request->filled('name')) {
            $data['name'] = $request->input('name');
        }

        if ($request->filled('email')) {
            $data['email'] = $request->input('email');
        }

        if ($request->filled('cpf')) {
            $data['cpf'] = $request->input('cpf');
        }

        if ($request->filled('unidadeIdFK')) {
            $data['unidadeIdFK'] = $request->input('unidadeIdFK');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }


        $user->update($data);


        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso');
    }


    public function changePassword()
    {
        return view('users.password');
    }



    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with('error', 'A senha atual está incorreta');
        }

        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        return back()->with('status', 'Senha alterada com sucesso');
    }



    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->back()->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the user.');
        }
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
