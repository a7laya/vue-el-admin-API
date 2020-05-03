<?php
declare (strict_types = 1);

namespace app\controller\admin;

use think\Request;
// 继承基础控制器
use app\BaseController;
class Role extends Basecontroller
{

    // 当前方法对应的模型 $this->M,在BaseController中挂载 

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
    protected $excludeValidateCheck = ['index', 'save','update', 'updateStatus', 'delete'];

    /**
     * 显示资源列表
     *
     * @return \think\Response
     * @desc 1.定义路由 2.定义validate(在controller配置$excludeValidateCheck) 
     */
    public function index()
    {
        $param = request()->param();
        $limit = intval(getValByKey('limit',$param,10));
        $page = intval(getValByKey('page',$param,1));
        $totalCount = $this->M->count();
        $list = $this->M->page($page,$limit)
                        // 通过role_rule获取role_id对应的rule_id,->with('rules') 
                        // 注意两个表关联时会有两个id字段,所以要给其中一个表取别名alias('X')
                        ->with(['rules'=>function($t){
                            $t->alias('a')->field('a.id');
                        }])
                        ->order(['id'=>'desc'])
                        // ->order('id','desc')
                        ->select();
        return showSuccess([
            'list' => $list,
            'totalCount' => $totalCount
        ]);
    }


    /**
     * 创建角色
     * @param  \think\Request  $request
     * @return \think\Response
     * @desc 1.定义路由 2.定义validate(在controller配置$excludeValidateCheck) 3.$this->M->save()
     */
    public function save(Request $request)
    {
        
        // 过滤参数 name-名称  status-状态  desc-描述
        // $param = $request->only(['name','status','desc']);
        // 也可以全部接受
        $param = $request->param();
        
        $res = $this->M->save($param);
        return showSuccess($res);
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 更新角色
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     * @desc 1.定义路由 2.定义validate(在controller配置$excludeValidateCheck) 3.$this->M->save($param)
     * 
     */
    public function update(Request $request, $id)
    {
        // 过滤参数
        $param = $request->only(['id', 'name', 'status', 'desc']);
        // 找到要修改的记录集 在validate的验证$id的时候 通过BaseValidate中的isExist方法挂载在request()->Model
        $res = $request->Model->save($param);
        return showSuccess($res);
    }

    /**
     * 修改角色状态(启用|禁用)
     */
    public function updateStatus() {  
        // 找到要修改的记录集 在validate的验证$id的时候 挂载在request()->Model
        $role = $this->request->Model;
        $role->status = $this->request->param('status');
        return showSuccess($role->save());
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        /**
         * 验证器里面设置了该场景的id验证
         * 同时将该id所在的记录存入request->Model
         */ 
        $role = $this->request->Model;
        $count = $role->managers->count();
        if($count > 0){
            ApiException('该角色已绑定管理员,请先修改对应管理员角色');
        }
        return showSuccess($role->delete());
    }
}
