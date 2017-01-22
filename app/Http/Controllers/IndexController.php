<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Page;
use App\People;
use App\Portfolio;
use App\Service;
 use DB;
use Mail;
//use Illuminate\Support\Facades\DB;



class IndexController extends Controller
{
    public function execute(Request $request) {

        if ($request->isMethod('post')) {

            $messages = [

              'required'=>"Поле :attribute обязательно к заполнению",
              'required'=>"Поле :attribute должно соответствовать email адресу"

            ];


          $this->validate($request, [

              'name'=>'required|max:255',
              'email'=>'required|email',
              'text'=>'required'


          ], $messages);

            // Отправка email переделать!!!!!!!!!!!

            $data = $request->all();
            //dump($data);
            $result = Mail::send('site.email', ['data'=>$data], function ($message) use ($data) {

                $mail_admin = env('MAIL_ADMIN');
                // dump($mail_admin);
                $a = $message->from($data['email'], $data['name']);
               // dump($a);

                $b = $message->to($mail_admin, 'Mr. Admin')->subject('Question');

                //dump($b);

            });

           // dump($result);
            if ($result) {

                return redirect()->route('home')->with('status', 'Email is send');


            }

        }

        $pages = Page::all();
        $portfolios = Portfolio::get(['name', 'filter', 'images']);
        $services = Service::where('id', '<', 20) -> get();
        $peoples = People::take(3) -> get();

        $tags = DB::table('portfolios')->distinct()->pluck('filter');




        $menu = [];
        foreach ($pages as $page) {

            $item = ['title' => $page -> name , 'alias' => $page -> alias];
            array_push($menu, $item);

        }

        $item = ['title'=>'Качества', 'alias'=>'service'];
        array_push($menu, $item);

        $item = ['title'=>'Внутренний мир', 'alias'=>'Portfolio'];
        array_push($menu, $item);

        $item = ['title'=>'Мнения', 'alias'=>'team'];
        array_push($menu, $item);

        $item = ['title'=>'Контакты', 'alias'=>'contact'];
        array_push($menu, $item);

        return view('site.index', [
            'menu'=>$menu,
            'pages'=>$pages,
            'portfolios'=>$portfolios,
            'services'=>$services,
            'peoples'=>$peoples,
            'tags'=>$tags

        ]);
    }


}
