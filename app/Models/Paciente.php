<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'contacto',
        'idade',
        'sexo',
        'estado_medico',
        'consultas',
        'diagnostico',
        'medicamentos',
    ];

    // Não codificar o nome, idade e sexo
    public function setNomeAttribute($value)
    {
        $this->attributes['nome'] = $value; // Não codificado
    }

    public function getNomeAttribute($value)
    {
        return $value; // Não codificado
    }

    // Codificar o contacto
    public function setContactoAttribute($value)
    {
        $this->attributes['contacto'] = Crypt::encryptString($value);
    }

    public function getContactoAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    // Não codificar idade
    public function setIdadeAttribute($value)
    {
        $this->attributes['idade'] = $value; // Não codificado
    }

    public function getIdadeAttribute($value)
    {
        return $value; // Não codificado
    }

    // Não codificar sexo
    public function setSexoAttribute($value)
    {
        $this->attributes['sexo'] = $value; // Não codificado
    }

    public function getSexoAttribute($value)
    {
        return $value; // Não codificado
    }

    // Codificar o estado médico
    public function setEstadoMedicoAttribute($value)
    {
        $this->attributes['estado_medico'] = Crypt::encryptString($value);
    }

    public function getEstadoMedicoAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    // Codificar consultas
    public function setConsultasAttribute($value)
    {
        $this->attributes['consultas'] = Crypt::encryptString($value);
    }

    public function getConsultasAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    // Codificar diagnóstico
    public function setDiagnosticoAttribute($value)
    {
        $this->attributes['diagnostico'] = Crypt::encryptString($value);
    }

    public function getDiagnosticoAttribute($value)
    {
        return Crypt::decryptString($value);
    }

    // Codificar medicamentos
    public function setMedicamentosAttribute($value)
    {
        $this->attributes['medicamentos'] = Crypt::encryptString($value);
    }

    public function getMedicamentosAttribute($value)
    {
        return Crypt::decryptString($value);
    }
}

