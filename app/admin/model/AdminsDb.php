<?php
namespace app\admin\model;


use think\Exception;

class AdminsDb extends BaseDb
{
    private static $table = "admins";
    private static $roleTable = "qinly_role";

    /**
     * 保存添加管理信息数据
     * @param $data 数据
     * @return bool 返回信息
     */
    public static function saveAdminsInfo($data) {
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $result = self::Db(self::$table)->insert([
            'admins_name'   =>  $data['admins_name'],
            'phone'         =>  $data['phone'],
            'email'         =>  $data['email'],
            'wx_number'     =>  $data['wx_number'],
            'qq_number'     =>  $data['qq_number'],
            'native_place'  =>  $data['native_place'],
            'birthday'      =>  $data['birthday'],
            'sex'           =>  $data['sex'],
            'password'      =>  $password,
            'role_id'       =>  $data['role'],
            'create_time'   =>  thisTime(),
            'update_time'   =>  thisTime()
        ]);
        return $result > 0;
    }

    /**
     * 获取管理员列表信息
     * @param int $page
     * @param int $limit
     * @param array $confition
     * @return false
     */
    public static function getAdminsList($page = 1, $limit = 10, $confition = []) {
        return self::Db(self::$table)->alias('a')
            ->join(self::$roleTable.' b', 'a.role_id = b.id')
            ->where($confition)
            ->field('a.admins_name, a.phone, a.email, a.wx_number, a.qq_number, a.native_place, a.birthday, a.sex, a.role_id, a.status, a.create_time, a.last_login_time, b.role_name')
            ->order('a.create_time', 'desc')
            ->paginate(['list_rows'=>$limit, 'page'=>$page])
            ->each(function($item, $key) {
                $item['sex'] = $item['sex'] == 1 ? "男" : "女";
                return $item;
            });
    }
}