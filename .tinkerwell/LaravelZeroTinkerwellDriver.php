<?php

use Tinkerwell\ContextMenu\Label;
use Tinkerwell\ContextMenu\Submenu;
use Tinkerwell\ContextMenu\OpenURL;

class LaravelZeroTinkerwellDriver extends TinkerwellDriver
{
    public function canBootstrap($projectPath)
    {
        return file_exists($projectPath . '/config/commands.php') &&
            file_exists($projectPath . '/grab');
    }

    public function bootstrap($projectPath)
    {
        require_once $projectPath . '/vendor/autoload.php';

        $app = require_once $projectPath . '/bootstrap/app.php';

        $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);

        $kernel->bootstrap();
    }

    public function contextMenu()
    {
        return [
            Label::create('Detected Laravel zero v' . app()->version()),

            OpenURL::create('Documentation', 'https://tinkerwell.app'),
        ];
    }
}
