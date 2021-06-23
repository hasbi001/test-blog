<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function jobs(Request $request)
    {
        $parameter ="?page=$request->page&description=$request->jobdes&location=$request->location&type=$request->fulltime";
        $url = 'http://dev3.dansmultipro.co.id/api/recruitment/positions.json'.$parameter;
        $result='';        
        $client = new \GuzzleHttp\Client();
        
        $exec = $client->request('GET',$url);
        $response = json_decode($exec->getBody()->getContents());
       
        $post = '';
        foreach ($response as $value) {
            if ($value === 'null') {
                $result = '';
            }
            else
            {
                if (isset($value->created_at)) {
                    $date1=date_create($value->created_at);
                    $date2=date_create(date("Y-m-d"));
                    $diff=date_diff($date1,$date2);

                    $day = (int) $diff->format('%d');
                    $month = (int) $diff->format('%m');
                    if ($month > 0) {
                        if($month > 1){
                            $post .= $month.' months';
                        }
                        else
                        {
                            $post .= $month.' month';   
                        }
                    }
                    if ($day > 0) {
                        if($day > 1){
                            $post .= ' '.$day.' days';
                        }
                        else
                        {
                            $post .= ' '. $day.' day';   
                        }
                    }
                }
                else {
                    $post = ' 0 day';
                }
                
                if (isset($value->id)) {
                    $link = route('jobs.detail',['id'=>$value->id]);
                }
                else
                {
                    $link = 'javascript:void(0)';
                }
                
                if (isset($value->title)) {
                    $title = $value->title;
                }
                else
                {
                    $title = '-';
                }
                
                if (isset($value->company)) {
                    $company = $value->company;
                }
                else
                {
                    $company = '-';
                }
                
                if (isset($value->type)) {
                    $type = $value->type;
                }
                else
                {
                    $type = '-';
                }
                
                if (isset($value->location)) {
                    $location = $value->location;
                }
                else
                {
                    $location = '-';
                }

                $result .= '<div class="isi-jobs">';
                    $result .= '<div class="row">';
                        $result .= '<div class="col-md-6">
                                        <a href="'.$link.'"><strong>'.$title.'</strong></a><br>
                                        '.$company.' - '.$type.'
                                    </div>';
                        $result .= '<div class="col-md-6 text-right">
                                        <strong>'.$location.'</strong><br>
                                        '.$post.'
                                    </div>';
                    $result .= '</div>';
                $result .= '</div>';

                $post = '';
            }
        }
        
        if ($result !== '') {
            $data = array(
                'status' => 'success',
                'result' => $result
            );
        }
        else {
            $data = array(
                'status' => 'failed',
                'result' => ''
            );
        }

        return json_encode($data);
    }


    function detailJobs($id)
    {
        $parameter ="?id=".$id;
        $url = 'http://dev3.dansmultipro.co.id/api/recruitment/positions.json'.$parameter;
        $result='';        
        $client = new \GuzzleHttp\Client();
        
        $exec = $client->request('GET',$url);
        $response = json_decode($exec->getBody()->getContents());
        $data = $response[0];
        
        return view('detail',compact('data'));
    }

    public function search(Request $request)
    {
        $parameter ="?page=$request->page&description=$request->jobdes&location=$request->location&type=$request->fulltime";
        $url = 'http://dev3.dansmultipro.co.id/api/recruitment/positions.json'.$parameter;
        $result='';        
        $client = new \GuzzleHttp\Client();
        
        $exec = $client->request('GET',$url);
        $response = json_decode($exec->getBody()->getContents());

        foreach ($response as $value) {
            $result .= $value->id; 
        }

        if ($result !== '') {
            $data = array(
                'status' => 'success',
                'result' => $result
            );
        }
        else {
            $data = array(
                'status' => 'failed',
                'result' => ''
            );
        }

        return json_encode($data);
    }
}
