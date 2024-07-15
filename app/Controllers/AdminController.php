<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Administrators;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{

    public function newManager()
    {

        $admin = new Administrators();
        $data = $this->request->getPost();
        $data['id'] = $this->newId();
        $data['level'] = 1;

        $inserted = $admin->insert($data);

        if (!$inserted) {

            var_dump($admin->errors());
        }

        return redirect()->to(base_url('/'));
    }

    public function deleteManager()
    {
    }

    public function login()
    {

        $admin = new Administrators();
        $data = $this->request->getPost();

        $query = $admin->where('email', $data['email'])
            ->where('password', $data['password'])
            ->findAll();

        if ($query) {

            session_start();
            $_SESSION['user'] = $query[0]['id'];
            // Aprimorar o session

            return redirect()->to(base_url('/pages/dashboard'));
        } else {

            return redirect()->to(base_url('/'));
        }
    }

    public function logout()
    {
    }

    public function newId()
    {

        $admin = new Administrators();

        if ($admin) {

            $exist = false;

            while ($exist != true) {

                $new_id = random_int(1000000000, 9999999999);

                if ($admin->find($new_id) == false) {

                    $exist = true;
                }
            }

            return $new_id;
        }
    }
}
