<?php
namespace Xetaravel\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    /**
     * Show the home page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('page.index');
    }

    /**
     * Display the banished page.
     *
     * @return \Illuminate\Http\Response
     */
    public function banished()
    {
        if (!Auth::user()->hasRole('banni')) {
            return redirect()
                ->route('page.index');
        }

        return view('page.banished');
    }
}
