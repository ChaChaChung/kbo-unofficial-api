<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;

class ScheduleController extends Controller
{
    public function Get_Schedule()
    {
        try {
            $channelSecret = '2007198714';
            $channelAccessToken = '1b7++AxESWhL695bQjw8SOeTb7y1HQ/YGewHu+GcJJ8LtuGZwC74PRvU2BaQqk4tOEF5/omuwehc2yjSwPhK4j2UV+uGlKPy8BCZ/qqqtH3iW9beMHY6ZEZrWL24dAKAnNarjuAYSsn82SK/c5HTLwdB04t89/1O/w1cDnyilFU=';

            $json = file_get_contents('http://localhost:8080/schedule');
            $events = json_decode($json);
            $text = "今天的賽程是:\n";
            foreach ($events as $index => $data) {
                $away_team = $data->away_team;
                $home_team = $data->home_team;
                $location = $data->location;
                $time = $data->time;
                $game_no = $data->game_no;
                $away_sp = $data->away_sp;
                $home_sp = $data->home_sp;

                $text .= "編號第 $game_no 場 $away_team  ($away_sp) vs $home_team ($home_sp) @$location";
                if ($index + 1 < count($events)) {
                    $text .= "\n";
                }

                $message = [
                    'type' => 'text',
                    'text' => $text
                ];
            }

            // 獲取請求內容
            $input = file_get_contents('php://input');
            $events = json_decode($input, true);

            if (!empty($events['events'])) {
                foreach ($events['events'] as $event) {
                    // 取得事件類型
                    $eventType = $event['type'];
            
                    if ($eventType == 'message' && $event['message']['text'] === '今日賽程') {
                        $replyToken = $event['replyToken'];
                        $message = [
                            'type' => 'text',
                            'text' => $text
                        ];
            
                        $postData = json_encode([
                            'replyToken' => $replyToken,
                            'messages' => [$message]
                        ]);
            
                        // 回覆訊息
                        $ch = curl_init('https://api.line.me/v2/bot/message/reply');
                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                            'Content-Type: application/json',
                            'Authorization: Bearer ' . $channelAccessToken
                        ]);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                        $response = curl_exec($ch);
                        if ($response === false) {
                            \Log::alert('Error in cURL request: ' . curl_error($ch));
                        } else {
                            \Log::alert('Response from LINE API: ' . $response);
                        }
                        curl_close($ch);
                    }
                }
            }
        } catch (\Throwable $e) {
            \Log::alert($e->getMessage());
        }
    }

    public function Get_Schedule2()
    {
        try {
            $json = file_get_contents('http://localhost:8080/schedule');
            $events = json_decode($json);
            $text = "今天的賽程是:\n";
            foreach ($events as $index => $data) {
                $away_team = $data->away_team;
                $home_team = $data->home_team;
                $location = $data->location;
                $time = $data->time;
                $game_no = $data->game_no;
                $away_sp = $data->away_sp;
                $home_sp = $data->home_sp;

                $text .= "編號第 $game_no 場 $away_team  ($away_sp) vs $home_team ($home_sp) @$location";
                if ($index + 1 < count($events)) {
                    $text .= "\n";
                }

                $message = [
                    'type' => 'text',
                    'text' => $text
                ];
            }
            \Log::alert($text);
        } catch (\Throwable $e) {
            \Log::alert($e->getMessage());
        }
    }
}
