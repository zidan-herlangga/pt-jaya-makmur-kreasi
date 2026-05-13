<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sender_name',
        'sender_email',
        'sender_phone',
        'company_name',
        'message',
        'honeypot_field',
        'ip_address',
        'user_agent',
        'status',
        'handled_by',
        'handled_at',
        'admin_notes',
    ];

    protected $casts = [
        'handled_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(AdvertisingPoint::class, 'product_id');
    }

    public function handler(): BelongsTo
    {
        return $this->belongsTo(User::class, 'handled_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessed($query)
    {
        return $query->where('status', 'processed');
    }

    public function scopeNotSpam($query)
    {
        return $query->where('status', '!=', 'spam');
    }

    public function isSpam(): bool
    {
        return $this->status === 'spam' || !empty($this->honeypot_field);
    }

    public function markAsProcessed(int $userId): void
    {
        $this->update([
            'status' => 'processed',
            'handled_by' => $userId,
            'handled_at' => now(),
        ]);
    }
}
