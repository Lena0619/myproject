<?php
namespace App\Controllers;

use App\Models\OrgsModel;
use App\Models\UsersModel;
use App\Models\ApplyfileModel;
use CodeIgniter\Controller;

class RegisterController extends Controller {

    protected $session;

    public function __construct() {
        // 啟用 Session 功能
        $this->session = \Config\Services::session();
    }

    public function index() {
        $orgsModel = new OrgsModel();
        $allorgs = $orgsModel->findAll();

        return view('register', ['orgs' => $allorgs]);
    }

    public function process() {
        if ($this->request->getMethod() === 'post' && $_FILES['csvfile']['size']) {
            $usersModel = new UsersModel();
            $allusers = $usersModel->findAll();

            $data = [
                'org_id' => $this->request->getPost('org_id'),
                'name' => $this->request->getPost('name'),
                'account' => $this->request->getPost('account'),
                'password' => $this->request->getPost('password'),
                'birthday' => $this->request->getPost('birthday'),
                'email' => $this->request->getPost('email'),
                'status' => (int)0,
                'created_at' => date('Y-m-d H:i:s')
            ];

            if (!empty($allusers)) {
                foreach($allusers as $user) {
                    if($data['account'] === $user['account'] && (int)$user['status'] === 1) {
                        $message = '帳號重複,請重新設定';
                        $this->session->setFlashdata('msg', $message);
                        return $this->index();
                    } else if ($data['account'] === $user['account'] && (int)$user['status'] === 0) {
                        $message = '此帳號待審核開通';
                        $this->session->setFlashdata('msg', $message);
                        return $this->index();
                    }
                }
            }
            $usersModel->insert($data);



            $file_data = $_FILES['csvfile'];
            $a = explode(".",$file_data['name']);
            if($a[1] != 'csv'){
                    echo "<script language='javascript'>\n";
                    echo "alert('上傳檔案必須為CSV!');\n";
                    echo "window.close();";
                    echo "</script>\n";
                    exit; 		
            }else {
                $filepath = "/var/www/html/myproject/public/uploadfile/";
                $filepath .= date('YmdHis').rand(0,100). '_' .$_FILES['csvfile']['name'];

                $uploadresult = move_uploaded_file($_FILES['csvfile']['tmp_name'], $filepath);
            }

            if (!$uploadresult) {
                $message = '檔案上傳不成功';
                $this->session->setFlashdata('msg', $message);
                return $this->index();
            } else {
                $userid = $usersModel->select('id')->where('account', $data['account'])->get()->getRow();

                $filedata = [
                    'user_id' => (int)$userid->id, 
                    'file_path' => $filepath, 
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $applyfileModel = new ApplyfileModel();
                $applyfileModel->insert($filedata);

                $message = '帳號及檔案儲存成功';
                $this->session->setFlashdata('msg', $message);
                return $this->index();
            }
        }
        
    }

    public function add_new_org() {
        $new_org = $this->request->getPost('new_org');
        if ($new_org === "") {
            $message = '沒有輸入單位名稱,新增失敗';
            $this->session->setFlashdata('msg', $message);
            return $this->index();
        } else {

            $orgsModel = new OrgsModel();
            $allorgs = $orgsModel->findAll();
            $org_no_arr = [];
            foreach($allorgs as $org) {
                array_push($org_no_arr, $org['org_no']);
                if ($new_org === $org['title']) {
                    $message = '系統已有資料：'.$new_org.', 新增失敗';
                    $this->session->setFlashdata('msg', $message);
                    return $this->index();
                }
            }

            
            $orgdata = [
                'title' => $new_org, 
                'org_no' => max($org_no_arr)+1,
                'created_at' => date('Y-m-d H:i:s')
            ];
            $orgsModel->insert($orgdata);
            $message = '單位儲存成功';
            $this->session->setFlashdata('msg', $message);
            return $this->index();
        }
    }

}

?>