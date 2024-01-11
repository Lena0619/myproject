<?php

namespace App\Models;

use CodeIgniter\Model;

class OrgsModel extends Model {
    protected $table = 'orgs'; // 資料表名稱

    protected $primaryKey = 'id'; // 主鍵名稱

    protected $allowedFields = ['title', 'org_no', 'created_at', 'updated_at']; // 允許寫入的欄位
}