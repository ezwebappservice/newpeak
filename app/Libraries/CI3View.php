<?php

namespace App\Libraries;

use CodeIgniter\Autoloader\FileLocatorInterface;
use CodeIgniter\View\View;
use Config\View as ViewConfig;
use Psr\Log\LoggerInterface;

/**
 * View renderer with CodeIgniter 3 style $this->session in views.
 */
class CI3View extends View
{
    protected CI3Session $ci3Session;

    public function __construct(
        ViewConfig $config,
        ?string $viewPath = null,
        ?FileLocatorInterface $loader = null,
        ?bool $debug = null,
        ?LoggerInterface $logger = null,
    ) {
        parent::__construct($config, $viewPath, $loader, $debug, $logger);
        $this->ci3Session = new CI3Session();
    }

    public function __get(string $key)
    {
        if ($key === 'session') {
            return $this->ci3Session;
        }

        return null;
    }
}
