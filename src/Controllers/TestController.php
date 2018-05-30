<?php

namespace Errorlog\errortrack;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TestController extends Controller
{
   public function index($name)
    {
        return view('test::index', [
            'name' => $name
        ]);
    }

}
