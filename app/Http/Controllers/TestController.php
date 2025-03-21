<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TeamsModel;

class TestController extends Controller
{
    public function index()
    {
        return response('test', 200);
    }

    public static function Migrate_All_Teams()
    {
        try {
            $json = file_get_contents("https://www.thesportsdb.com/api/v1/json/3/search_all_teams.php?l=Korean KBO League");
            $teams = json_decode($json);
            foreach ($teams->teams as $t) {
                $team_name_ary = explode(' ', $t->strTeam);
                $logo_src = $team_name_ary[0] . '_' . $team_name_ary[1] . '.png';
                $translated_team_name = self::Translate_Team_Name($t->strTeam);
                $stadium_cn_name = self::Translate_Stadium_Name($t->strStadium);
                $team_data = [
                    'SID'          => $t->idTeam,
                    'team_name'    => $translated_team_name->team_cn_name,  
                    'team_name_en' => $t->strTeam,
                    'team_name_kr' => $translated_team_name->team_kr_name,
                    'team_logo'    => $logo_src,
                    'team_stadium' => $stadium_cn_name,
                    'team_site'    => $t->strWebsite,
                ];
                \Log::alert(json_encode($team_data));
                TeamsModel::insert($team_data);
            }
            return response('test', 200);
        } catch (\Throwable $e) {
            \Log::alert($e->getMessage());
        }
    }

    public static function Translate_Team_Name($team_en_name)
    {
        try {
            $ret_data = new \StdClass();
            $team_cn_name = '';
            $team_kr_name = '';

            switch ($team_en_name) {
                case 'Doosan Bears':
                    $team_cn_name = '斗山熊';
                    $team_kr_name = '두산 베어스';
                    break;
                case 'Hanwha Eagles':
                    $team_cn_name = '韓華鷹';
                    $team_kr_name = '한화 이글스';
                    break;
                case 'Kia Tigers':
                    $team_cn_name = '起亞虎';
                    $team_kr_name = 'KIA 타이거즈';
                    break;
                case 'Kiwoom Heroes':
                    $team_cn_name = '培證英雄';
                    $team_kr_name = '키움 히어로즈';
                    break;
                case 'KT Wiz':
                    $team_cn_name = 'KT 巫師';
                    $team_kr_name = 'KT 위즈';
                    break;
                case 'LG Twins':
                    $team_cn_name = 'LG 雙子';
                    $team_kr_name = 'LG 트윈스';
                    break;
                case 'Lotte Giants':
                    $team_cn_name = '樂天巨人';
                    $team_kr_name = '롯데 자이언츠';
                    break;
                case 'NC Dinos':
                    $team_cn_name = 'NC 恐龍';
                    $team_kr_name = 'NC 다이노스';
                    break;
                case 'Samsung Lions':
                    $team_cn_name = '三星獅';
                    $team_kr_name = '삼성 라이온즈';
                    break;
                case 'SSG Landers':
                    $team_cn_name = 'SSG 登陸者';
                    $team_kr_name = 'SSG 랜더스';
                    break;
                default:
                    break;
            }

            $ret_data->team_cn_name = $team_cn_name;
            $ret_data->team_kr_name = $team_kr_name;
            
            return $ret_data;
        } catch (\Throwable $e) {
            \Log::alert($e->getMessage());
        }
    }

    public static function Translate_Stadium_Name($stadium_en_name)
    {
        try {
            $stadium_cn_name = '';

            switch ($stadium_en_name) {
                case 'Daejeon Hanbat Baseball Stadium':
                    $stadium_cn_name = '大田韓華生命球場';
                    break;
                case 'Gwangju-Kia Champions Field':
                    $stadium_cn_name = '光州起亞冠軍球場';
                    break;
                case 'Gocheok Sky Dome':
                    $stadium_cn_name = '高尺天空巨蛋';
                    break;
                case 'Suwon Baseball Stadium':
                    $stadium_cn_name = '水原KT巫師球場';
                    break;
                case 'Jamsil Baseball Stadium':
                    $stadium_cn_name = '蠶室棒球場';
                    break;
                case 'Busan Sajik Baseball Stadium':
                    $stadium_cn_name = '釜山社稷棒球場';
                    break;
                case 'Changwon NC Park':
                    $stadium_cn_name = '昌原NC球場';
                    break;
                case 'Daegu Samsung Lions Park':
                    $stadium_cn_name = '大邱三星獅棒球場';
                    break;
                case 'Incheon SSG Landers Field':
                    $stadium_cn_name = '仁川SSG登陸者球場';
                    break;
                default:
                    break;
            }
            
            return $stadium_cn_name;
        } catch (\Throwable $e) {
            \Log::alert($e->getMessage());
        }
    }
}
