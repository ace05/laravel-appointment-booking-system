<?php
namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\ServicePackage;

class ServiceController extends AdminBaseController
{
	public function getPackages(Request $request, ServicePackage $packageModel){	
       	$packages = $packageModel->orderBy('created_at', 'desc')
       							->paginate(20);
       
       return view('backend.packages.index', ['packages' => $packages]);
    }

    public function statusUpdate(
        $id, $type, Request $request, ServicePackage $packageModel
    )
    {
        $data = [];
        switch (strtolower($type)) {
            case 'approve':
                $data = [
                    'is_approved' => true
                ];
                break;
            case 'un-approve':
                $data = [
                    'is_approved' => false
                ];
                break;
            default:
                break;
        }

        $package = $packageModel->where('id', '=', $id)->update($data);

        return redirect()->back()->with('success', __(
            'message_status_success'
        ));
    }

    public function getOrders(Request $request, Order $orderModel)
    {
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $orders = $orderModel->where('is_paid', '=', true);
        if(empty($startDate) === false && empty($endDate) === false){
            $startDate = Carbon::parse($startDate.' 00:00:00')->format('Y-m-d H:i:s');
            $endDate = Carbon::parse($endDate.' 23:59:59')->format('Y-m-d H:i:s');
            $orders = $orders->where('created_at', '>=', $startDate)
                            ->where('created_at', '<=', $endDate);
        }
        $orders = $orders->orderBy('created_at', 'desc')
                            ->paginate(20);

        return view('backend.packages.orders', [
            'orders' => $orders, 
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date')
        ]);
    }
}