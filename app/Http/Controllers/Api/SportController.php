<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Inplay;
use App\Models\League;
use App\Models\PreMatchMarket;
use App\Models\Team;
use App\Models\UpcomingEvent;
use Illuminate\Http\Request;
use GuzzleHttp\Client;


class SportController extends Controller
{
    public function test() {}

    public function insertCountry()
    {
        try {
            $client = new Client(['timeout' => 10]);
            $res  = $client->get('https://betsapi.com/docs/samples/countries.json');
            $data = json_decode($res->getBody(), true);
            // dd($data['results']);
            foreach ($data['results'] as $country) {
                Country::updateOrCreate(
                    ['name' => $country['name'], 'cc' => $country['cc']], // Search conditions
                    ['name' => $country['name'], 'cc' => $country['cc']]  // Update or insert values
                );
            }
            return "success";
            // return response()->json($data);

        } catch (\Exception $e) {
            logger()->error($e->getMessage());
        }
    }

    public function insertLeagueData()
    {
        try {
            League::truncate();
            $client = new Client(['timeout' => 5000]);
            $sport_ids = config('constant.categories');
            foreach($sport_ids as $sport_id){
                $url = "https://api.b365api.com/v1/bet365/upcoming?sport_id=$sport_id&token=215719-Vwi71YEzXvkgEj";
                $res = $client->get($url);
                if ($res->getStatusCode() === 200) {
                    $data = json_decode($res->getBody(), true);
                    League::updateOrCreate(['sport_id' => $sport_id], [
                        'data' => $data,
                        'page_no'=>null,
                        'sport_id'=>$sport_id
                    ]);
                }
            }
           
           return response()->json(['msg'=>'Success']);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function getLeagueData(Request $request)
    {
        $sport_id=3;
        $page=1;
        if($request->sport_id){
            $sport_id = $request->sport_id;
        }
        if($request->page){
            $page= $request->page;
        }
        $league = League::where(['sport_id'=>$sport_id,'page_no'=>$page])->first();
        $data = $league->data;
        if ($request->cc) {
            return $this->filterCC($request, $data);
        }
        return $data;
    }

    public function insertTeamData()
    {
        try {
            $client = new Client(['timeout' => 10]);
            for ($i = 1; $i <= 22; $i++) {
                $url = 'https://api.b365api.com/v1/bet365/upcoming?sport_id=3&token=215719-Vwi71YEzXvkgEj&page='.$i;
                $res = $client->get($url);
                if ($res->getStatusCode() === 200) {
                    $data = json_decode($res->getBody(), true);
                    Team::updateOrCreate(['sport_id' => 3,'page_no'=>$i], [
                        'data' => $data,
                        'page_no'=>$i
                    ]);
                }
            }
        return response()->json(['msg'=>'success']);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function getTeamData(Request $request)
    {
        $sport_id=3;
        $page=1;
        if($request->sport_id){
            $sport_id = $request->sport_id;
        }
        if($request->page){
            $page= $request->page;
        }
        $team = Team::where(['sport_id'=>$sport_id,'page_no'=>$page])->first();
        $data = $team->data;
        if ($request->cc) {
            return $this->filterCC($request, $data);
        }
        return $data;
    }


    public function insertUpcomingEventData()
    {
        try {
            UpcomingEvent::truncate();
            $client = new Client(['timeout' => 5000]);
            $sport_ids = config('constant.categories');
            foreach($sport_ids as $sport_id){
                $url = "https://api.b365api.com/v1/bet365/upcoming?sport_id=$sport_id&token=215719-Vwi71YEzXvkgEj";
                $res = $client->get($url);
                if ($res->getStatusCode() === 200) {
                    $data = json_decode($res->getBody(), true);
                    UpcomingEvent::updateOrCreate(['sport_id' => $sport_id], [
                        'data' => $data,
                        'page_no'=>null,
                        'sport_id'=>$sport_id
                    ]);
                }
            }
            return response()->json(['msg'=>'Success']);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getUpcomingData(Request $request)
    {
        $sport_id = 1;
        if ($request->sport_id) {
            $sport_id = $request->sport_id;
        }
        $team = UpcomingEvent::where('sport_id', $sport_id)->first();
        $data = $team->data;
        return $data;
    }

    public function insertInplayData()
    {
        try {
            $client = new Client(['timeout' => 10]);
            $res = $client->get('https://betsapi.com/docs/samples/inplay.json');
            if ($res->getStatusCode() === 200) {
                $data = json_decode($res->getBody(), true);
                Inplay::updateOrCreate(['sport_id' => 1], [
                    'data' => $data
                ]);
            }
            return "Success";
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function getInplayData(Request $request)
    {
        $sport_id = 1;
        if ($request->sport_id) {
            $sport_id = $request->sport_id;
        }
        $team = Inplay::where('sport_id', $sport_id)->first();
        $data = $team->data;
        return $data;
    }

    public function insertPreMatchMarketData(){
        try {
            PreMatchMarket::truncate();
            
            $client = new Client(['timeout' => 5000]);

            $upcoming_events = UpcomingEvent::get();
           
            foreach($upcoming_events as $upcoming_event){
                foreach($upcoming_event->data['results'] as $result){
                    $upcoming_event_id = $result['id'];
                    $url = "https://api.b365api.com/v3/bet365/prematch?token=215719-Vwi71YEzXvkgEj&FI=$upcoming_event_id&page=";
                    $res = $client->get($url);
                    if ($res->getStatusCode() === 200) {
                        $data = json_decode($res->getBody(), true);
                        PreMatchMarket::updateOrCreate(['upcoming_event_id' => $upcoming_event_id], [
                            'data' => $data,
                        ]);
                }
                }
            }
            
        return response()->json(['msg'=>'success']);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function getPreMatchMarketData(Request $request)
    {
        $upcoming_event_id = $request->F1;
    
        if (PreMatchMarket::where('upcoming_event_id', $upcoming_event_id)->doesntExist()) {
            return response()->json(['msg' => 'error'], 500);
        }
    
        $data = PreMatchMarket::where('upcoming_event_id', $upcoming_event_id)->value('data');
    
        return $data;
    }
    

    private function filterCC($request, $data)
    {

        $filter_data = collect($data['results'])->where('cc', $request->cc)->values();
        return [
            'pager' => $data['pager'],
            'results' => $filter_data
        ];
    }
}
