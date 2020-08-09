<?php
namespace Xetaravel\Http\Controllers\Statut;

use Illuminate\Support\Facades\Auth;
use Xetaravel\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * Show the statut page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('statut.page.index');
    }
}
