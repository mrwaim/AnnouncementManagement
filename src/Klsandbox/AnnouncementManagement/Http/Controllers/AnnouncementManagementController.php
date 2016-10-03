<?php

namespace Klsandbox\AnnouncementManagement\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Klsandbox\AnnouncementManagement\Models\Announcement;
use Klsandbox\RoleModel\Role;
use Input;
use Redirect;
use Klsandbox\NotificationService\Models\NotificationRequest;
use App;
use Session;
use Klsandbox\AnnouncementManagement\Http\Requests\AnnouncementPostRequest;
use Klsandbox\SmsManager\SmsBalance;
use Log;

class AnnouncementManagementController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Home Controller
      |--------------------------------------------------------------------------
      |
      | This controller renders your application's "dashboard" for users that
      | are authenticated. Of course, you are free to change or remove the
      | controller as you wish. It is just here to get your app started!
      |
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getList()
    {
        if (Auth::user()->role->name == 'admin') {
            $list = Announcement::orderBy('created_at', 'DESC')
                ->get();
        } else {
            $list = Announcement::where('role_id', '=', Auth::user()->role_id)
                ->orderBy('created_at', 'DESC')
                ->get();
        }

        return view('announcement-management::list-announcement')
            ->with('list', $list);
    }

    public function getCreate()
    {
        $roles = Role::where('name', '<>', 'admin')
            ->where('name', '<>', 'dropship')
            ->where('name', '<>', 'sales')
            ->where('name', '<>', 'deleted')
            ->where('name', '<>', 'staff')->get();

        $totalBalance = 'Not Applicable';

        $smsBalances = SmsBalance::all();
        if ($smsBalances->count() == 1) {
            $smsBalance = $smsBalances->first();
            $totalBalance = $smsBalance->balance;
        }

        return view('announcement-management::create-announcement')
            ->with('roles', $roles)
            ->with('sms_balance', $totalBalance);
    }

    public function postCreate(AnnouncementPostRequest $request)
    {
        $userClass = config('auth.model');

        $role = Role::find(Input::get('role_id'));

        if ($role->name == 'admin') {
            // Security check
            App::abort(403, 'Unauthorized');
        }

        $announcement = new Announcement();

        // TODO: Add name column
        $announcement->description = Input::get('description');
        $announcement->delivery_mode = Input::get('delivery_mode');
        $announcement->role_id = Input::get('role_id');

        $announcement->save();

        if ($announcement->id) {
            Log::info("delivering\t#announcement:$announcement->id via $announcement->delivery_mode");

            if ($announcement->delivery_mode == 'sms' || $announcement->delivery_mode == 'SMS') {
                $approved_users = $userClass::where('account_status', '=', 'Approved')
                    ->where('role_id', '=', Role::Stockist()->id)
                    ->get();

                Log::info('Delivering to ' . count($approved_users) . ' users');
                foreach ($approved_users as $user) {
                    if ($user->isBlocked()) {
                        continue;
                    }

                    $notification = new NotificationRequest();
                    $notification->from_user_id = $userClass::admin()->id;
                    $notification->route = '/new-announcement';
                    $notification->sent = false;
                    $notification->target_id = $announcement->id;
                    $notification->to_user_id = $user->id;
                    $notification->save();
                }
            }
        }

        Session::flash('success_message', 'Your announcement has been sent.');

        return Redirect::to('/announcement-management/list');
    }

    public function getView($id)
    {
        $item = Announcement::find($id);

        return view('announcement-management::view-announcement')
            ->with('item', $item);
    }
}
