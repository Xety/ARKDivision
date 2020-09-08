<?php
namespace Tests\Http\Controllers\Donation;

use Tests\TestCase;
use ReflectionClass;
use Xetaravel\Http\Controllers\Donation\PaypalController;

class PaypalControllerTest extends TestCase
{
    protected static function getMethod($name)
    {
        $class = new ReflectionClass(PaypalController::class);
        $method = $class->getMethod($name);
        $method->setAccessible(true);

        return $method;
    }

    /**
     * testGetCountFirstDonation method
     *
     * @return void
     */
    public function testGetCount()
    {
        $getCount = self::getMethod('getCount');
        $paypal = new PaypalController();

        config([
            'xetaravel.donation.color_interval' => 10,
            'xetaravel.donation.skin_interval' => 15,
            'xetaravel.donation.reward_interval' => 20,
        ]);

        // First donation without rewards
        $result = $getCount->invokeArgs($paypal, [10, 0, 0, 'reward']);
        $this->assertSame(0, $result);

        // First donation with rewards
        $result = $getCount->invokeArgs($paypal, [20, 0, 0, 'reward']);
        $this->assertSame(1, $result);

        // Donation without rewards due to old donation : 5 + 10 = 15
        $result = $getCount->invokeArgs($paypal, [5, 0, 10, 'reward']);
        $this->assertSame(0, $result);

        // Donation with rewards due to old donation : 5 + 15 = 20
        $result = $getCount->invokeArgs($paypal, [5, 0, 15, 'reward']);
        $this->assertSame(1, $result);

        // Donation with reward
        $result = $getCount->invokeArgs($paypal, [20, 1, 20, 'reward']);
        $this->assertSame(1, $result);

        // Donation with multiple rewards
        $result = $getCount->invokeArgs($paypal, [40, 1, 20, 'reward']);
        $this->assertSame(2, $result);

        // Donation with multiple rewards
        $result = $getCount->invokeArgs($paypal, [40, 0, 0, 'reward']);
        $this->assertSame(2, $result);
    }
}
