<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopicEdit extends Model
{

    protected $fillable = ['reason', 'body'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // 每一份编辑存档，对应一个话题（梗）
    public function topic()
    {
    	return $this->belongsTo(Topic::class);
    }

    // 获取状态
    public function getStextAttribute($value) 
    {
        $value = $this->status;
        switch($value) {
            case -1 :
            return '已拒绝';
            break;
            case 0 :
            return '待审核';
            break;
            case 1 :
            return '已通过';
            break;
            default:
            return '未知';
        }
    }
}
