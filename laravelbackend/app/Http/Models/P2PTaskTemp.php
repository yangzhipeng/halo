<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class P2PTaskTemp extends Model
{
    //
    protected $table = 'umi_p2p_job_temps';
    protected $primaryKey = 'category_id';


    public function getExpireAttribute($value)
    {
        return date('Y-m-d H:i', $value);
    }

    public function getImageUrlAttribute($value)
    {
        try {

            return explode(',', trim($value));

        }catch (\Exception $e)
        {
            return $value;
        }
    }
}
