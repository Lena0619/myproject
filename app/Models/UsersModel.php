<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model {
    protected $table = 'users'; // 資料表名稱

    protected $primaryKey = 'id'; // 主鍵名稱

    protected $allowedFields = ['org_id', 'name', 'birthday', 'email', 'account', 'password', 'status', 'created_at', 'updated_at']; // 允許寫入的欄位
}