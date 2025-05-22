<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use ErrorException;
use Exception;

class UserService
{
    public function indexUsers()
    {
        return User::all();
    }

    public function returnUserbyId($id)
    {
        return User::findOrFail($id);
    }

    public function storeNewUser(array $data): User
    {
        $cpf = $this->removeMask($data['cpf']);
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'cpf' => $cpf,
            'unidadeIdFK' => $data['unidadeIdFK'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function updateUser(int $id, array $data): User
    {
        $user = $this->returnUserbyId($id);

        if (isset($data['cpf'])) {
            $data['cpf'] = $this->removeMask($data['cpf']);
        }

        $user->update($data);

        return $user;
    }

    public function newPassword(array $data): array
    {

        $user = Auth::user();

        if (!isset($data['old_password'], $data['new_password'])) {
            throw new Exception('Preencha todos os campos de senha.');
        }

        if (!Hash::check($data['old_password'], $user->password)) {
            throw new Exception('A senha atual está incorreta.');
        }

        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);

        return ['status' => 'success', 'message' => 'Senha atualizada com sucesso.'];

    }

    public function destroyUser($id): bool
    {

        $user = $this->returnUserbyId($id);
        $user->delete();
        return true;

    }

    private function removeMask(string $cpf): string
    {
        return preg_replace('/\D/', '', $cpf);
    }
}
