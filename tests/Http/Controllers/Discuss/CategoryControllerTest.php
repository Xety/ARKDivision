<?php
namespace Tests\Http\Controllers\Discuss;

use Tests\TestCase;

class CategoryControllerTest extends TestCase
{

    /**
     * testIndex method
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get(route('discuss.category.index'));
        $response->assertSuccessful();
    }

    /**
     * testShow method
     *
     * @return void
     */
    public function testShow()
    {
        $response = $this->get(route('discuss.category.show', ['slug' => 'annonces','id' => 1]));
        $response->assertSuccessful();
    }
}
