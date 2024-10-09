<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDnNpCp extends Model
{
    use HasFactory;

    protected $table = 'projects_dn_np_cp';
    protected $fillable = [
        'name',
        'type',
        'client',
    ];
}
