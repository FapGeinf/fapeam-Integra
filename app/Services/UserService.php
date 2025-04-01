<?php


namespace App\Services;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserService
{
    public function indexUsers()
    {
        return User::all();
    }

    public function findUserbyId($id)
    {
        return User::findOrFail($id);
    }

    public function store(array $validatedData)
    {
        $cpf = preg_replace('/\D/', '', $validatedData['cpf']);

        return User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'cpf' => $cpf,
            'unidadeIdFK' => $validatedData['unidadeIdFK'],
            'password' => Hash::make($validatedData['password']),
        ]);
    }

    public function update($id, array $data)
    {
        $user = $this->findUserbyId($id);


        $updateData = [];

        if (!empty($data['name'])) {
            $updateData['name'] = $data['name'];
        }

        if (!empty($data['email'])) {
            $updateData['email'] = $data['email'];
        }

        if (!empty($data['cpf'])) {
            $updateData['cpf'] = $data['cpf'];
        }

        if (!empty($data['unidadeIdFK'])) {
            $updateData['unidadeIdFK'] = $data['unidadeIdFK'];
        }

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        return $user;
    }

    public function updatePassword(array $data)
    {
        $user = Auth::user();

        if (!Hash::check($data['old_password'], $user->password)) {
            throw new Exception('A senha antiga não confere');
        }

        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);

        return true;
    }

    public function delete($id)
    {
        $user = $this->findUserbyId($id);
        return $user->delete();
    }
}
