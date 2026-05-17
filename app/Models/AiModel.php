<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiModel extends Model
{
    protected $table = 'ai_models';

    protected $fillable = [
        'provider',
        'label',
        'model',
        'api_key',
        'base_url',
        'max_tokens',
        'temperature',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'max_tokens' => 'integer',
        'temperature' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('label');
    }

    public static function providers(): array
    {
        return [
            'openai' => 'OpenAI',
            'google' => 'Google Gemini',
            'anthropic' => 'Anthropic Claude',
            'deepseek' => 'DeepSeek',
            'groq' => 'Groq',
            'mistral' => 'Mistral AI',
            'cohere' => 'Cohere',
            'custom' => 'Custom / Lainnya',
        ];
    }
}
