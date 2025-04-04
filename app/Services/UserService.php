<?php


namespace App\Services;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Throwable;


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
        try {
            $cpf = preg_replace('/\D/', '', $validatedData['cpf']);

            Log::info('Criando novo usuário', ['email' => $validatedData['email']]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'cpf' => $cpf,
                'unidadeIdFK' => $validatedData['unidadeIdFK'],
                'password' => Hash::make($validatedData['password']),
            ]);

            Log::info('Usuário criado com sucesso', ['id' => $user->id]);

            return $user;
        } catch (QueryException $e) {
            Log::error('Erro ao criar usuário no banco de dados', ['error' => $e->getMessage(), 'data' => $validatedData]);
            throw new Exception('Erro ao salvar o usuário. Verifique se o e-mail ou CPF já estão cadastrados.');
        } catch (Throwable $e) {
            Log::error('Erro inesperado ao criar usuário', ['error' => $e->getMessage(), 'data' => $validatedData]);
            throw new Exception('Ocorreu um erro inesperado ao criar o usuário. Tente novamente mais tarde.');
        }
    }

    public function update($id, array $data)
    {
        try {
            Log::info('Atualizando usuário', ['id' => $id]);

            $user = $this->findUserbyId($id);
            $updateData = [];

            if (!empty($data['name'])) {
                $updateData['name'] = $data['name'];
            }

            if (!empty($data['email'])) {
                $updateData['email'] = $data['email'];
            }

            if (!empty($data['cpf'])) {
                $updateData['cpf'] = preg_replace('/\D/', '', $data['cpf']);
            }

            if (!empty($data['unidadeIdFK'])) {
                $updateData['unidadeIdFK'] = $data['unidadeIdFK'];
            }

            if (!empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            $user->update($updateData);

            Log::info('Usuário atualizado com sucesso', ['id' => $user->id]);

            return $user;
        } catch (QueryException $e) {
            Log::error('Erro ao atualizar usuário no banco de dados', ['error' => $e->getMessage(), 'id' => $id, 'data' => $data]);
            throw new Exception('Erro ao atualizar o usuário. Verifique os dados informados.');
        } catch (Throwable $e) {
            Log::error('Erro inesperado ao atualizar usuário', ['error' => $e->getMessage(), 'id' => $id, 'data' => $data]);
            throw new Exception('Ocorreu um erro inesperado ao atualizar o usuário. Tente novamente mais tarde.');
        }
    }

    public function updatePassword(array $data)
    {
        try {
            $user = Auth::user();

            if (!Hash::check($data['old_password'], $user->password)) {
                throw new Exception('A senha antiga não confere');
            }

            $user->update([
                'password' => Hash::make($data['new_password']),
            ]);

            Log::info('Senha do usuário atualizada com sucesso', ['id' => $user->id]);

            return true;
        } catch (Throwable $e) {
            Log::error('Erro ao atualizar senha', ['error' => $e->getMessage(), 'user_id' => $user->id]);
            throw new Exception('Erro ao atualizar a senha. Verifique se a senha antiga está correta.');
        }
    }

    public function delete($id)
    {
        try {
            Log::info('Excluindo usuário', ['id' => $id]);

            $user = $this->findUserbyId($id);
            $user->delete();

            Log::info('Usuário excluído com sucesso', ['id' => $id]);

            return true;
        } catch (QueryException $e) {
            Log::error('Erro no banco ao excluir usuário', ['error' => $e->getMessage(), 'id' => $id]);
            throw new Exception('Erro ao excluir o usuário. Verifique se ele possui registros vinculados.');
        } catch (Throwable $e) {
            Log::error('Erro inesperado ao excluir usuário', ['error' => $e->getMessage(), 'id' => $id]);
            throw new Exception('Ocorreu um erro inesperado ao excluir o usuário. Tente novamente mais tarde.');
        }
    }
}
