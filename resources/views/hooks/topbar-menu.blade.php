<div class="flex flex-wrap items-center justify-center">
    @foreach (App\Models\Company::all() as $company)
        @if (session()->get('company_id') == $company->id)
            <div class="p-1">
                <x-filament::button tag="a" size="xs" color="success"
                    href="{{ route('company', $company->id) }}" disabled >
                    {{ $company->short_name }}
                </x-filament::button>
            </div>
        @else
            <div class="p-1">
                <x-filament::button tag="a" size="xs" color="gray"
                    href="{{ route('company', $company->id) }}" outlined>
                    {{ $company->short_name }}
                </x-filament::button>
            </div>
        @endif
    @endforeach
</div>
