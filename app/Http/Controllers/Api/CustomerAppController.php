<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\BaseController as BaseController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Customer;
class CustomerAppController extends BaseController
{
    //
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'number' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $otp = mt_rand(1000,9999);
        $mobile_number = $request -> number;

        $customer = new Customer;

        $customer_exist = $customer->where('number', $mobile_number)->first();

        $otp_exist = $customer->where('otp', $otp)->first();

        if($otp_exist)
            $otp = mt_rand(1000,9999);

        if($customer_exist){
            Customer::where('number', $mobile_number)->update([
                'otp' => $otp,
                'fcm_token' => '',
            ]);
        }else{
            $customer -> number = $mobile_number;
            $customer -> otp = $otp; 
            $customer -> fcm_token = '';
            $customer -> group = 0;
            $customer -> status = 1;

            $customer -> save();
        }

        // send otp here...

        // end otp sms
            
        $success = [];

        return $this->sendResponse($success, 'Check for OTP');
    }


    public function authenticate_user(Request $request){

        $validator = Validator::make($request->all(), [
            'number' => 'required',
            'otp' => 'required',
            'fcm_token' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $mobile_number = $request -> number;
        $otp = $request -> otp;
        $fcm = $request -> fcm_token;
   
        $customer = new Customer;

        $customer_exist = $customer->where('number', $mobile_number)->where('otp' , $otp)->first();
        
        if($customer_exist){
            $customer_exist -> fcm_token = $fcm;
            $customer_exist -> otp = '';
            $customer_exist->save();

            $success = [];
            return $this->sendResponse($success, 'Login Successfully');
        }
        return $this->sendError('Failed Login', []);       
    }




    public function offer_glance(Request $request){
        $validator = Validator::make($request->all(), [
            'number' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $mobile_number = $request -> number;

        $customer = new Customer;

        $customer_exist = $customer->where('number', $mobile_number)->first();
      
        if($customer_exist){
            $cust_group = $customer_exist -> groups;
            $temp= [];
            $offer = $cust_group -> map_offer ;

            foreach($offer as $row){
                if($row -> offer -> validity == 2){
                    $temp[] = array(
                        'name' => $row -> offer -> name,
                        'description' => $row -> offer -> description
                    );
                }
            }
            
            $success = $temp ;
            return $this->sendResponse($success, 'Offers Glance');

        }

        return $this->sendError('Invalid Customer', []);       
    }
}
