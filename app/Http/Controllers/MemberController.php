<?php

namespace App\Http\Controllers;

use App\Helper\Media;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    use Media;

    public function index()
    {
        return view('member.index')->with([
            'Members' => Member::select()->get()
        ]);
    }

    public function show(Member $Member)
    {
        return view('member.show', compact('Member'));
    }

    public function store(Request $request)
    {
        $image_path = null;
        if ($file = $request->file('image')) {
            $fileData = $this->uploads($file, 'members/', $request->name);
            $image_path = $fileData['filePath'];
        }

        $is_baptized = $request->is_baptized == 'on' ? true : false;

        Member::create([
            'name' => $request->name,
            'status' => 1,
            'image' => $image_path,
            'user_id' => $request->user_id,
            'is_baptized' => $is_baptized,
            'baptized_date' => $request->baptized_date,
        ]);

        return redirect('/members')->with('success', 'Se creó al miembro exitosamente');
    }

    public function create()
    {
        return view('member.create')->with([
            'Churches' => User::select()->where("role_id", "=", "2")->get()
        ]);
    }

    public function edit(Member $Member)
    {
        return view('member.edit', compact('Member'))->with([
            'Churches' => User::select()->where("role_id", "=", "2")->get()
        ]);
    }

    public function update(Request $request, Member $Member)
    {
        if ($file = $request->file('image')) {
            if ($Member->imagePath() != null) {
                if (Storage::disk('public')->exists($Member->imagePath())) {
                    Storage::disk('public')->delete($Member->imagePath());
                } else {
                    return redirect()->back()->with('error', 'Error al actualizar al miembro');
                }
            }


            $fileData = $this->uploads($file, 'members/', $request->name);
            $image_path = $fileData['filePath'];
            $Member->image = $image_path;
        }

        $Member->status = $request->status;
        $Member->name = $request->name;
        $Member->user_id = $request->user_id;
        $Member->is_baptized = $request->is_baptized == 'on' ? true : false;
        $Member->baptized_date = $request->baptized_date;


        $Member->update();

        return redirect('/members')->with('success', 'Se actualizó al miembro exitosamente');
    }

}
