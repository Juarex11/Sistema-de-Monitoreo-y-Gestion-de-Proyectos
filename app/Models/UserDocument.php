<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocument extends Model
{
    use HasFactory;

    protected $fillable = [ 'user_id',
    'name',
    'code',
    'file',
    'date',
    'uploaded_by'];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
