<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',     // ID do usuário que realizou a ação
        'user_name',   // Nome do usuário que realizou a ação
        'ip_address',  // Endereço IP do usuário
        'model',       // Nome do modelo afetado
        'model_id',    // ID do registro afetado
        'action',      // Ação realizada (create, update, delete, etc.)
        'changes',     // Alterações feitas
        'status',      // Status da ação (success, error, info)
        'message',     // Descrição da ação
    ];

    protected $casts = [
        'changes' => 'array', // Converte o campo 'changes' em array
    ];

    // Relacionamento com o usuário
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obter o nome do usuário associado ao log.
     */
    public function getUserNameAttribute()
    {
        return $this->user->name ?? $this->user_name ?? 'Sistema';
    }

    /**
     * Formatar a data de criação do log.
     */
    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d/m/Y H:i:s');
    }
}
