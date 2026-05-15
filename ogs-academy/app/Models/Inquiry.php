<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public const STATUSES = [
        'new'       => 'جديد',
        'contacted' => 'تم التواصل',
        'converted' => 'محوَّل',
        'closed'    => 'مغلق',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }
}
