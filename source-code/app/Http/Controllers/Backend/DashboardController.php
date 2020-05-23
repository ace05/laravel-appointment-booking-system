<?php
namespace App\Http\Controllers\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\ServicePackage;

class DashboardController extends AdminBaseController
{
	public function getDashboard(
		Request $request, User $userModel, ServicePackage $packageModel,
		Order $orderModel
	)
	{
		$usersCount = $userModel->where('is_active', '=', true)
							->where('is_email_verified', '=', true)
							->where('is_mobile_verified', '=', true)
							->where('is_blocked', '=', false)
							->count();

		$packagesCount = $packageModel->where('is_active', '=', true)
								->where('is_approved', '=', true)
								->count();

		$ordersCount = $orderModel->where('is_paid', '=', true)->count();
		$earnings = $orderModel->where('is_paid', '=', true)
							->where('is_cancelled', '=', false)
							->sum(\DB::raw('price - discount'));

		$startDate = Carbon::now()->subMonths(6)->format('Y-m-d');
		$endDate = Carbon::now()->format('Y-m-d');

		$earningMetrics = $orderModel->select(\DB::raw(
								'year(created_at) as year, monthname(created_at) as month, sum(price-discount) as total, count(*) as orders'
							))
							->where('is_paid', '=', true)
							->where('is_cancelled', '=', false)
							->whereBetween('created_at', [$startDate." 00:00:00", $endDate." 23:59:59"])
							->groupBy(\DB::raw('year, month'))
							->get()
							->toArray();
		$months = $this->getMonths($startDate, $endDate);
		$revenueTrends = [];
		$orderTrends = [];
		$monthsArray = [];
		foreach ($months as $mkey => $mvalue) {
			$monthKey = $mvalue['month'].'-'.$mvalue['year'];
			$monthsArray[$monthKey] = 0;
			if(empty($earningMetrics) === false){
				foreach ($earningMetrics as $key => $value) {
					$akey = $value['month'].'-'.$value['year'];
					if($monthKey == $akey){
						$revenueTrends[$akey] = $value['total'];
						$orderTrends[$akey] = $value['orders'];
					}
				}
			}
		}

		$revenueTrends = array_merge($monthsArray, $revenueTrends);
		$orderTrends = array_merge($monthsArray, $orderTrends);
		return view('backend.dashboard.index', [
			'usersCount' => $usersCount,
			'packagesCount' => $packagesCount,
			'ordersCount' => $ordersCount,
			'earnings' => $earnings,
			'revenueTrends' => $revenueTrends,
			'orderTrends' => $orderTrends
		]);
	}

	public function getMonths($date1, $date2) {
		//convert dates to UNIX timestamp
		$time1  = strtotime($date1);
		$time2  = strtotime($date2);
		$tmp     = date('mY', $time2);

		$months[] = array("month"    => date('F', $time1), "year"    => date('Y', $time1));

		while($time1 < $time2) {
		  $time1 = strtotime(date('Y-m-d', $time1).' +1 month');
		  if(date('mY', $time1) != $tmp && ($time1 < $time2)) {
		     $months[] = array("month"    => date('F', $time1), "year"    => date('Y', $time1));
		  }
		}
		$months[] = array("month"    => date('F', $time2), "year"    => date('Y', $time2));
		return $months; //returns array of month names with year
	}
}