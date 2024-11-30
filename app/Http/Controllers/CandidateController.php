<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{
    public function index()
    {
        // Busca todos os candidatos para exibição
        $candidates = Candidate::all();
        return view('candidates.index', compact('candidates'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates,email',
            'cell1' => 'required|string|max:20',
            'document_number' => 'required|string|max:50|unique:candidates,document_number',
            'password' => 'required|string|min:6',
        ]);

        DB::beginTransaction();

        try {
            Candidate::create([
                'name' => $request->name,
                'email' => $request->email,
                'cell1' => $request->cell1,
                'document_number' => $request->document_number,
                'password' => bcrypt($request->password),
            ]);

            DB::commit();
            return redirect()->route('candidates.index')->with('success', 'Candidato criado com sucesso!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao criar candidato: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:candidates,email,' . $id,
            'cell1' => 'required|string|max:20',
            'document_number' => 'required|string|max:50|unique:candidates,document_number,' . $id,
        ]);

        DB::beginTransaction();

        try {
            $candidate = Candidate::findOrFail($id);
            $candidate->update([
                'name' => $request->name,
                'email' => $request->email,
                'cell1' => $request->cell1,
                'document_number' => $request->document_number,
            ]);

            // Forçar um erro para testar rollback
            // throw new \Exception('Erro simulado!');

            DB::commit();
            return redirect()->route('candidates.index')->with('success', 'Candidato atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao atualizar candidato: ' . $e->getMessage() . ' | Transação revertida!');
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $candidate = Candidate::findOrFail($id);
            $candidate->delete();

            DB::commit();
            return redirect()->route('candidates.index')->with('success', 'Candidato excluído com sucesso!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao excluir candidato: ' . $e->getMessage() . ' | Transação revertida!');
        }
    }
}