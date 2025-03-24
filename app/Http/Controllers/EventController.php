<?php

namespace App\Http\Controllers;

use App\Http\Controllers\TestController;

use Illuminate\Http\Request;

use App\Models\TeamsModel;

class EventController extends Controller
{
    public function Get_League_Events($date)
    {
        try {
            // $ret_data = new \StdClass();
            $ret_data = array();

            $api_url = config('kbo.DATA_API_URL');

            $json = file_get_contents("$api_url/eventsnextleague.php?id=4830");
            $events = json_decode($json);

            $target_date = date("Y-m-d", strtotime($date));
            foreach ($events->events as $data) {
                $events_date = $data->dateEvent;
                if ($target_date === $events_date) {
                    $away_team = TeamsModel::Get_Single_Teams($data->idAwayTeam);
                    $data->awayTeamZh = $away_team->team_name;
                    $data->awayTeamKr = $away_team->team_name_kr;
                    $data->awayTeamLogo = $away_team->team_logo;

                    $home_team = TeamsModel::Get_Single_Teams($data->idHomeTeam);
                    $data->homeTeamZh = $home_team->team_name;
                    $data->homeTeamKr = $home_team->team_name_kr;
                    $data->homeTeamLogo = $home_team->team_logo;

                    $stadium_cn_name = TestController::Translate_Stadium_Name($data->strVenue);
                    $data->venueZh = $stadium_cn_name;

                    $ret_data[] = $data;
                }
            }
            // \Log::alert($target_date < $events_date);

            return response()->json($ret_data);
        } catch (\Throwable $e) {
            \Log::alert($e->getMessage());
        }
    }

    public function Get_League_Last_Events($date)
    {
        try {
            // $ret_data = new \StdClass();
            $ret_data = array();

            $api_url = config('kbo.DATA_API_URL');

            $json = file_get_contents("$api_url/eventspastleague.php?id=4830");
            $events = json_decode($json);

            $target_date = date("Y-m-d", strtotime($date));
            foreach ($events->events as $data) {
                $events_date = $data->dateEvent;
                if ($target_date === $events_date) {
                    $away_team = TeamsModel::Get_Single_Teams($data->idAwayTeam);
                    $data->awayTeamZh = $away_team->team_name;
                    $data->awayTeamKr = $away_team->team_name_kr;
                    $data->awayTeamLogo = $away_team->team_logo;

                    $home_team = TeamsModel::Get_Single_Teams($data->idHomeTeam);
                    $data->homeTeamZh = $home_team->team_name;
                    $data->homeTeamKr = $home_team->team_name_kr;
                    $data->homeTeamLogo = $home_team->team_logo;

                    $stadium_cn_name = TestController::Translate_Stadium_Name($data->strVenue);
                    $data->venueZh = $stadium_cn_name;

                    $ret_data[] = $data;
                }
            }
            // \Log::alert($target_date < $events_date);

            return response()->json($ret_data);
        } catch (\Throwable $e) {
            \Log::alert($e->getMessage());
        }
    }
}
