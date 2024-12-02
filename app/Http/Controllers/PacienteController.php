<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Services\LogService; // Importação do LogService

class PacienteController extends Controller
{
    public function index()
    {
        // Exibir todos os pacientes
        $pacientes = Paciente::all();
        return view('pacientes.index', compact('pacientes'));
    }

    public function create()
    {
        return view('pacientes.create');
    }

    public function show(Paciente $paciente)
    {
        return view('pacientes.show', compact('paciente'));
    }

    public function edit(Paciente $paciente)
    {
        return view('pacientes.edit', compact('paciente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'contacto' => 'required|string|max:255',
            'idade' => 'required|integer',
            'sexo' => 'required|string',
            'estado_medico' => 'required|string',
            'consultas' => 'required|string',
            'diagnostico' => 'required|string',
            'medicamentos' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $paciente = Paciente::create($request->all());

            // Registrar log de sucesso
            LogService::record([
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
                'model' => Paciente::class,
                'model_id' => $paciente->id,
                'action' => 'create',
                'changes' => $paciente->toArray(),
                'status' => 'success',
                'message' => 'Paciente criado com sucesso.',
                'ip_address' => $request->ip(),
            ]);

            DB::commit(); // Confirma as alterações no banco de dados

            return redirect()->route('pacientes.index')->with('success', 'Paciente criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack(); // Reverte as alterações no banco de dados em caso de erro

            // Registrar log de erro
            LogService::record([
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
                'model' => Paciente::class,
                'action' => 'create',
                'status' => 'error',
                'message' => 'Erro ao criar paciente: ' . $e->getMessage(),
                'ip_address' => $request->ip(),
            ]);

            return redirect()->back()->with('error', 'Erro ao criar paciente.');
        }
    }

    public function update(Request $request, Paciente $paciente)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'contacto' => 'required|string|max:255',
            'idade' => 'required|integer',
            'sexo' => 'required|string',
            'estado_medico' => 'required|string',
            'consultas' => 'required|string',
            'diagnostico' => 'required|string',
            'medicamentos' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $oldAttributes = $paciente->getAttributes();
            $paciente->update($request->all());

            // Registrar log de sucesso
            LogService::record([
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
                'model' => Paciente::class,
                'model_id' => $paciente->id,
                'action' => 'update',
                'changes' => ['before' => $oldAttributes, 'after' => $paciente->getAttributes()],
                'status' => 'success',
                'message' => 'Paciente atualizado com sucesso.',
                'ip_address' => $request->ip(),
            ]);

            DB::commit(); // Confirma as alterações no banco de dados

            return redirect()->route('pacientes.index')->with('success', 'Paciente atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack(); // Reverte as alterações no banco de dados em caso de erro

            // Registrar log de erro
            LogService::record([
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
                'model' => Paciente::class,
                'model_id' => $paciente->id,
                'action' => 'update',
                'status' => 'error',
                'message' => 'Erro ao atualizar paciente: ' . $e->getMessage(),
                'ip_address' => $request->ip(),
            ]);

            return redirect()->back()->with('error', 'Erro ao atualizar paciente.');
        }
    }

    public function destroy(Paciente $paciente)
    {
        DB::beginTransaction();
        try {
            $paciente->delete();

            // Registrar log de sucesso
            LogService::record([
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
                'model' => Paciente::class,
                'model_id' => $paciente->id,
                'action' => 'delete',
                'status' => 'success',
                'message' => 'Paciente removido com sucesso.',
                'ip_address' => request()->ip(),
            ]);

            DB::commit(); // Confirma as alterações no banco de dados

            return redirect()->route('pacientes.index')->with('success', 'Paciente removido com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack(); // Reverte as alterações no banco de dados em caso de erro

            // Registrar log de erro
            LogService::record([
                'user_id' => auth()->id(),
                'user_name' => auth()->user()->name,
                'model' => Paciente::class,
                'model_id' => $paciente->id,
                'action' => 'delete',
                'status' => 'error',
                'message' => 'Erro ao remover paciente: ' . $e->getMessage(),
                'ip_address' => request()->ip(),
            ]);

            return redirect()->back()->with('error', 'Erro ao remover paciente.');
        }
    }
}
