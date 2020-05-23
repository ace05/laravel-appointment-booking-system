<?php
namespace App\Http\Controllers\Backend;

use App\Models\User;
use App\Utils\UserTypes;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use App\Models\WithdrawalRequest;

class UserController extends AdminBaseController
{
	public function getAllProviders(Request $request, User $userModel){	

		$search = $request->get('search');
       	$serviceProviders = $userModel->where(
       								'user_type_id', '=', UserTypes::SERVICE_PROVIDER
       							);
       	if(empty($search) === false){
       		$serviceProviders = $serviceProviders->where(function($query) use ($search){
       			$query->where('email', '=', $search)
       					->orWhere('mobile', '=', $search);
       		});
       	}

       	$serviceProviders = $serviceProviders->orderBy('created_at', 'desc')
       							->paginate(20);
       
       return view('backend.users.providers', ['serviceProviders' => $serviceProviders]);
    }

    public function statusUpdate($id, $type, Request $request, User $userModel)
    {
    	$data = [];
        switch (strtolower($type)) {
            case 'block':
                $data = [
                    'is_blocked' => true
                ];
                break;
            case 'unblock':
                $data = [
                    'is_blocked' => false
                ];
                break;
            case 'email-verified':
                $data = [
                    'is_email_verified' => true
                ];
                break;
            case 'mobile-verified':
                $data = [
                    'is_mobile_verified' => true
                ];
                break;
            
            default:
                break;
        }

        $user = $userModel->where('id', '=', $id)->update($data);

        return redirect()->back()->with('success', __(
            'message_status_success'
        ));
    }

    public function getAllProfessinals(Request $request, User $userModel){	

		$search = $request->get('search');
       	$professionals = $userModel->where(
       								'user_type_id', '=', UserTypes::PROFESSIONAL
       							);
       	if(empty($search) === false){
       		$professionals = $professionals->where(function($query) use ($search){
       			$query->where('email', '=', $search)
       					->orWhere('mobile', '=', $search);
       		});
       	}

       	$professionals = $professionals->orderBy('created_at', 'desc')
       							->paginate(20);
       
       return view('backend.users.professionals', ['professionals' => $professionals]);
    }

    public function getAllUsers(Request $request, User $userModel){	

		$search = $request->get('search');
       	$users = $userModel->where(
   								'user_type_id', '=', UserTypes::USER
   							);
       	if(empty($search) === false){
       		$users = $users->where(function($query) use ($search){
       			$query->where('email', '=', $search)
       					->orWhere('mobile', '=', $search);
       		});
       	}

       	$users = $users->orderBy('created_at', 'desc')
       							->paginate(20);
       
       return view('backend.users.index', ['users' => $users]);
    }

    public function getUserLogins(Request $request, UserLogin $loginModel)
    {
        $logins = $loginModel->orderBy('created_at', 'desc')
                    ->paginate(20);

        return view('backend.users.logins', ['logins' => $logins]);
    }

    public function getWithdrawalRequests(
        Request $request, WithdrawalRequest $withdrawalModel
    ){
        $withdrawals = $withdrawalModel->orderBy('created_at', 'desc')
                                    ->paginate(20);

        return view('backend.users.withdrawal_requests', ['withdrawals' => $withdrawals]);
    }

    public function markProcessedWithdrawal($id, Request $request, WithdrawalRequest $withdrawalModel){
        $withdrawal = $withdrawalModel->findOrFail($id);
        $withdrawal->is_completed = true;
        if($withdrawal->save()){
            return redirect()->back()->with('success', __(
                'message_withdrawal_status_success'
            ));
        }

        return redirect()->back()->with('error', __(
            'message_withdrawal_status_failed'
        ));
    }
}