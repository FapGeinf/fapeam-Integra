<?php

namespace App\Http\Controllers;

use App\Services\LogService;
use Exception;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;


class UserController extends Controller
{
    protected $log;
    public function painel()
    {
        $users = User::all();
        $usuarioNome = Auth::user()->name;
        $this->log->insertLog([
            'acao' => 'Acesso',
            'descricao' => "O usuario $usuarioNome acessou a tela de usuários",
            'user_id' => Auth::user()->id
        ]);
        return view('users.painel', ['users' => $users]);
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

            $cpf = preg_replace('/\D/', '', $request->cpf);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'cpf' => $cpf,
                'unidadeIdFK' => $request->unidadeIdFK,
                'password' => Hash::make($request->password),
            ]);

            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Inserção',
                'descricao' => "O usuario $usuarioNome inseriu um novo usuario de $user->nome no sistema",
                'user_id' => Auth::user()->id
            ]);

            return redirect()->back()->with('success', 'Foi inserido um usuario com sucesso');

        } catch (Exception $e) {
            return redirect()->back()->withErrors('Houve um erro inesperado ao inserir um novo usuario. Tente Novamente')->withInput();
        }
    }

    private function removeMask($cpf)
    {
        $cpf = preg_replace('/\D/', '', $cpf);
        return $cpf;
    }

    public function updateUser(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $rules = [
            'name' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'cpf' => 'nullable|unique:users,cpf,' . $user->id,
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
            $data['cpf'] = $this->removeMask($request->input('cpf'));
        }

        if ($request->filled('unidadeIdFK')) {
            $data['unidadeIdFK'] = $request->input('unidadeIdFK');
        }

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }


        $user->update($data);

        $usuarioNome = Auth::user()->name;
        $this->log->insertLog([
            'acao' => 'Atualização',
            'descricao' => "O usuario $usuarioNome atualizou um usuario de nome $user->nome e id $user->id no sistema",
            'user_id' => Auth::user()->id
        ]);


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
        //return back()->with('status', 'Senha alterada com sucesso');
        return redirect()->route('riscos.index')->with('status', 'Senha alterada com sucesso');
    }



    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            $usuarioNome = Auth::user()->name;
            $this->log->insertLog([
                'acao' => 'Exclusão',
                'descricao' => "O usuario $usuarioNome deletou um usuario de nome $user->nome e id $user->id no sistema",
                'user_id' => Auth::user()->id
            ]);

            return redirect()->back()->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the user.');
        }
    }

    public function __construct(LogService $log)
    {
        $this->middleware('auth');
        $this->log = $log;
    }
}
