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
    protected $excludeValidateCheck = ['save','update','delete','index'];


    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {   
        // 获取参数  getValByKey公共方法写在common.php里面
        $param = $this->request->param();
        $page = $param['page']; // 当前页面
        $limit = getValByKey('limit', $param, 10); // 每页限制条数,默认10条
        $keyword = getValByKey('keyword', $param, ''); // 关键字, 默认为''

        // 组织查询条件
        $where = [
            ['username', 'like', '%'.$keyword.'%']
        ];

        // 计算总数,主要用于分页
        $totalCount = $this->M->where($where)->count();

        // 获取列表数据
        $list = $this->M->page($page, $limit)
                        ->where($where)
                        ->with('role') // 关联到Manager模型中的 public function role()
                        ->order('id', 'desc')
                        ->select()
                        ->hidden(['password']);

        return showSuccess([
            'list' => $list,
            'totalCount' => $totalCount,
        ]);

        // $param = request()->param();
        // $limit = intval(getValByKey('limit',$param,10));
        // $keyword = getValByKey('keyword',$param,'');
        // $where = [
        //     [ 'username','like','%'.$keyword.'%' ]
        // ];

        // $totalCount = $this->M->where($where)->count();
        // $list = $this->M->page($param['page'],$limit)
        //         ->where($where)
        //         ->with('role')
        //         ->order([ 'id'=>'desc' ])
        //         ->select()
        //         ->hidden(['password']);
        // $role = \app\model\Role::field(['id','name'])->select();
        // return showSuccess([
        //     'list'=>$list,
        //     'totalCount'=>$totalCount,
        //     'role'=>$role
        // ]);
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
        /**
         * Manager验证器里面设置了验证delete的传参id
         * 同时将该id所在的记录存入request->Model
         */ 
        $manager = $this->request->Model;

        /**
         * 不能删除自己
         * todo。。。
         */

        /**
         * 不能删除超级管理员
         */
        if($manager->super === 1){
            ApiException('不能删除超级管理员');
        }
        
        return showSuccess($manager->delete());
    }
}
