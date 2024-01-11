<?php

namespace App\Models;

use CodeIgniter\Model;

class ApplyfileModel extends Model {
    protected $table = 'apply_file'; // 資料表名稱

    protected $primaryKey = 'id'; // 主鍵名稱

    protected $allowedFields = ['user_id', 'file_path', 'created_at', 'updated_at']; // 允許寫入的欄位
}