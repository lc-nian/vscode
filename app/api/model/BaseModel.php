<?php


namespace app\api\model;


use think\Exception;
use think\Model;

class BaseModel extends Model
{
    /**
     * 查询信息
     * @param $where            //查询条件
     * @return array
     */
    public function getInfo($where)
    {
        try{
            $res = $this->where($where)->find();
            if (false === $res) {
                return ['code' => 'fail','msg' => $this->getError()];
            } else {
                return ['code' => 'ok','data' => $res];
            }
        }catch (Exception $e){
            return ['code' => 'fail','msg' => $e->getMessage()];
        }
    }

    /**
     * 列表查询
     * @param $page             //页数
     * @param $limit            //数量
     * @param $where            //查询条件
     * @param string $field     //查询字段
     * @return array
     */
    public function getList($page,$limit,$where,$field='*')
    {
        try{
            $res = $this->where($where)->field($field)->limit($page,$limit)->select();
            if (false === $res) {
                return ['code' => 'fail','msg' => $this->getError()];
            } else {
                return ['code' => 'ok','fata' => $res];
            }
        }catch (Exception $e){
            return ['code' => 'fail','msg' => $e->getMessage()];
        }
    }

    /**
     * 添加数据
     * @param $data
     * @return array
     */
    public function save_data($data)
    {
        try{
            $res = $this->allowField(true)->save($data);
            if (false === $res) {
                return ['code' => 'fail','msg' => $this->getError()];
            } else {
                return ['code' => 'ok'];
            }
        }catch (Exception $e){
            return ['code' => 'fail','msg' => $e->getMessage()];
        }
    }

    /**
     * 更新数据
     * @param $data
     * @return array
     */
    public function update_data($data)
    {
        try{
            $res = $this->allowField(true)->isUpdate(true)->save($data);
            if (false === $res) {
                return ['code' => 'fail','msg' => $this->getError()];
            } else {
                return ['code' => 'ok'];
            }
        }catch (Exception $e){
            return ['code' => 'fail','msg' => $e->getMessage()];
        }
    }

    /**
     * 删除数据
     * @param $ids
     * @return array
     */
    public function del_data($ids)
    {
        try{
            $res = $this->where(['id' => ['in' ,$ids]])->delete();
            if (false === $res) {
                return ['code' => 'fail','msg' => $this->getError()];
            } else {
                return ['code' => 'ok'];
            }
        }catch (Exception $e){
            return ['code' => 'fail','msg' => $e->getMessage()];
        }
    }
}