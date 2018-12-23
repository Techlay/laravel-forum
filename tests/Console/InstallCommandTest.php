<?php


namespace Tests\Console;

use Illuminate\Support\Facades\File;
use Mockery;
use Tests\Testcase;

class InstallCommandTest extends Testcase
{
    protected function setUp()
    {
        parent::setUp();

        File::move('.env', '.env.backup');

        config(['app.key' => '']);
    }

    protected function tearDown()
    {
        parent::tearDown();

        File::move('.env.backup', '.env');
    }

    /** @test */
    public function it_creates_the_example_file()
    {
        $this->assertFileNotExists('.env');

        $this->artisan('forum:install');

        $this->assertFileExists('.env');
    }

    /** @test */
    public function it_generates_an_app_key()
    {
        $key = 'APP_KEY';

        $this->artisan('forum:install');

        $this->assertStringStartsWith('base64:', $this->getEnvValue($key));
    }

    /** @test */
    public function it_optionally_migrates_the_database()
    {
        $this->partialMock(['confirm', 'call'], function ($mock) {
            $mock->shouldReceive('confirm')->once()->andReturn(true);
            $mock->shouldReceive('call')->with('key:generate');
            $mock->shouldReceive('call')->with('migrate')->once();
        });

        $this->artisan('forum:install', ['--no-interaction' => true]);
    }

    protected function partialMock($methods, $assertions = null)
    {
        $assertions = $assertions ?? function () {};

        $methods = implode(',', (array)$methods);

        $command = Mockery::mock("App\Console\Commands\InstallCommand[{$methods}]", $assertions);

        app('Illuminate\Contracts\Console\Kernal')->registerCommand($command);

        return $command;
    }

    protected function assertEnvKeyEquals($key, $value)
    {
        $this->assertEquals($value, $this->getEnvValue($key));
    }

    protected function getEnvValue($key)
    {
        $file = file_get_contents('.env');

        preg_match("/{$key}=(.*)/", $file, $matches);

        return $matches[1];
    }
}
