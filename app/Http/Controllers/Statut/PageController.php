<?php
namespace Xetaravel\Http\Controllers\Statut;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Xetaravel\Http\Controllers\Controller;
use Xetaravel\Models\Server;

class PageController extends Controller
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        URL::forceRootUrl(config('app.url'));
    }

    /**
     * Show the statut page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servers = Server::all();

        $statusCritical = 0;
        $statusWarning = 0;

        // Get the critical and warning status for each server to display the right alert.
        foreach ($servers as $server) {
            switch ($server->status->type) {
                case 'stopped':
                    $statusCritical = $statusCritical + 1;
                    break;

                case 'starting':
                case 'initializing':
                case 'stopping':
                    $statusWarning = $statusWarning + 1;
                    break;
            }
        }

        $alert = "success";
        if ($statusWarning > 0) {
            $alert = "warning";
        }
        if ($statusCritical > 0) {
            $alert = "danger";
        }

        return view('Statut.page.index', compact('servers', 'alert'));
    }
}
