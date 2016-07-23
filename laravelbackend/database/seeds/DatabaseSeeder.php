<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Http\Models\AdminAccount;
use App\Http\Models\AdminLevel;
use App\Http\Models\AdminInfo;
use App\Http\Models\AdminAuthorization;
use App\Http\Models\LevelAuthorization;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);
        if(AdminAccount::all()->count() == 0)
        {
            $superLevel = new AdminLevel();
            $superLevel->level_value = 255;
            $superLevel->level_name = '超级管理员';
            $superLevel->save();
            $superAdmin = new AdminAccount();
            $superAdmin->account = 'admin';
            $superAdmin->password = Hash::make('admin');
            $superAdmin->level_id = $superLevel->id;
            $superAdmin->save();
            $superAdminInfo = new AdminInfo();
            $superAdminInfo->admin_id = $superAdmin->id;
            $superAdminInfo->admin_name = '超级管理员';
            $superAdminInfo->city = '珠海';
            $superAdminInfo->save();
            $adminAuthorization = new AdminAuthorization();
            $adminAuthorization->authorization_name = '管理员管理';
            $adminAuthorization->save();
            $userAuthorization = new AdminAuthorization();
            $userAuthorization->authorization_name = '用户管理';
            $userAuthorization->save();
            $schoolAuthorization = new AdminAuthorization();
            $schoolAuthorization->authorization_name = '学校管理';
            $globalAdvAuthorization = new AdminAuthorization();
            $globalAdvAuthorization->authorization_name = '全局广告';
            $homeConfigAuthorization = new AdminAuthorization();
            $homeConfigAuthorization->authorization_name = '首页配置';
            $homeConfigAuthorization->save();
            $schoolAdvAuthorization = new AdminAuthorization();
            $schoolAdvAuthorization->authorization_id = $schoolAuthorization->id;
            $schoolAdvAuthorization->authorization_name = '广告';
            $superLevel_AdminAuth = new LevelAuthorization();
            $superLevel_AdminAuth->level_id = $superLevel->id;
            $superLevel_AdminAuth->authorization_id = $adminAuthorization->id;
            $superLevel_AdminAuth->save();
            $superLevel_userAuth = new LevelAuthorization();
            $superLevel_userAuth->level_id = $superLevel->id;
            $superLevel_userAuth->authorization_id = $userAuthorization->id;
            $superLevel_userAuth->save();
            $superLevel_schoolAuth = new LevelAuthorization();
            $superLevel_schoolAuth->level_id = $superLevel->id;
            $superLevel_schoolAuth->authorization_id = $schoolAuthorization->id;
            $superLevel_schoolAuth->save();
            $superLevel_globalAdvAuth = new LevelAuthorization();
            $superLevel_globalAdvAuth->level_id = $superLevel->id;
            $superLevel_globalAdvAuth->authorization_id = $globalAdvAuthorization->id;
            $superLevel_globalAdvAuth->save();
            $superLevel_homeConfigAuth = new LevelAuthorization();
            $superLevel_homeConfigAuth->level_id = $superLevel->id;
            $superLevel_homeConfigAuth->authorization_id = $homeConfigAuthorization->id;
            $superLevel_homeConfigAuth->save();
            $superLevel_schoolAdvAuth = new LevelAuthorization();
            $superLevel_schoolAdvAuth->level_id = $superLevel->id;
            $superLevel_schoolAdvAuth->authorization_id = $schoolAdvAuthorization->id;
            $superLevel_schoolAdvAuth->save();

        }

        Model::reguard();
    }
}
