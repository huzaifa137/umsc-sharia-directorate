<?php
namespace App\Http\Controllers;


use App\Models\SearchIndex;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Request;

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

    public static function fullname()
    {
        return DB::table('users')
            ->where('id', Session('LoggedAdmin'))
            ->value(DB::raw("CONCAT(firstname, ' ', lastname) as fullname"));
    }


    public static function activerUSerRole()
    {
         $roleId = DB::table('users')->where('id', Session('LoggedAdmin'))->value('user_role');

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

    public static function auditTrail(
        string $action,
        string $targetType = null,
        int $targetId = null,
        string $status = 'success',
        array $oldValues = null,
        array $newValues = null,
        string $description = null
    ) {
        $adminId = Session::get('LoggedAdmin');

        $admin = $adminId
            ? DB::table('users')->where('id', $adminId)->first()
            : null;

        ActivityLog::create([
            'user_id' => $admin->id ?? null,
            'user_role' => $admin ? self::getUserRole($admin->user_role) : 'System',
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'status' => $status,
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'description' => $description,
        ]);
    }

    public static function syncSearchIndex(array $data)
    {
        SearchIndex::updateOrCreate(
            [
                'module' => $data['module'],
                'reference_id' => $data['reference_id'],
            ],
            [
                'application_id' => $data['application_id'],
                'title' => $data['title'],
                'keywords' => $data['keywords'],
                'status' => $data['status'],
                'application_date' => $data['application_date'],
                'required_role' => $data['required_role'] ?? null,
            ]
        );
    }

    public static function removeFromSearchIndex(string $module, int $referenceId)
    {
        SearchIndex::where('module', $module)
            ->where('reference_id', $referenceId)
            ->delete();
    }
}
