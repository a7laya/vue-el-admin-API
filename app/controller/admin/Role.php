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
    protected $excludeValidateCheck = ['index'];

    /**
     * 显示资源列表
     *
     * @return \think\Response
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
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
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
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
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