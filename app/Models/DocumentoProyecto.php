<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class DocumentoProyecto extends Model
{
    use HasFactory;

    protected $table = 'documentos_proyecto';

    protected $fillable = [
        'proyecto_id',
        'nombre',
        'descripcion',
        'ruta',
        'tipo',
        'extension',
        'tamanio',
        'subido_por',
    ];

  public function proyecto()
    {
        return $this->belongsTo(Project::class, 'proyecto_id', 'id');
    }


    public function usuario()
    {
        return $this->belongsTo(User::class, 'subido_por');
    }

    /**
     * Determinar el tipo de documento basado en la extensión
     */
    public static function determinarTipo($extension)
    {
        $extension = strtolower($extension);
        
        $tipos = [
            'imagen' => ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg'],
            'pdf' => ['pdf'],
            'word' => ['doc', 'docx'],
            'excel' => ['xls', 'xlsx', 'csv'],
            'texto' => ['txt'],
        ];

        foreach ($tipos as $tipo => $extensiones) {
            if (in_array($extension, $extensiones)) {
                return $tipo;
            }
        }

        return 'otro';
    }

    /**
     * Obtener el ícono según el tipo
     */
    public function getIcono()
    {
        $iconos = [
            'imagen' => 'bi-image',
            'pdf' => 'bi-file-pdf',
            'word' => 'bi-file-word',
            'excel' => 'bi-file-excel',
            'texto' => 'bi-file-text',
            'otro' => 'bi-file-earmark',
        ];

        return $iconos[$this->tipo] ?? 'bi-file-earmark';
    }

    /**
     * Obtener color del badge según tipo
     */
    public function getColorBadge()
    {
        $colores = [
            'imagen' => 'success',
            'pdf' => 'danger',
            'word' => 'primary',
            'excel' => 'success',
            'texto' => 'secondary',
            'otro' => 'dark',
        ];

        return $colores[$this->tipo] ?? 'secondary';
    }

    /**
     * Verificar si es una imagen
     */
    public function esImagen()
    {
        return $this->tipo === 'imagen';
    }

    /**
     * Obtener URL pública del archivo
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->ruta);
    }

    /**
     * Formatear tamaño del archivo
     */
    public function getTamanioFormateadoAttribute()
    {
        if (!$this->tamanio) return '-';

        $bytes = $this->tamanio;
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' bytes';
    }
}