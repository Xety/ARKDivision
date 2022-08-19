<?php
namespace Xetaravel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use League\ColorExtractor\Color;
use League\ColorExtractor\Palette;
use Xetaravel\Models\Repositories\AccountRepository;
use Xetaravel\Models\User;
use Xetaravel\Models\Validators\AccountValidator;

class AccountController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb('Account', route('users.user.account'));
    }

    /**
     * Handle an account update request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        AccountValidator::update($request->all())->validate();
        $account = AccountRepository::update($request->all(), Auth::id());

        $user = User::find(Auth::id());

        if (!is_null($request->file('avatar'))) {
            $palette = Palette::fromFilename($request->file('avatar')->path());
            $topColor = $palette->getMostUsedColors(1);

            $color = '#FFFFFF';
            foreach ($topColor as $color => $count) {
                $color = Color::fromIntToHex($color);
            }

            $user->clearMediaCollection('avatar');
            $user->addMedia($request->file('avatar'))
                ->preservingOriginal()
                ->setName(substr(md5($user->username), 0, 10))
                ->setFileName(substr(md5($user->username), 0, 10) . '.' . $request->file('avatar')->extension())
                ->withCustomProperties(['primaryColor' => $color])
                ->toMediaCollection('avatar');
        }

        return redirect()
            ->route('users.user.account')
            ->with('success', 'Votre compte a été mis à jour avec succès!');
    }
}
