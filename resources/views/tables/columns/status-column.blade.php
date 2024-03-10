@php use Illuminate\Support\Str; @endphp

<div class="px-3 py-1.5 rounded-full text-sm" >
    {{ ucwords(strtolower(str_replace('_', ' ', $getState()))) }}
</div>
