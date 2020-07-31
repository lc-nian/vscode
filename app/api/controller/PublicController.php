<?php


namespace app\api\controller;

use app\BaseController;
use Firebase\JWT\JWT;
use think\facade\Env;
class PublicController extends BaseController
{
    public $param = [];
    public $model = null;
    public $controller = null;
    public $action = null;
    public $mvc = null;
    public $user_id = null;
    public $m = null;

    /**
     * token验证
     */
    protected function _initialize()
    {
        //保存参数
        $this->setAction();
        //不需要 Token 验证的方法
        $ext = [
            'index/Index/index', //示例方法
        ];

        if (!in_array($this->mvc, $ext)) {
            //token验证
            $check = $this->checkToken();

            if ($check === false) {
                $this->error_json( "您还没有登陆！");
            }
        }

    }

    /**
     * Token 校验
     * @return bool
     */
    private function checkToken()
    {
        //获取 JWT 密钥
        $key = Env::get('jwt.key');
        //判断 Token 是否存在
        if (!isset($this->param['token']) || $this->param['token'] == null) {
            return false;
        }
        //解密 JWT 字符串
        $param_decode = JWT::decode($this->param['token'], $key, array('HS256'));
        $param_decode = (array)$param_decode;

        //判断 user_id 是否存在
        if (!isset($param_decode['user_id']) || $param_decode['user_id'] == null) {
            return false;
        }
        //给 user_id 赋值
        $this->user_id = $param_decode['user_id'];
        return true;
    }


    /**
     * 接收数据
     */
    private function setAction()
    {
        $this->model = request()->module();
        $this->controller = request()->controller();
        $this->action = request()->action();
        $this->mvc = $this->model . "/" . $this->controller . "/" . $this->action;
        $this->param = request()->isPost() ? input('post.') : input('get.');
    }

    /**
     * @param $user_id
     * @return string
     */
    public function jwt($user_id)
    {
        $key = config('key');
        $data = [
            "iss" => "kangye",
            "aud" => "anping",
            'user_id' => $user_id,
        ];
        return JWT::encode($data, $key);
    }
}