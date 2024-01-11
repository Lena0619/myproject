<?php
namespace App\Controllers;

use App\Models\UsersModel;
use CodeIgniter\Controller;

class LoginController extends Controller {

    protected $session;

    public function __construct() {
        // 啟用 Session 功能
        $this->session = \Config\Services::session();
    }

    public function index() {
        return view('login');
    }

    public function login() {
        // 1. 處理提交的登入資料, 2.登入資料和使用者驗證

        $account = $this->request->getPost('account');
        $password = $this->request->getPost('password');

        $usersModel = new UsersModel();
        $loginuser = $usersModel->select('*')->where('account', $account)->where('password', $password)->get()->getRow();

        if ($loginuser) {
            if ($loginuser->status == 0) {
                $message = '此帳號待審核開通';
                $this->session->setFlashdata('msg', $message);
                return $this->index();
            }
            
            $user_data = array(
                'user_id' => $loginuser->id,
                'username' => $loginuser->name,
                'logged_in' => TRUE
            );

            $message = '登入成功';
            $this->session->setFlashdata('msg', $message);
            return $this->index();
        } else {
            $message = '無此帳號,請先註冊';
            $this->session->setFlashdata('msg', $message);
            return $this->index();
        } 
    }
}

?>