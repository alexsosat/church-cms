<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RequestController extends Controller
{
    public function index()
    {
        $user = User::find(Auth::id());
        $requests_made = null;
        $requests_to_authorize = null;


        if (!Gate::allows('is-admin')) {
            $requests_to_authorize = Request::select()->where('authorizing_user_id', $user->id);
            $requests_made = Request::select()->where('requesting_user_id', $user->id);
        }


        return view('request.index')->with([
            'AuthorizingRequests' => $requests_to_authorize->get(),
            'StatusRequest' => $requests_made->get(),
        ]);
    }

    public function createSendingRequest()
    {
        return view('request.create-sending-request')->with([
            'Members' => Member::select()->where('user_id', Auth::id())->get(),
            'Churches' => User::where('role_id', 2)->where('id', '!=', Auth::id())->get(),
        ]);
    }

    public function createReceivingRequest()
    {
        return view('request.create-receiving-request')->with([
            'Members' => Member::select()->where('user_id', "!=", Auth::id())->get(),
            'Churches' => User::where('role_id', 2)->where('id', '!=', Auth::id())->get(),
        ]);
    }

    public function storeSendingRequest(\Illuminate\Http\Request $request)
    {

        foreach ($request->members as $member) {
            Request::create(
                [
                    'type' => 1,
                    'requesting_user_id' => Auth::id(),
                    'authorizing_user_id' => $request->authorizing_user,
                    'member_id' => $member,
                    'status' => 2,
                ]
            );
        }


        return redirect('/requests')->with('success', 'Solicitudes enviadas');
    }

    public function singleRequestAction(\Illuminate\Http\Request $request)
    {
        if ($request->status == 1) {
            RequestController::makeRequestAction($request->request_id);
        }


        $requestDetails = Request::find($request->request_id);

        $requestDetails->status = $request->status;

        $requestDetails->save();

        return redirect('/requests')->with('success', 'Solicitud actualizada');

    }

    public function makeRequestAction($request_id)
    {
        $requestDetails = Request::find($request_id);
        $member = Member::find($requestDetails->member_id);

        if ($requestDetails->type == 1) {
            $member->user_id = $requestDetails->authorizing_user_id;
        }
        if ($requestDetails->type == 2) {
            $member->user_id = $requestDetails->requesting_user_id;
        }


        $member->save();
    }

    public function singleRequestCancel(\Illuminate\Http\Request $request)
    {
        $requestDetails = Request::find($request->request_id);
        $requestDetails->status = 3;
        $requestDetails->save();

        return redirect('/requests')->with('success', 'Solicitud cancelada');
    }
}
