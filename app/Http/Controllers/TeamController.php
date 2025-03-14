<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TeamsModel;

class TeamController extends Controller
{
    public function Get_All_Teams()
    {
        $team_data = TeamsModel::select([
                'SID',
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
            ->get();

        // foreach ($team_data as $data) {
        //     $data->team_logo = "/img/kbo_logos/$data->team_logo";
        // }
        \Log::alert(json_encode($team_data));
        return response($team_data, 200);
    }
}
