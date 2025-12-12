<?php

namespace App\Models;
use App\Models\Empleado;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  public function empleado()
{
    return $this->hasOne(Empleado::class);
}
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
protected $fillable = [
    'name',
    'email',
    'password',
    'rol',
    'estado',
];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
public function perfil()
{
    return $this->hasOne(PerfilEmpleado::class, 'user_id');
}

// App\Models\User.php
public function documents()
{
    return $this->hasMany(UserDocument::class);
}

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function equipos()
    {
        return $this->belongsToMany(Equipo::class, 'equipo_user')
                    ->withPivot('rol_equipo', 'fecha_asignacion', 'fecha_salida', 'activo')
                    ->withTimestamps()
                    ->where('equipo_user.activo', true);
    }

    // Equipos donde es líder
    public function equiposLiderados()
    {
        return $this->belongsToMany(Equipo::class, 'equipo_user')
                    ->withPivot('rol_equipo', 'fecha_asignacion', 'fecha_salida', 'activo')
                    ->withTimestamps()
                    ->where('equipo_user.rol_equipo', 'lider')
                    ->where('equipo_user.activo', true);
    }

    // Verificar si puede ser líder (admin o supervisor)
    public function puedeSeLider()
    {
        return in_array($this->rol, ['administrador', 'supervisor']);
    }
}
