<?php
namespace App\Http\Controllers;


use Session;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class Helper extends Controller
{

    public static function app_name()
    {
        return $appname = 'UMSC';
    }


    public static function logged_username()
    {
        return $username = DB::table('users')->where('id', Session('LoggedAdmin'))->value('username');
    }

    public static function generateApplicationId()
    {
        $prefix = 'UMSC';
        $dateTime = now()->format('ymdH'); // YYMMDDHH
        $random = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);

        return $prefix . $dateTime . $random;
    }

    public static function getIconForRole($roleId)
    {
        switch ($roleId) {
            case 1:
                return 'bx-user-check'; // Imaam
            case 2:
                return 'bx-buildings'; // District Qadh
            case 3:
                return 'bx-crown'; // Directorate Sharia
            default:
                return 'bx-user'; // Default icon
        }
    }


    public static function getUserRole($roleId)
    {
        switch ($roleId) {
            case 1:
                return 'Imaam'; // Imaam
            case 2:
                return 'District Qadh'; // District Qadh
            case 3:
                return 'Directorate Sharia'; // Directorate Sharia
            default:
                return 'Un Known'; // Default icon
        }
    }

}
