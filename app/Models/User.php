<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Unidade;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf',
        'unidadeIdFK',
				'usuario_tipo_fk'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
		public function findForPassport($username) {
			return $this->where('cpf', $username)->first();
		}
    public function unidade()
    {
        return $this->belongsTo(Unidade::class, 'unidadeIdFK');
    }
		public function tipo()
		{
            return $this->belongsTo(UsuarioTipo::class, 'usuario_tipo_fk');
		}
    public function riscos()
    {
        return $this->hasMany(Risco::class, 'userIdRisco');
    }
}
