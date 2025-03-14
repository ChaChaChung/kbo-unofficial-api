<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamsModel extends Model
{
    use HasFactory;

    protected $table = 'teams_data';

    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
}
