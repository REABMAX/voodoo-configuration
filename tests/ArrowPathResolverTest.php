<?php namespace Voodoo\Configuration\Tests;

use Voodoo\Configuration\ArrowPathResolver;
use Voodoo\Configuration\Exception\ConfigurationException;

class ArrowPathResolverTest extends \Codeception\Test\Unit
{
    protected $configuration = [
        'my' => [
            'package' => [
                'configuration' => [
                    'text' => 'My Text',
                ],
            ],
        ],
    ];

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function test_correct_configuration_is_returned()
    {
        $resolver = new ArrowPathResolver();
        $var = $resolver->resolvePath('my > package > configuration > text', $this->configuration);
        $this->assertEquals('My Text', $var);

        $var = $resolver->resolvePath('my > package > configuration', $this->configuration);
        $this->assertIsArray($var);
        $this->assertCount(1, $var);
        $val = array_shift($var);
        $this->assertEquals('My Text', $val);
    }

    public function test_wrong_configuration_path_throws_exception()
    {
        $resolver = new ArrowPathResolver();
        $this->expectException(ConfigurationException::class);
        $resolver->resolvePath('my > not_existing_package', $this->configuration);
    }
}