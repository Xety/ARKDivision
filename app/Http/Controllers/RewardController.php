<?php
namespace Xetaravel\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Xetaravel\Http\Helpers\Rcon;
use Xetaravel\Models\RewardUser;
use Xetaravel\Models\Server;
use Xetaravel\Models\ServerUser;
use Xetaravel\Models\User;

class RewardController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb('Récompenses', route('users.reward.index'));
    }

    /**
     * Show the rewards.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $user = User::find(Auth::id());

        $rewards = $user->rewards()
            ->orderBy('reward_user.created_at', 'desc')
            ->paginate(config('xetaravel.pagination.reward.reward_per_page'));

        $breadcrumbs = $this->breadcrumbs;

        return view(
            'reward.index',
            compact('user', 'breadcrumbs', 'rewards')
        );
    }

    /**
     * Claim a reward ingame by its ID.
     *
     * @param \Illuminate\Http\Request $request The current request.
     * @param string $slug The reward ID.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function claim(Request $request): JsonResponse
    {
        $user = Auth::user();

        if (is_null($user->steam_id)) {
            return response()->json([
                'error' => true,
                'display' => true,
                'message' => 'Vous n\'avez pas encore lié votre compte Division à votre compte Steam. Vous pouvez' .
                ' lier votre compte Steam via le menu Social.'
            ]);
        }

        $reward = $user->rewards()
            ->wherePivot('id', $request->input('id'))
            ->first();

        if (!$reward) {
            return response()->json([
                'error' => true,
                'display' => true,
                'message' => 'Ce reward n\'existe pas ou ne vous appartient pas.'
            ]);
        }

        if ($reward->pivot->was_used) {
            return response()->json([
                'error' => true,
                'display' => true,
                'message' => 'Ce reward vous a déjà été attribué.'
            ]);
        }

        // Check if the user is still connected on a server
        $player = ServerUser::where('steam_id', $user->steam_id)->first();

        if (!$player) {
            return response()->json([
                'error' => true,
                'display' => true,
                'message' => 'Vous n\'êtes pas connecté sur l\'un des serveurs du cluster.'
            ]);
        }

        $command = sprintf($reward->data['command'], $user->steam_id);

        // Check if the command has a gender, if yes check the gender type `male` or `female`
        if ($request->input('gender') == true) {
            $command = sprintf($reward->data['command'], $user->steam_id, $reward->gender_female);

            if ($request->input('gender') == 'male') {
                $command = sprintf($reward->data['command'], $user->steam_id, $reward->gender_male);
            }
        }

        // Get the server where is the player
        $server = Server::where('id', $player->server_id)->first();

        // Send the command to RCON
        $response = $this->sendCommand($server, $command);

        $response = trim($response);

        // The command has a bad syntax.
        if ($response == "Request has failed") {
            return response()->json([
                'error' => true,
                'display' => true,
                'message' => 'Une erreur est survenu lors de l\'envoie de la commande, veuillez contacter un admin.'
            ]);
        }

        // The player has changed map or has logout while trying to get the reward.
        if ($response == "Can't find player from the given steam id") {
            return response()->json([
                'error' => true,
                'display' => true,
                'message' => 'Veuillez ne pas changer de map ou vous déconnecter' .
                ' lors du processus d\'obtention de la récompense.'
            ]);
        }

        // Update the Reward pivot table
        $rewardUser = RewardUser::find($request->input('id'));
        $rewardUser->used_at = Carbon::now();
        $rewardUser->was_used = true;
        $rewardUser->save();


        return response()->json([
            'error' => false,
            'display' => true,
            'message' => "La {$reward->name} vient de vous être donnée dans le jeu sur le serveur {$server->name}."
        ]);
    }

    /**
     * Mark a reward as read.
     *
     * @param \Illuminate\Http\Request $request The current request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function markAsRead(Request $request): JsonResponse
    {
        $user = Auth::user();
        $reward = $user->rewards()
            ->wherePivot('id', $request->input('id'))
            ->first();

        if ($reward) {
            $rewardUser = RewardUser::find($request->input('id'));

            $rewardUser->read_at = Carbon::now();
            $rewardUser->save();

            return response()->json([
                'error' => false
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    }

    /**
     * Connect to RCON, send the command and return the response.
     *
     * @param string $command The command tos end to the RCON server.
     *
     * @return string
     */
    protected function sendCommand(Server $server, $command): string
    {
        $rcon = new Rcon($server->ip, $server->rcon_port, $server->password, 3);

        $rcon->connect();

        $response = $rcon->sendCommand($command);

        $rcon->disconnect();

        return $response;
    }
}
