{{-- <x-filament::page> --}}
    @if($getRecord())
    <div style="display: flex; align-items: center; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background: linear-gradient(135deg, #f9f9f9, #ececec); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">

        <div style="flex: 1; text-align: center;">
            <div style="display: inline-block; padding: 10px; background: #fff; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                {!! QrCode::size(200)->generate(route('teacher', Crypt::encryptString($getRecord()->id))) !!}

            </div>
        </div>
    </div>
    @endif
{{-- </x-filament::page> --}}
