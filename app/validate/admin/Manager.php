<?php
declare (strict_types = 1);

namespace app\validate\admin;

use think\Validate;

class Manager extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'id|管理员id' => 'require|integer|>:0|isExist:Manager', // isExist是自定义规则
        'username'   => 'require|min:5|max:20',
        'password'   => 'require|min:5|max:20',
        'avatar'     => 'url',
        'role_id'    => 'require|integer|>:0',
        'status'     => 'require|integer|in:0,1'
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [];

    /**
     * 定义验证场景
     * 格式：'场景名'	=>	['需验证的字段']
     *
     * @var array
     */	
    protected $scene = [
        'save' => ['username', 'password', 'avatar', 'role_id', 'status'],
        'update' => ['id', 'username', 'password', 'avatar', 'role_id', 'status']
    ];

    /**
     * 自定义验证规则
     * @var array
     */	
    protected function isExist($value, $rule='', $data='', $field='', $title='记录'){
        if(!$value){ //
            return true;
        }
        $model = '\app\model\\'.$rule;
        
        // 找到要修改的记录集
        $m = $model::find($value);
        
        if(!$m){
            return '该'.$title.'不存在';
        }
        // 写入request 可以在控制器中$request->Model进行调用
        request()->Model = $m;

        return true;
    }
}
