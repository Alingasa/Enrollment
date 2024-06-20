{{-- <x-filament::page> --}}
    <div style="display: flex; align-items: center; padding: 20px; border: 1px solid #ddd; border-radius: 10px; background: linear-gradient(135deg, #f9f9f9, #ececec); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
        {{-- <div style="flex: 1; text-align: center;">
            <img src="{{ $record->profile_image ? url($record->profile_image) : url('default_images/me.jpg') }}" alt="Profile Image" style="border-radius: 50%; width: 150px; height: 150px; object-fit: cover; border: 3px solid #fff; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
        </div>
        <div style="flex: 2; padding-left: 20px;">
            <h2 style="margin: 0; font-size: 24px; color: #333; font-family: 'Arial, sans-serif';">{{ $record->first_name }} {{ $record->middle_name }}</h2>
            <p style="margin: 5px 0; font-size: 18px; color: #555; font-family: 'Arial, sans-serif';">Age: {{ $record->age }}</p>
            <p style="margin: 5px 0; font-size: 18px; color: #555; font-family: 'Arial, sans-serif';">Gender: {{ $record->gender }}</p>
        </div> --}}
        <div style="flex: 1; text-align: center;">
            <div style="display: inline-block; padding: 10px; background: #fff; border-radius: 10px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                {!! QrCode::size(200)->generate(route('teacher', Crypt::encryptString($record->id))) !!}

            </div>
        </div>
    </div>
{{-- </x-filament::page> --}}
