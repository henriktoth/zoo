<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Animal extends Model
{
    /** @use HasFactory<\Database\Factories\AnimalFactory> */
    use HasFactory, SoftDeletes;

        /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'species',
        'is_predator',
        'born_at',
        'image',
        'enclosure_id'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'born_at' => 'datetime',
            'is_predator' => 'boolean',
            'deleted_at' => 'datetime',
        ];
    }

    public function enclosure()
    {
        return $this->belongsTo(Enclosure::class);
    }
}
