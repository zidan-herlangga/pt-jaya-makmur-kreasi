<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdvertisingPointRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Pastikan user memiliki role yang diizinkan
        return $this->user()->hasAnyRole(['admin', 'super-admin', 'editor']);
    }

    public function rules(): array
    {
        // Mengambil parameter route secara dinamis
        $point = $this->route('advertising_point');
        
        // Ambil ID jika parameter berupa objek (Route Model Binding), jika tidak gunakan langsung
        $pointId = ($point instanceof \App\Models\AdvertisingPoint) ? $point->id : $point;

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:200'],
            'slug' => [
                'required',
                \Illuminate\Validation\Rule::unique('advertising_points')->ignore($this->route('advertisingPoint')),
            ],
            'location_name' => ['nullable', 'string', 'max:200'],
            'city' => ['nullable', 'string', 'max:100'],
            'lat' => ['nullable', 'numeric', 'between:-90,90'],
            'long' => ['nullable', 'numeric', 'between:-180,180'],
            'orientation' => ['nullable', 'string', 'in:horizontal,vertical,rooftop'],
            'size_dimension' => ['nullable', 'string', 'max:50'],
            'light_type' => ['nullable', 'string', 'in:LED,Neon,Frontlit,Backlit,None'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:9999999999999'],
            'status' => ['required', 'in:available,booked,maintenance'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'gallery' => ['nullable', 'array'],
            'gallery.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'description' => ['nullable', 'string'],

            // SEO Fields
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
            'og_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'json_ld_schema' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('price')) {
            $price = trim($this->price);

            // Hilangkan prefix "Rp" jika ada
            $price = preg_replace('/^Rp\s*/i', '', $price);

            if (str_contains($price, ',')) {
                // Format Indonesia: titik=ribuan, koma=desimal
                $price = str_replace(['.', ','], ['', '.'], $price);
            } elseif (substr_count($price, '.') > 1) {
                // Banyak titik: treat sebagai pemisah ribuan
                $price = str_replace('.', '', $price);
            }
            // Satu titik: biarkan (format internasional, titik=desimal)

            $this->merge(['price' => $price]);
        }
    }
}