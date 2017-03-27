<?php namespace Scalex\Zero\Managers;

use Illuminate\Foundation\Application;
use Illuminate\Support\Manager;
use InvalidArgumentException;
use Omnipay\Common\GatewayFactory;

class OmnipayManager extends Manager
{
    /**
     * @var \Omnipay\Common\GatewayFactory
     */
    protected $factory;

    public function __construct(Application $app, GatewayFactory $factory)
    {
        parent::__construct($app);
        $this->factory = $factory;
    }

    public function getDefaultDriver()
    {
        return config('omnipay.default');
    }

    protected function createDriver($driver)
    {
        $config = config('omnipay.gateways.'.$driver);

        if (is_null($config)) {
            throw new InvalidArgumentException("Driver [$driver] not supported.");
        }

        $gateway = $this->factory->create($config['driver']);

        foreach ($config as $name => $value) {
            $method = 'set'.studly_case($name);

            if (method_exists($gateway, $method)) {
                $gateway->$method($value);
            }
        }

        return $gateway;
    }
}
