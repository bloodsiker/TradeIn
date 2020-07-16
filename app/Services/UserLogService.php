<?php
namespace App\Services;

use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserLogService
 */
class UserLogService
{

    /**
     * @param $action
     */
    public function log($action)
    {
        UserLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'ip_address' => $this->userIpAddress(),
            'user_agent' => $this->userAgent(),
        ]);
    }


    /**
     * @return mixed
     */
    public function userIpAddress()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * @return mixed
     */
    public function userAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }
}
