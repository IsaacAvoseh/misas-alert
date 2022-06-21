<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ToastrController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        $users = DB::table('user_cred')->orderBy('created')->get();
        // dd($user);
        session()->put('success', 'Item Successfully Created.');
        return view('toastrCheck', compact('users'));
    }

    public function checkBilling(Request $request){
        if($request->location == null){
            return response()->json(['error' => 'No location provided in the request']);
        }
        $billings = DB::table('billing_session')->where('location', $request->location)->count();

        return response()->json([
            'billings' => $billings,
            'role_5_message' => 'New Diagnostic Notification Request',
            'role_3_message' => 'New Patient Checked In',
        ]);
    }

    public function billingRequest(Request $request){
        if($request->location == null){
            return response()->json(['error' => 'No location provided in the request']);
        }
        $billings_request = DB::table('asmt_invoices')->where('location', $request->location)->count();

        return response()->json([
            'billings_request' => $billings_request,
            'message' => 'New Incoming Billing Request'
        ]);
    }

    public function prescriptionAlert(Request $request){
        if ($request->location == null) {
            return response()->json(['error' => 'No location provided in the request']);
        }

        $prescriptions = DB::table('doc_prescriptions')->where('location', $request->location)->where('dispensed', 'No')->count(); 
        return response()->json([
            'prescriptions' => $prescriptions,
            'message' => 'New Prescription Alert'
        ]);

    }

    public function checkApproved()
    {
        $approved = DB::table('doc_pres_tests')->where('status', 1)->count();
        return response()->json([
            'approved' => $approved
        ], 200);
    }

    public function checkDispensed(){
        $dispensed = DB::table('doc_pres_tests')->where('dispensed', 'Yes')->count();
        // dd($dispensed);
        return response()->json([
            'dispensed' => $dispensed
        ], 200);
    }


    public function newPatient(Request $request){
        $patients = DB::table('notification')->where('doc_id', $request->user_id)->count();
        return response()->json([
            'patients' => $patients,
            'user_id' => $request->user_id
        ], 200);
    }

    public function newMessage(Request $request){
        $message = DB::table('threads')->where('to_user', $request->user_id)->count();
        // dd($message);
        return response()->json([
            'message' => $message,
            'user_id' => $request->user_id
        ], 200);
    }

    public function patientResult(Request $request){
        //get record modified 10 seconds ago
        $date = new DateTime();
        $date->modify('-10 seconds');
        $date = $date->format('Y-m-d H:i:s');
        $result = DB::table('doc_pres_tests')->where('doctor', $request->user_id)->where('dispensed', 'Yes')->where('modified', '>=', $date)->count(); //get record modified 10 seconds ago
        // dd($result);
        return response()->json([
            'result' => $result,
            'user_id' => $request->user_id
        ], 200);

    }
}
