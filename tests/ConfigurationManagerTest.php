<?php namespace Voodoo\Configuration\Tests;

use Voodoo\Configuration\ArrowPathResolver;
use Voodoo\Configuration\ConfigurationManager;
use Voodoo\Configuration\Contracts\ConfigurationManagerInterface;
use Voodoo\Configuration\Exception\ConfigurationException;

class ConfigurationManagerTest extends \Codeception\Test\Unit
{
    /**
     * @var ConfigurationManager
     */
    protected $manager;

    protected function _before()
    {
        $this->manager = new ConfigurationManager(new ArrowPathResolver(), [
            'my' => [
                'package' => [
                    'configuration' => [
                        'text' => 'My Test',
                    ],
                ],
            ],
        ]);
    }

    protected function _after()
    {
    }

    // tests
    public function test_constructor_configuration_locks_configurationmanager()
    {
        $this->expectException(ConfigurationException::class);
        $this->manager->setAndLock([
            'Text' => 'Test',
        ]);
    }

    public function test_configuration_value_is_correct()
    {
        $value = $this->manager->get('my > package > configuration > text');
        $this->assertEquals('My Test', $value);

        $value = $this->manager->get('my > package > configuration');
        $this->assertIsArray($value);
        $this->assertCount(1, $value);
    }

    public function test_withconfiguration_returns_new_instance()
    {
        $newInstance = $this->manager->withConfiguration(['text' => "My Test"]);
        $this->assertInstanceOf(ConfigurationManagerInterface::class, $newInstance);
        $this->assertNotEquals($newInstance, $this->manager);
    }
}