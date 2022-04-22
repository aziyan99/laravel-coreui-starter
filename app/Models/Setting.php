<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'web_name', 'logo'
    ];

    public function getLogoAttribute($value)
    {
        if ($value == null) {
            return 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name=' . $this->attributes['web_name'];
        } else {
            return $value;
        }
    }
}
