<?php

namespace Klsandbox\AnnouncementManagement\Console\Commands;

use Illuminate\Console\Command;
use Klsandbox\NotificationService\Models\NotificationRequest;
use Klsandbox\AnnouncementManagement\Models\Announcement;
use Klsandbox\RoleModel\Role;
use Auth;
use Log;

class AdminSendAnnouncement extends Command
{
    protected $name = 'admin:sendannouncement';
    protected $description = 'Manually send an announcement via sms.';

    public function fire()
    {
        $userClass = config('auth.model');

        $this->comment('Sending announcement');

        Auth::setUser($userClass::admin());

        $announcement_id = 1;

        $announcement = Announcement::find($announcement_id);

        Log::info("delivering\t#announcement:$announcement->id via $announcement->delivery_mode");
        if ($announcement->delivery_mode == 'sms') {
            $approved_users = $userClass::forSite()
                ->where('account_status', '=', 'Approved')
                ->where('role_id', '=', Role::Stockist()->id)
                ->get();

            Log::info('Delivering to ' . count($approved_users) . ' users');
            foreach ($approved_users as $user) {
                $notification = new NotificationRequest();
                $notification->route = '/new-announcement';
                $notification->sent = false;
                $notification->target_id = $announcement->id;
                $notification->to_user_id = $user->id;
                $notification->save();
            }
        }
    }
}
