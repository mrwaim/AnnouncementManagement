<?php

namespace Klsandbox\AnnouncementManagement\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Log;

/**
 * Klsandbox\AnnouncementManagement\Models\Announcement
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property integer $user_id
 * @property string $description
 * @property string $delivery_mode
 * @property integer $role_id
 * @property integer $site_id
 * @property-read \App\Models\User $user
 * @property-read \Klsandbox\RoleModel\Role $role
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\AnnouncementManagement\Models\Announcement whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\AnnouncementManagement\Models\Announcement whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\AnnouncementManagement\Models\Announcement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\AnnouncementManagement\Models\Announcement whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\AnnouncementManagement\Models\Announcement whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\AnnouncementManagement\Models\Announcement whereDeliveryMode($value)
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\AnnouncementManagement\Models\Announcement whereRoleId($value)
 * @method static \Illuminate\Database\Query\Builder|\Klsandbox\AnnouncementManagement\Models\Announcement whereSiteId($value)
 */
class Announcement extends Model
{

    use \Klsandbox\SiteModel\SiteExtensions;

    protected $table = 'announcements';
    public $timestamps = true;
    protected $fillable = ['user_id', 'description', 'delivery_mode', 'role_id', 'created_at', 'updated_at'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($item) {
            $item->user_id = Auth::user()->id;

            return true;
        });

        Announcement::created(function ($announcement) {
            Log::info("created\t#announcement:$announcement->id");

            $userClass = config('auth.model');
            $userClass::createEveryoneEvent(['created_at' => $announcement->created_at, 'controller' => 'timeline', 'route' => '/new-announcement', 'target_id' => $announcement->id]);
        });
    }

    public function user()
    {
        return $this->belongsTo(config('auth.model'));
    }

    public function role()
    {
        return $this->belongsTo('Klsandbox\RoleModel\Role');
    }

}
