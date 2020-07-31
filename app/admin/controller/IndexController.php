<?php
namespace app\admin\controller;

use app\BaseController;
use think\exception\ValidateException;
use think\facade\Session;
use think\facade\View;

class IndexController extends BaseController
{

    protected $userModel;
    /**
     * 依赖注入
     * @param UserModel $userModel
     */
    public function __construct(UserModel $userModel)
    {
        parent::_initialize();
        parent::__construct();
        $this->userModel = $userModel;
    }

    /**
     * 登录
     * @return mixed
     */
    public function login()
    {
        if ($this->request->isPost()) {
            $validate = new LoginMastBeHavior();
            $param = $this->request->param();
            if (!$validate->scene('login')->check($param)) {
                $this->error_json($validate->getError());
            }
            $info = $this->userModel->getInfo(['username' => $param['username']]);
            if ($info['code'] != 'ok') {
                $this->error_json($info['msg']);
            }
            if ($info['data']['password'] != md5($param['password'])) {
                $this->error_json('密码错误');
            }
            Session::set('id',$info['data']['id']);
            $this->success_json('登录成功');
        }
        return View::fetch('index');
    }


}
