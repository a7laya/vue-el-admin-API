<?php
declare (strict_types = 1);

namespace app\controller\admin;

use think\Request;
// 继承基础控制器
use app\BaseController;

class Manager extends BaseController
{   
    // 关闭自动实例化模型
    // protected $autoModel = false;

    // 重新定义模型路径
    // protected $modelPath = 'Manager';

    // 是否开启自动验证
    // protected $autoValidate = false;

    // 自定义验证场景 如果场景规则为'save1'
    // protected $autoValidateScenes = [
    //     'save' => 'save1'
    // ];

    
    // 需要自动验证的方法
    protected $excludeValidateCheck = ['save','update'];


    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        return showSuccess('index');
    }
    

    /**
     * 创建管理员
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        // halt($request)
        
        // $param = $request->param();
        // 过滤参数
        $param = $request->only(['username','password','avatar','role_id','status']);

        $res = $this->M->save($param);
        return showSuccess($res);
    }


    /**
     * 更新管理员
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        // 过滤参数
        $param = $request->only(['id','username','password','avatar','role_id','status']);
        // 找到要修改的记录集 写入验证规则了 直接$request->Model
        // $Model = $this->M->find($param['id']);
        
        // 进行修改
        $res = $request->Model->save($param);
        return showSuccess($res);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
