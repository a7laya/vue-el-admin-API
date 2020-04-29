<?php
declare (strict_types = 1);

namespace app\model;

use think\Model;

/**
 * @mixin think\Model
 */
class Role extends Model{
    
    // 角色-管理员 一对多关系
    public function managers(){
        return $this->hasMany('Manager');
    }
}
