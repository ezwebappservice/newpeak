<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use CodeIgniter\Config\Services as AppServices;
use CodeIgniter\HTTP\UserAgent;
use Config\App;
use Config\View as ViewConfig;

/**
 * Services Configuration file.
 */
class Services extends BaseService
{
    public static function incomingrequest(?App $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('request', $config);
        }

        $config ??= config(App::class);

        return new \App\Libraries\CI3IncomingRequest(
            $config,
            AppServices::get('uri'),
            'php://input',
            new UserAgent(),
        );
    }

    public static function renderer(?string $viewPath = null, ?ViewConfig $config = null, bool $getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('renderer', $viewPath, $config);
        }

        $viewPath = in_array($viewPath, [null, '', '0'], true) ? (new Paths())->viewDirectory : $viewPath;
        $config ??= config(ViewConfig::class);

        return new \App\Libraries\CI3View(
            $config,
            $viewPath,
            AppServices::get('locator'),
            CI_DEBUG,
            AppServices::get('logger'),
        );
    }
}
