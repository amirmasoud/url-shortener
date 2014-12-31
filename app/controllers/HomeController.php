<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index()
	{
		return View::make('home');
	}

	/**
	 * convert to base
	 * @param  number  $num
	 * @param  integer $b   [description]
	 * @return base
	 */
	private static function toBase($num, $b = 62)
	{
		$base='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$r = $num  % $b ;
		$res = $base[$r];
		$q = floor($num/$b);
		while ($q)
		{
			$r = $q % $b;
			$q =floor($q/$b);
			$res = $base[$r].$res;
		}
		return $res;
	}

	public function short()
	{
		// long url
		$url = Input::get('url');

		if(empty($url))
			return Redirect::route('get.home')
							->with('empty', 'empty');

		// if it does not have http:// so we add it
		if(!preg_match("/^http:\/\//", Input::get('url')))
		{
			$url = "http://" . $url;
		}

		// check site dns
		$validator = Validator::make(
		    array(
		        'url' => $url
		    ),
		    array(
		        'url' => 'active_url'
		    )
		);

		// if site does not exists
		if ($validator->fails())
		{
			return Redirect::route('get.home')
							->with('error', 'error');
		}

		// now we have the site so let short the url!
		if( DB::table('url')->select('url')->where('url', '=', $url)->get() )
		{
			$short_url = DB::table('url')->select('short')->where('url', '=', $url)->get()[0]->short;

			// prepair url
			$short_url = URL::to('/') . '/' .  $short_url;

			return Redirect::route('get.home')
							->with('url', HTML::link($short_url, $short_url));
		}
		else
		{
			$id = DB::table('url')->insertGetId(
				array('url' => $url, 'short' => 0)
			);

			DB::table('url')->where('url', '=', $url)
							->update(
				array('short' => static::toBase($id))
				);

			// prepair url
			$short_url = URL::to('/') . '/' .  static::toBase($id);

			return View::make('get.home')
							->with('url', HTML::link($short_url, $short_url));
		}
	}

	public function notfound()
	{
		echo 404;
	}

	public function redirect($su)
	{
		$result = DB::table('url')->where('short', '=', $su)->get();
		if($result)
		{
			return Redirect::away($result[0]->url);
		}
		else
			return Redirect::route('404');
	}

}
