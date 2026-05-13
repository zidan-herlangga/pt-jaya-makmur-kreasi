@extends('layouts.admin', ['seo' => ['title' => 'Pengaturan Situs']])

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Pengaturan Situs</h1>
        <p class="text-slate-500 mt-1">Kelola pengaturan website, SEO, media sosial, dan kontak.</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data"
          x-data="{ activeTab: '{{ array_key_first($groups) }}' }">
        @csrf
        @method('PUT')

        {{-- Tabs --}}
        <div class="flex flex-wrap gap-2 border-b border-slate-200 pb-px">
            @foreach($groups as $group => $label)
                <button type="button" @click="activeTab = '{{ $group }}'"
                        class="px-5 py-3 text-sm font-medium rounded-t-lg transition-all -mb-px"
                        :class="activeTab === '{{ $group }}' ? 'text-green-600 border-b-2 border-green-600 bg-white' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50'">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- Tab Content --}}
        <div class="bg-white rounded-b-xl border border-slate-200 border-t-0 p-6">
            @foreach($groups as $group => $label)
                <div x-show="activeTab === '{{ $group }}'" x-transition:enter="transition-all duration-300">
                    @if(!empty($settings[$group]))
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($settings[$group] as $key => $setting)
                                <div class="{{ in_array($setting['type'], ['textarea', 'image']) ? 'md:col-span-2' : '' }}">
                                    <label class="block text-sm font-medium text-slate-700 mb-1.5" for="{{ $key }}">
                                        {{ $setting['label'] ?? $key }}
                                        @if($setting['description'])
                                            <span class="text-xs text-slate-400 font-normal block mt-0.5">{{ $setting['description'] }}</span>
                                        @endif
                                    </label>

                                    @if($setting['type'] === 'image')
                                        <div class="space-y-3">
                                            @if(!empty($setting['value']))
                                                <div class="relative inline-block group">
                                                    <img src="{{ Storage::url($setting['value']) }}" alt="{{ $key }}"
                                                         class="w-24 h-24 object-cover rounded-xl border border-slate-200">
                                                    <button type="button"
                                                            onclick="this.closest('.space-y-3').querySelector('input[type=file]').click()"
                                                            class="absolute -top-2 -right-2 w-6 h-6 bg-slate-900 text-white rounded-full text-xs opacity-0 group-hover:opacity-100 transition-opacity shadow-md flex items-center justify-center">+</button>
                                                </div>
                                            @endif
                                            <input type="file" name="{{ $key }}" accept="image/jpeg,image/png,image/webp,image/x-icon"
                                                   class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                                        </div>
                                    @elseif(in_array($key, ['meta_description', 'site_description', 'whatsapp_text']))
                                        <textarea name="{{ $key }}" rows="3" id="{{ $key }}"
                                                  class="input-field">{{ $setting['value'] }}</textarea>
                                    @else
                                        <input type="text" name="{{ $key }}" id="{{ $key }}" value="{{ $setting['value'] }}"
                                               class="input-field">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-slate-400 text-sm py-8 text-center">Belum ada pengaturan di grup ini.</p>
                    @endif
                </div>
            @endforeach

            <div class="flex items-center gap-3 pt-6 mt-6 border-t border-slate-200">
                <button type="submit" class="btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Simpan Pengaturan
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
