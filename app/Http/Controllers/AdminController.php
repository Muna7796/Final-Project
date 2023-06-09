<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blood;
use App\Models\Requestedblood;
use App\Models\Donated;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use DB;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        return view('admin.dashboard');
    }
    public function getManageDonner(){
        //dd('sd');
        if(Auth()->user()->is_admin == 1){
            $data =[
                'donners' => Blood::orderby('id', 'desc')->get()
            ];
            return view('admin.donner', $data); 
        }
        else{
            abort('404');
        }
    }

    public function postAddBlood(Request $request){
        $blood = New Blood;
        $blood->user_id = Auth()->user()->id;   
        $blood->blood_group = $request->input('bloodgroup');
        $blood->any_diseases = $request->input('any_diseases');
        $blood->dob = $request->input('dob');
        $blood->save();
        return redirect()->back()->with('status', 'Blood Information Updated Successsfully.');
    }

    public function getBloodRequest(){
        return view('user.bloodrequest');
    }
    public function postBloodRequest(Request $request){
        $blood = New Requestedblood;
        $blood->user_id = Auth()->user()->id;
        $blood->pname = $request->input('pname');
        $blood->page = $request->input('page');
        $blood->pgender = $request->input('pgender');
        $blood->pprovince = $request->input('province');
        $blood->pdistrict = $request->input('district');
        $blood->pminicipality = $request->input('minicipality');
        $blood->pcity = $request->input('pcity');
        $blood->ptole = $request->input('ptole');
        $blood->pwordno = $request->input('pwordno');
        $blood->hospitalname = $request->input('hospitalname');
        $blood->hospitaladdress = $request->input('hospitaladdress');
        $blood->requestedblood = $request->input('bloodgroup');
        $blood->requestedbloodunit = $request->input('unit');
        $blood->refno = $request->input('refno');
        $blood->requesteddatetime = $request->input('requesteddatetime');
        $blood->save();
        return redirect()->back()->with('status', 'Your Requested has been summited.');
        
    }
    public function getManageRequestBlood(){
        $data=[
            'requestedbloods' => Requestedblood::where('user_id', Auth()->user()->id)->get()
        ];
        return view('user.managerequestedblood', $data);
    }

    public function getSearchBloodGroup(){
        return view('user.searchblood');
    }
    public function postSearchDonner(Request $request){
        $province = $request->get('province');
        $district = $request->get('district');
        $minicipality = $request->get('minicipality');
        $wordno = $request->get('wordno');
       
                    
        $data=[
            'results' => Blood::where('blood_group', $request->get('bloodgroup'))->get(),
            'request' => $request
                
        ];
        return view('user.searchresult', $data);

    }
    public function getContribution(){
        $data =[
            'donates' => Donated::where('user_id', Auth()->user()->id)->get()
        ];
        return view('user.contribution', $data);
    }
    public function postNewDonor(Request $request){
        $fname = $request->input('name');
        $lname = $request->input('lname');
        $gender = $request->input('gender');
        $province = $request->input('province');
        $district = $request->input('district');
        $minicipality = $request->input('minicipality');
        $word_no = $request->input('word_no');
        $tole = $request->input('tole');
        $city = $request->input('city');
        $email = $request->input('email');
        $bloodgroup = $request->input('bloodgroup');
        $dob = $request->input('dob');
        $makeaccount = $request->input('makeaccount');
        // check donnor double entry
         $check = User::where('mobile', $email)->count();
         if($check == 0){
            $password = Str::random(4);
            $user = New User;
            $user->name = $fname;
            $user->lname = $lname;
            $user->is_admin ='0';
            $user->mobile = $email;
            $user->gender = $gender;
            $user->province = $province;
            $user->district = $district;
            $user->minicipality = $minicipality;
            $user->city = $city;
            $user->tole = $tole;
            $user->word_no = $word_no;
            $user->password = Hash::make($password);
            $user->save();

            if($makeaccount == 'on'){
                // send to sms
                $client = new Client();
                $text_message = 'Dear Donor, Your New login username: '.$email. ' password: '. $password.' For login visit http://localhost:8000/login';
                $res = $client->request('POST', 'https://sms.aakashsms.com/sms/v3/send', [
                    'form_params' => [
                        'auth_token' => 'e17b9097e6ec4450ed488ee536924d2b41e4ec8a6ffdac7cff5e2aed0cf4a3c7',
                        'from' => '31001',
                        'to' => $user->mobile,
                        'text' => $text_message,
                    ]
        
                ]);
            }

            // update blood record
            $blood = New Blood;
            $blood->blood_group = $bloodgroup;
            $blood->user_id = $user->id;
            $blood->dob = $dob;
            $blood->save();
            return redirect()->back()->with('message', 'Donor added successfully');
        }
        else{
            return redirect()->back()->with('message', 'Unable to add, due to mobile number duplicate entry');
        }

    }

    public function postEditDonor(Request $request, User $user){
        $fname = $request->input('name');
        $lname = $request->input('lname');
        $gender = $request->input('gender');
        $province = $request->input('province');
        $district = $request->input('district');
        $minicipality = $request->input('minicipality');
        $word_no = $request->input('word_no');
        $tole = $request->input('tole');
        $city = $request->input('city');
        $email = $request->input('email');
        $bloodgroup = $request->input('bloodgroup');
        $dob = $request->input('dob');
       
        // check donnor double entry
         $check = User::where('mobile', $email)->where('id', '!=', $user->id)->count();
         if($check == 0){
            ;
            $user->name = $fname;
            $user->lname = $lname;
            $user->mobile = $email;
            $user->gender = $gender;
            $user->province = $province;
            $user->district = $district;
            $user->minicipality = $minicipality;
            $user->city = $city;
            $user->tole = $tole;
            $user->word_no = $word_no;
            $user->save();

        
            // update blood record
                DB::table('bloods')
                ->where('user_id', $user->id)
                ->limit(1)
                ->update(array('blood_group' =>  $bloodgroup, 'dob' => $dob));
           
            return redirect()->route('admin.getManageDonner')->with('message', 'Donor edited successfully');
        }
        else{
            return redirect()->back()->with('message', 'Unable to edit, due to mobile number duplicate entry');
        }
    }
    public function getDonnerEdit(User $user){
        $data =[
            'user' => $user,
            'bloodinfo' => Blood::where('user_id', $user->id)->limit(1)->first()
        ];
        return view('admin.donneredit', $data);
    }
    public function getManageRequestBloodAdmin(){
        $data =[
            'requestedbloods' => Requestedblood::all()
        ];
        return view('admin.requestedblood', $data);
    }
    public function getRequestedBloodDetail(Requestedblood $bloodrequest){
        $data=[
            'requested' => $bloodrequest,
            'user' => User::find($bloodrequest->user_id)
        ];
        return view('admin.bloodrequestdetail', $data);
    }
    public function postResponse(Request $request, Requestedblood $bloodrequest){
      
        $user = User::find($bloodrequest->user_id);
        $bloodrequest->accpected = $request->input('response11');
        $bloodrequest->bloodbankmessage = $request->input('message1');
        $bloodrequest->save();
        if($request->input('sendsms') == 'on'){
        $client = new Client();
        if($request->input('response11') == 'Yes'){
            $text_message = 'Dear ' .$user->name. ',Please visit blood bank to collect your requested blood.';
        }
        else{
            $text_message = 'Dear ' .$user->name. ', Sorry we donot have requested blood group yet.';
        }
        $res = $client->request('POST', 'https://sms.aakashsms.com/sms/v3/send', [
            'form_params' => [
                'auth_token' => 'e17b9097e6ec4450ed488ee536924d2b41e4ec8a6ffdac7cff5e2aed0cf4a3c7',
                'from' => '31001',
                'to' => $user->mobile,
                'text' => $text_message,
            ]
        ]);
        }
        return redirect()->back()->with('message', 'Response send successfully');
    }

    public function getManageBlood(){
        $data =[
            'donner' => User::where('is_admin', '0')->get(),
            'requestednames' => Requestedblood::where('delivered', 'No')->get()
        ];
        return view('admin.manageblood', $data);
    }
    public function postAddDonorBlood(Request $request){
        $unit = $request->input('unit');
        for( $i = 0; $i<$unit; $i++ ) { 
            $add = New Donated;
            $add->user_id = $request->input('donnerid');
            $add->blood_group = $request->input('blood_group');
            $add->donate_date = $request->input('donate_date');
            $add->donate_at = $request->input('donate_location');
            $add->save();
        }
        return redirect()->back()->with('message', 'blood added successfully');
    }
    public function getIssueBlood($bloodgroup){
        $data =[
            'donner' => User::where('is_admin', '0')->get(),
            'requestednames' => Requestedblood::where('delivered', 'No')->get(),
            'bloods' => Donated::where('blood_group', $bloodgroup)->get(),
            'requested_bloodgroup' => $bloodgroup
        ];

        return view('admin.donatebloodlist', $data);
    }
    public function getbloodlist($type){
        $data =[
                'bloods' => Donated::where('blood_group', $type)->orderby('issue_status', 'asc')->get(),
                'type' => $type,
                'requestednames' => Requestedblood::where('delivered', 'No')->get(),
        ];

        return view('admin.issueblood', $data);
    }
    public function postIsssueBlood(Request $request){

        $donatedid = $request->input('donated_id');
        $issue_to = $request->input('issuer_name');
        $giveto = $request->input('giveto');

        if($donatedid){
             DB::table('Requestedbloods')
        ->where('id', $giveto)
        ->limit(1)
        ->update(array('delivered' => 'Yes'));
        }
       
            DB::table('donateds')
        ->where('id', $donatedid)
        ->limit(1)
        ->update(array('issue_status' => 'Y', 'issue_to' => $issue_to, 'requestedblood_id' => $giveto));
        
         

        
        $bloodinfo  = Donated::find($donatedid);

        $countblood = Donated::where('blood_group', $bloodinfo->blood_group)->where('issue_status', 'N')->count();
        
        if($countblood < 10){
           
            $bloodss = Blood::where('blood_group', $bloodinfo->blood_group)->get();

            $text_message = 'Dear Donor, Urgently required '.$bloodinfo->blood_group.' blood group , Please contact us if you want to donate blood. For support call 9806797796.
         Thank You ';
        
     foreach ($bloodss as $bloods){

            $checklatestdonatedate = Donated::where('user_id', $bloods->user_id)->limit(1)->first();
                if($checklatestdonatedate){
                    if($checklatestdonatedate->donate_date < date('Y-m-d', strtotime('-3 months')))
                    {

                        $user  = User::find($bloods->user_id);
                        
                        $client = new Client();
                        $res = $client->request('POST', 'https://sms.aakashsms.com/sms/v3/send',
                        [
                                'form_params' =>
                            [
                                'auth_token' => 'e17b9097e6ec4450ed488ee536924d2b41e4ec8a6ffdac7cff5e2aed0cf4a3c7',
                                'from' => '31001',
                                'to' => $user->mobile,
                                'text' => $text_message,
                            ]
                        ]);
                    }
                }
                else{
                     $user  = User::find($bloods->user_id);
                        $client = new Client();
                        $res = $client->request('POST', 'https://sms.aakashsms.com/sms/v3/send',
                        [
                                'form_params' =>
                            [
                                'auth_token' => 'e17b9097e6ec4450ed488ee536924d2b41e4ec8a6ffdac7cff5e2aed0cf4a3c7',
                                'from' => '31001',
                                'to' => $user->mobile,
                                'text' => $text_message,
                            ]
                        ]);
                }
        

     }
      return redirect()->route('admin.getManageBlood')->with('message', 'Blood Issue Successfully. Blood stock less then 10 unit. system automatic send sms to the donners.');

        }
 
         return redirect()->route('admin.getManageBlood')->with('message', 'Blood Issue Successfully.');

       


    }
    public function getDonnerDelete(User $user){
       

        $checkblood = Blood::where('user_id', $user->id)->count();
        
        if($checkblood > 0){
           
            DB::table('bloods')->where('user_id', $user->id)->delete();
        } 

        $chekdonate = Donated::where('user_id', $user->id)->count();
        if($checkblood > 0){
             Donated::where('user_id', $user->id)->delete();
        }

        $checkonlinerequest = Requestedblood::where('user_id', $user->id)->count();
        if($checkonlinerequest > 0){
            Requestedblood::where('user_id', $user->id)->delete();
        }


       $user->delete();
      

       


        return redirect()->back()->with('message', 'donor Delete Sucess');
    }
    public function getManageAdminUser(){
        $data =[
            'users' => User::where('is_admin', '1')->get()
        ];
        return view('admin.manageuser', $data);
    }
   
    public function postAddAdminUser(Request $request){
        $fname = $request->input('name');
        $lname = $request->input('lname');
        $gender = $request->input('gender');
        $province = $request->input('province');
        $district = $request->input('district');
        $minicipality = $request->input('minicipality');
        $word_no = $request->input('word_no');
        $tole = $request->input('tole');
        $city = $request->input('city');
        $email = $request->input('email');
        $bloodgroup = $request->input('bloodgroup');
        $dob = $request->input('dob');
        $makeaccount = $request->input('makeaccount');
        // check donnor double entry
         $check = User::where('mobile', $email)->count();
         if($check == 0){
           
            $user = New User;
            $user->name = $fname;
            $user->lname = $lname;
            $user->is_admin ='1';
            $user->mobile = $email;
            $user->gender = $gender;
            $user->province = $province;
            $user->district = $district;
            $user->minicipality = $minicipality;
            $user->city = $city;
            $user->tole = $tole;
            $user->word_no = $word_no;
            $user->password = Hash::make($request->input('password'));
            $user->save();

          return redirect()->back()->with('message', 'Admin Added Successfully');

          
        }
        else{
            return redirect()->back()->with('message', 'Unable to add, due to mobile number doublicate entry');
        }

    }

public function getAdminUserDelete(User $user){
    $user->delete();
    return redirect()->back()->with('message', 'Admin User Deleted Successfully');
}
public function  getListfofDonnorToRequest($type){
 
     $data =[
                'bloods' => Blood::where('blood_group', $type)->get(),
                'type' => $type,
                
        ];
        return view('admin.requestbloodtodonner', $data);

}
public function postListfofDonnorToRequest(Request $request, $type){
   
    $text_message = 'Dear Donor, Urgently required '.$type.' blood group , Please contact us if you want to donate blood. For support call 9806797796.
         Thank You ';
   
     foreach ($request->checked as $key => $val){
        if (in_array($val, $request->checked)){
            $client = new Client();
         $res = $client->request('POST', 'https://sms.aakashsms.com/sms/v3/send', [
            'form_params' => [
                'auth_token' => 'e17b9097e6ec4450ed488ee536924d2b41e4ec8a6ffdac7cff5e2aed0cf4a3c7',
                'from' => '31001',
                'to' => $val,
                'text' => $text_message,
            ]
        ]);
        }

     }
     return redirect()->back()->with('message', 'Request has been send to donor via sms');      
    
}
    

}
   

 

