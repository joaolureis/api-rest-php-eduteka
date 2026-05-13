<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::orderByDesc('id')->paginate(3, ['*'], 'current_page');

        return new UserCollection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = ($request->validated());

        try {
            $user = new User();
            $user->fill($data);

            //Setando uma senha padrão para o usuário criado de teste
            $user->password = Hash::make(123);
            $user->save();
            return response()->json([
                'message' => 'Usuário criado com sucesso',
                'data' => $user,
            ], 201);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Falha ao inserir o usuário'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json($user, 200);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $data = $request->validated();

        try {
            $user = User::findOrFail($id);
            $user->update($data);

            return response()->json([
                'message' => 'Usuário atualizado com sucesso',
                'data' => $user,
            ], 200);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Falha ao atualizar o usuário'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        try {
            $removed = User::destroy($id);
            if(!$removed){
                throw new Exception('Usuário não encontrado');
            }

            return response()->json(null, 204);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Falha ao excluir o usuário'], 400);
        }
    }
}
