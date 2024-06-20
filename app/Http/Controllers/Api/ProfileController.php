<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class ProfileController extends Controller
{
    //
    public function show($hash){
        try {
            $id = Crypt::decryptString($hash);
            $record = Enrollment::findOrFail($id);

            // foreach ($record as $records) {
                $record->birthdate = Carbon::parse($record->birthdate)->isoFormat('MMMM DD, YYYY');
            // }
        } catch (\Exception $e) {
            // Handle the error if decryption fails or record is not found
            abort(404, 'Record not found');
        }

        return view('profile.show', compact('record'));
    }
}