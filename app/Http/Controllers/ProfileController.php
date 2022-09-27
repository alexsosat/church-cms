<?php

namespace App\Http\Controllers;

use App\Helper\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use Media;

    public function show()
    {
        $id = Auth::id();
        $user = User::find($id);
        return view('profile.show')->with([
            'User' => $user
        ]);
    }

    public function updateInfo(Request $request)
    {
        $user = User::find(Auth::id());
        if ($file = $request->file('image')) {
            if ($user->imagePath() != null) {
                if (Storage::disk('public')->exists($user->imagePath())) {
                    Storage::disk('public')->delete($user->imagePath());
                } else {
                    return redirect()->back()->with('error', 'Error al actualizar el usuario');
                }
            }


            $fileData = $this->uploads($file, 'churches/', $request->name);
            $image_path = $fileData['filePath'];
            $user->image = $image_path;
        }

        $user->name = $request->name;


        $user->update();

        return redirect()->back()->with('success', 'Se actualizó el usuario exitosamente');
    }

    public function updateCredentials(Request $request)
    {
        $user = User::find(Auth::id());

        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;

        $user->update();

        return redirect()->back()->with('success', 'Se actualizó el usuario exitosamente');
    }

    public function updateGeo(Request $request)
    {
        $user = User::find(Auth::id());


        $user->address = $request->address;
        $user->municipality = $request->city;
        $user->state = $request->state;
        $user->zip_code = $request->zip_code;

        $user->update();

        return redirect()->back()->with('success', 'Se actualizó el usuario exitosamente');
    }

    public function updatePsswd(Request $request)
    {

        $request->validate([
            'prevPsswd' => 'required',
            'newPsswd' => 'required|min:8',
            'confirmPsswd' => 'required|min:8',
        ]);

        $user = User::find(Auth::id());

        if (!Hash::check($request->prevPsswd, $user->password)) {
            return redirect()->back()->withErrors(['msg' => 'La contraseña actual no coincide con la que se ingresó']);
        }

        if ($request->prevPsswd == $request->newPsswd) {
            return redirect()->back()->withErrors(['msg' => 'La contraseña nueva no puede ser igual a la anterior']);
        }

        if ($request->newPsswd != $request->confirmPsswd) {
            return redirect()->back()->with(['msg' => 'Las contraseñas nuevas no coinciden']);
        }


        $user->password = Hash::make($request->newPsswd);

        $user->update();

        return redirect()->back()->with('success', 'Se actualizó el usuario exitosamente');
    }

}
