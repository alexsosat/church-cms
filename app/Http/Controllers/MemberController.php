<?php

namespace App\Http\Controllers;

use App\Helper\Media;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    use Media;

    public function index()
    {
        $user = User::find(Auth::id());
        $members = Member::select();

        if (!Gate::allows('is-admin')) {
            $members = $members->where('user_id', $user->id);
        }

        return view('member.index')->with([
            'Members' => $members->get(),
        ]);
    }

    public function show(Member $Member)
    {
        Gate::authorize('edit-member', $Member);

        return view('member.show', compact('Member'));
    }

    public function store(Request $request)
    {
        $user = User::find(Auth::id());

        if ((int) $request->user_id !== (int)$user->id && !Gate::allows('is-admin')) {
            return redirect()->back()->withErrors(['msg' => 'Error al crear el miembro']);
        }


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
        $user = User::find(Auth::id());
        $Churches = User::select()->where("role_id", "=", "2");

        if (!Gate::allows('is-admin')) {
            $Churches = $Churches->where('id', $user->id);
        }

        return view('member.create')->with([
            'Churches' => $Churches->get(),
        ]);
    }

    public function edit(Member $Member)
    {
        Gate::authorize('edit-member', $Member);

        $user = User::find(Auth::id());
        $Churches = User::select()->where("role_id", "=", "2");

        if (!Gate::allows('is-admin')) {
            $Churches = $Churches->where('id', $user->id);
        }

        return view('member.edit', compact('Member'))->with([
            'Churches' => $Churches->get(),
        ]);
    }

    public function update(Request $request, Member $Member)
    {
        Gate::authorize('edit-member', $Member);

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
