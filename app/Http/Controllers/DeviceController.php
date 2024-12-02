<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Device;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = auth()->user()->devices;
        return view('hardware.index', compact('devices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_identifier' => 'required|string',
            'ip_address' => 'required|ip',
            'mac_address' => 'required|string',
            'location' => 'nullable|string',
        ]);

        DB::beginTransaction(); // Inicia a transação

        try {
            // Criar o dispositivo
            $device = auth()->user()->devices()->create($request->all());

            // Registrar logs ou outras operações adicionais
            logger()->info('Dispositivo criado', ['device_id' => $device->id]);

            DB::commit(); // Confirma a transação
            return redirect()->back()->with('success', 'Dispositivo registado com sucesso.');
        } catch (\Exception $e) {
            DB::rollback(); // Reverte a transação em caso de falha
            logger()->error('Erro ao registrar dispositivo', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao registar o dispositivo.');
        }
    }

    public function destroy(Device $device)
    {
        DB::beginTransaction(); // Inicia a transação

        try {
            // Excluir o dispositivo
            $device->delete();

            // Registrar logs ou outras operações adicionais
            logger()->info('Dispositivo removido', ['device_id' => $device->id]);

            DB::commit(); // Confirma a transação
            return redirect()->back()->with('success', 'Dispositivo removido com sucesso.');
        } catch (\Exception $e) {
            DB::rollback(); // Reverte a transação em caso de falha
            logger()->error('Erro ao remover dispositivo', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Erro ao remover o dispositivo.');
        }
    }
}
