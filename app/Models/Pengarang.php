<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengarang extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'pengarangs';

    protected $fillable = [
        'name',
    ];
    protected $dates = ['deleted_at'];
}
