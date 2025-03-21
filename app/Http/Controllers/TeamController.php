<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TeamsModel;

class TeamController extends Controller
{
    public function Get_All_Teams()
    {
        try {
            $team_data = TeamsModel::select([
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
                ->get();

            return response($team_data, 200);
        } catch (\Throwable $e) {
            \Log::alert($e->getMessage());
        }
    }

    public function Get_Team_Past_Events($team_id)
    {
        try {
            $ret_data = new \StdClass();

            $json = file_get_contents("https://www.thesportsdb.com/api/v1/json/3/eventslast.php?id=139821");
            $teams = json_decode($json);
            // \Log::alert(json_encode($teams));

            return response()->json($teams);
        } catch (\Throwable $e) {
            \Log::alert($e->getMessage());
        }
    }

    public function Get_Team_Next_Events($team_id)
    {
        try {
            $ret_data = new \StdClass();

            $api_url = config('kbo.DATA_API_URL');

            $json = file_get_contents("$api_url/eventsnext.php?id=$team_id");
            $teams = json_decode($json);
            // \Log::alert(json_encode($teams));

            return response()->json($teams);
        } catch (\Throwable $e) {
            \Log::alert($e->getMessage());
        }
    }
}
