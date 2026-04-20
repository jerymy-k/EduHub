<x-mail::layout>
    {{-- Header --}}
    <x-slot:header>
        <x-mail::header :url="config('app.url')">
            {{ config('app.name') }}
        </x-mail::header>
    </x-slot:header>

    {{-- Body --}}
    <div style="font-family: 'Figtree', sans-serif;">
        {!! $slot !!}
    </div>

    {{-- Subcopy --}}
    @isset($subcopy)
    <x-slot:subcopy>
        <x-mail::subcopy>
            <div style="border-top: 1px solid #e2e8f0; padding-top: 15px; margin-top: 15px;">
                {!! $subcopy !!}
            </div>
        </x-mail::subcopy>
    </x-slot:subcopy>
    @endisset

    {{-- Footer --}}
    <x-slot:footer>
        <x-mail::footer>
            <div style="text-align: center; opacity: 0.8;">
                © {{ date('Y') }} <strong>Edu<span style="color: #10b981;">Hub</span></strong>. {{ __('Tous droits
                réservés.') }}
            </div>
        </x-mail::footer>
    </x-slot:footer>
</x-mail::layout>
