<?php
// =========================================================
// app/Models/Team.php
// =========================================================
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Team extends Model {
    protected $fillable = ['name', 'department', 'description', 'is_active'];
    public function users() { return $this->hasMany(User::class); }
}
