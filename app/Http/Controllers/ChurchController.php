<?php

namespace App\Http\Controllers;

use App\Helper\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ChurchController extends Controller
{
    use Media;

    public function index()
    {
        return view('church.index')->with([
            'Churches' => User::select()->where("role_id", "=", "2")->get()
        ]);
    }

    public function edit(User $User)
    {
        return view('church.edit', compact('User'));
    }

    public function store(Request $request)
    {
        $image_path = null;
        if ($file = $request->file('image')) {
            $fileData = $this->uploads($file, 'churches/', $request->name);
            $image_path = $fileData['filePath'];
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'username' => $request->username,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'municipality' => $request->city,
            'zip_code' => $request->zip_code,
            'role_id' => 2,
            'image' => $image_path
        ]);

        return redirect('/churches')->with('success', 'Se creó la iglesia exitosamente');

    }

    public function create()
    {
        return view('church.create');
    }

    public function updateInfo(Request $request, User $User)
    {
        $church = User::find($User->id);
        if ($file = $request->file('image')) {
            if ($church->imagePath() != null) {
                if (Storage::disk('public')->exists($church->imagePath())) {
                    Storage::disk('public')->delete($church->imagePath());
                } else {
                    return redirect()->back()->with('error', 'Error al actualizar la iglesia');
                }
            }


            $fileData = $this->uploads($file, 'churches/', $request->name);
            $image_path = $fileData['filePath'];
            $church->image = $image_path;
        }

        $church->name = $request->name;
        $church->email = $request->email;
        $church->phone = $request->phone;


        $church->update();

        return redirect('/churches')->with('success', 'Se actualizó la iglesia exitosamente');
    }

    public function updateCredentials(Request $request, User $User)
    {
        $church = User::find($User->id);


        if ($request->password != null) {
            $church->password = Hash::make($request->password);
        }

        $church->username = $request->username;


        $church->update();

        return redirect('/churches')->with('success', 'Se actualizó la iglesia exitosamente');
    }

    public function updateGeo(Request $request, User $User)
    {
        $church = User::find($User->id);


        $church->address = $request->address;
        $church->municipality = $request->city;
        $church->state = $request->state;
        $church->zip_code = $request->zip_code;

        $church->update();

        return redirect('/churches')->with('success', 'Se actualizó la iglesia exitosamente');
    }


    public function destroy(Request $request)
    {
        $church = User::find($request->church_id);

        if ($church->imagePath() != null) {
            if (Storage::disk('public')->exists($church->imagePath())) {
                Storage::disk('public')->delete($church->imagePath());
            } else {
                return redirect()->back()->with('error', 'Error al eliminar la iglesia');
            }
        }
        $church->delete();

        return redirect()->back()->with('success', 'Se eliminó la iglesia exitosamente');
    }


}

