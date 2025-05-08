<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enclosure extends Model
{
    /** @use HasFactory<\Database\Factories\EnclosureFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'limit',
        'feeding_at',
    ];

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
