<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'uuid',
        'package_id',
        'template_id',
        'status',
        'result_image_path',
        'gif_path'
    ];

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function photos()
    {
        return $this->hasMany(TransactionPhoto::class);
    }
}
