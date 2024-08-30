<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secret extends Model
{
    use HasFactory;

    protected $table = 'secrets';
    protected $primaryKey = 'hash';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;
    protected $fillable = [
        'hash',
        'secretText',
        'createdAt',
        'expiresAt',
        'remainingViews',
    ];

    protected function casts(): array
    {
        return [
            'createdAt' => 'datetime',
            'expiresAt' => 'datetime'
        ];
    }
}
