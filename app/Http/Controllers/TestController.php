<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Bread\Table;

class TestController extends Controller
{
    public function index(Request $request){
    	$objTable = Table::find(1);

    	foreach($objTable->relationships as $relationship){
    		// dd($relationship);
    		dd((new $relationship->model)->find(3));
    	}
    	dd('test');
    	$objOffice = Table::find(2);
    	// dd((new $objTable->model)->find('4656'));
    	dd((new $objOffice->model)->find(3));
    }
}
