<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'category_id', // Tambahkan ini
        'name',
        'description',
        'date',
        'price',
        'image',
        'location',
        'quota'
    ];

    /**
     * Relasi: Event ini termasuk dalam satu kategori tertentu.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi: Event ini dibuat oleh seorang Organizer (User).
     */
    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    /**
     * Relasi: Event ini memiliki banyak tiket.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function checkers()
    {
        return $this->belongsToMany(User::class, 'event_checker', 'event_id', 'checker_id');
    }
}
