<?php
namespace Tests\Http\Controllers\Statut;

use Xetaravel\Models\User;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    /**
     * testIndexNotLoggedInSuccess method
     *
     * @return void
     */
    public function testIndexNotLoggedInSuccess()
    {
        $response = $this->get(route('statut.page.index'));
        $response->assertSuccessful();
        $response->assertDontSee('Afficher les joueurs');
    }
}
