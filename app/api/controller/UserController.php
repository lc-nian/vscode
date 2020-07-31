<?php


namespace app\api\controller;


use app\api\model\UserModel;
use think\exception\ValidateException;

class UserController extends PublicController
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
            //验证器验证参数 详情见文档
            try {
                $this->validate( [
                    'name'  => 'thinkphp',
                    'email' => 'thinkphp@qq.com',
                ],  'app\index\validate\User');
            } catch (ValidateException $e) {
                // 验证失败 输出错误信息
                dump($e->getError());
            }

            //逻辑操作
            $info = $this->userModel->getInfo(['username' => $this->request->param('username')]);
            if ($info['code'] != 'ok') {
                $this->error_json($info['msg']);
            }
            if ($info['data']['password'] != md5($this->request->param('password'))) {
                $this->error_json('密码错误');
            }

            //用户id加密返回
            $user_info['user_id'] = $this->jwt($info['id']);

            //接口返回
            $this->success_json('登录成功',$user_info);
        }
    }

}