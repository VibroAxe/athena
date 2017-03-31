<?php namespace Zeropingheroes\Lanager\Http\Gui;

use Illuminate\Routing\Controller;
use View;
use Redirect;
use URL;
use Request;
use Input;

class ExternalController extends Controller {

        /**
         * Set the controller's service
         */
        public function __construct()
        {
        }



        /**
         * Display the specified resource.
         *
         * @param  int  $id
         * @return Response
         */
        public function show( )
		{
			$url = Input::get('url');
			$title = Input::get('title');
		return View::make('external.show')
			-> with( 'title', ($title==""?'Web':$title))
			-> with( 'src' , $url);
		}
	}

?>
