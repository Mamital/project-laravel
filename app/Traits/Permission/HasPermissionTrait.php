<?php

namespace App\Traits\Permission;

trait HasPermissionTrait 
{
    public function hasRole(...$roles)
    {
        foreach($roles as $role)
        {
            if($this->roles->contains('name', $role))
            {
                return true;
            }else{
                return false;
            }
        }
    }

    public function hasPermission($permission)
    {
        return (bool)$this->permissions->where('name', $permission->name)->count();
    }

    public function hasPermissionThroughRole($permission)
    {
        foreach ($permission->roles as $role) {
            if ($this->roles->contains($role)) {
                return true;
            } 
        }
        return false;
    }
    
    public function hasPermissionTo($permission)
    {
        return $this->hasPermission($permission) || $this->hasPermissionThroughRole($permission);
    }
    
}