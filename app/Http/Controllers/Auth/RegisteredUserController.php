<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Services\LogService; // Importação do LogService

class RegisteredUserController extends Controller
{
    /**
     * Exibir todos os utilizadores.
     */
    public function index(Request $request)
    {
        $users = User::all(); // Lista de utilizadores
        $editUser = null;
    
        if ($request->has('edit')) {
            $editUser = User::find($request->edit); // Carrega o utilizador a ser editado
        }
    
        return view('pacientes.user_index', compact('users', 'editUser'));
    }

    /**
     * Exibir a página de registo.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Criar um novo utilizador.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nivel_acesso' => ['required', 'in:admin,gerente,operador'], // Validação para o nível de acesso
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nivel_acesso' => $request->nivel_acesso,
            ]);

            event(new Registered($user));

            // Registar log da criação do utilizador
            LogService::record([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'model' => User::class,
                'model_id' => $user->id,
                'action' => 'create',
                'changes' => $user->getAttributes(),
                'message' => "Utilizador {$user->name} criado.",
                'ip_address' => $request->ip(),
                'status' => 'success',
            ]);

            DB::commit(); // Confirma as alterações
            return redirect()->route('users.index')->with('success', 'Utilizador criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack(); // Reverte as alterações

            // Registar log de erro
            LogService::record([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'model' => User::class,
                'action' => 'create',
                'message' => "Erro ao criar utilizador: {$e->getMessage()}",
                'ip_address' => $request->ip(),
                'status' => 'error',
            ]);

            return redirect()->back()->with('error', 'Erro ao criar utilizador: ' . $e->getMessage());
        }
    }

    /**
     * Atualizar um utilizador existente.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'nivel_acesso' => ['required', 'in:admin,gerente,operador'], // Validação para o nível de acesso
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        DB::beginTransaction();
        try {
            $oldAttributes = $user->getAttributes();

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'nivel_acesso' => $request->nivel_acesso,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
            ]);

            // Registar log da atualização
            LogService::record([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'model' => User::class,
                'model_id' => $user->id,
                'action' => 'update',
                'changes' => ['before' => $oldAttributes, 'after' => $user->getAttributes()],
                'message' => "Utilizador {$user->name} atualizado.",
                'ip_address' => $request->ip(),
                'status' => 'success',
            ]);

            DB::commit(); // Confirma as alterações
            return redirect()->route('users.index')->with('success', 'Utilizador atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack(); // Reverte as alterações

            // Registar log de erro
            LogService::record([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'model' => User::class,
                'action' => 'update',
                'message' => "Erro ao atualizar utilizador: {$e->getMessage()}",
                'ip_address' => $request->ip(),
                'status' => 'error',
            ]);

            return redirect()->back()->with('error', 'Erro ao atualizar utilizador: ' . $e->getMessage());
        }
    }

    /**
     * Excluir um utilizador.
     */
    public function destroy(User $user): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $userName = $user->name;
            $user->delete();

            // Registar log da exclusão
            LogService::record([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'model' => User::class,
                'model_id' => $user->id,
                'action' => 'delete',
                'message' => "Utilizador {$userName} excluído.",
                'ip_address' => request()->ip(),
                'status' => 'success',
            ]);

            DB::commit(); // Confirma as alterações
            return redirect()->route('users.index')->with('success', 'Utilizador excluído com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack(); // Reverte as alterações

            // Registar log de erro
            LogService::record([
                'user_id' => Auth::id(),
                'user_name' => Auth::user()->name,
                'model' => User::class,
                'action' => 'delete',
                'message' => "Erro ao excluir utilizador: {$e->getMessage()}",
                'ip_address' => request()->ip(),
                'status' => 'error',
            ]);

            return redirect()->back()->with('error', 'Erro ao excluir utilizador: ' . $e->getMessage());
        }
    }
}
