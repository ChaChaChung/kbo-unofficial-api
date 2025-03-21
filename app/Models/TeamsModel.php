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

    public static function Get_Single_Teams($team_id)
    {
        try {
            $team_data = TeamsModel::where('SID', $team_id)
                ->select([
                    'SID as team_id',
                    'team_name',
                    'team_name_en',
                    'team_name_kr',
                    'team_logo',
                    'team_stadium',
                    'team_location',
                    'team_established',
                    'team_site',
                    'team_site',
                ])
                ->first();

            return $team_data;
        } catch (\Throwable $e) {
            \Log::alert($e->getMessage());
        }
    }
}
