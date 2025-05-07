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
        try {
            return User::all();
        } catch (Exception $e) {
            Log::error('Erro ao buscar usuários.', ['error' => $e->getMessage()]);
            throw new ErrorException('Houve um erro inesperado ao retornar a lista de usuários.');
        }
    }

    public function returnUserbyId($id)
    {
        try {
            return User::findOrFail($id);
        } catch (Exception $e) {
            Log::error('Erro ao buscar usuário por ID.', ['error' => $e->getMessage()]);
            throw new ErrorException('Usuário não encontrado.');
        }
    }

    public function storeNewUser(array $data): User
    {
        try {
            $cpf = $this->removeMask($data['cpf']);

            return User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'cpf' => $cpf,
                'unidadeIdFK' => $data['unidadeIdFK'],
                'password' => Hash::make($data['password']),
            ]);
        } catch (Exception $e) {
            Log::error('Erro ao criar novo usuário.', ['error' => $e->getMessage()]);
            throw new ErrorException('Não foi possível criar o usuário. Verifique os dados e tente novamente.');
        }
    }

    public function updateUser(User $user, array $data): User
    {
        try {
            $updateData = [];

            if (!empty($data['name'])) {
                $updateData['name'] = $data['name'];
            }

            if (!empty($data['email'])) {
                $updateData['email'] = $data['email'];
            }

            if (!empty($data['cpf'])) {
                $updateData['cpf'] = $this->removeMask($data['cpf']);
            }

            if (!empty($data['unidadeIdFK'])) {
                $updateData['unidadeIdFK'] = $data['unidadeIdFK'];
            }

            if (!empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            $user->update($updateData);

            return $user;
        } catch (Exception $e) {
            Log::error('Erro ao atualizar usuário.', ['error' => $e->getMessage()]);
            throw new ErrorException('Erro ao atualizar os dados do usuário.');
        }
    }

    public function newPassword(array $data): array
    {
        try {
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
        } catch (Exception $e) {
            Log::warning('Erro ao atualizar senha do usuário.', ['error' => $e->getMessage()]);
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function destroyUser($id): bool
    {
        try {
            $user = $this->returnUserbyId($id);
            return $user->delete();
        } catch (Exception $e) {
            Log::error('Erro ao deletar usuário.', ['error' => $e->getMessage()]);
            throw new ErrorException('Erro ao tentar deletar o usuário.');
        }
    }

    private function removeMask(string $cpf): string
    {
        return preg_replace('/\D/', '', $cpf);
    }
}
