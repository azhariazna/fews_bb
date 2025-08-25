<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Log\Handlers\FileHandler;

class Logger extends BaseConfig
{
    /**
     * Error Logging Threshold
     *
     * You can enable error logging by setting a threshold over zero. The
     * threshold determines what gets logged. Any values below or equal to the
     * threshold will be logged.
     *
     * Threshold options are:
     * - 0 = Disables logging, Error logging TURNED OFF
     * - 1 = Emergency Messages - System is unusable
     * - 2 = Alert Messages - Action Must Be Taken Immediately
     * - 3 = Critical Messages - Application component unavailable, unexpected exception.
     * - 4 = Runtime Errors - Don't need immediate action, but should be monitored.
     * - 5 = Warnings - Exceptional occurrences that are not errors.
     * - 6 = Notices - Normal but significant events.
     * - 7 = Info - Interesting events, like user logging in, etc.
     * - 8 = Debug - Detailed debug information.
     * - 9 = All Messages
     *
     * @var int|list<int>
     */
    public $threshold = 9;

    /**
     * Date Format for Logs
     *
     * Each item that is logged has an associated date. You can use PHP date
     * codes to set your own date formatting
     *
     * @var string
     */
    public $dateFormat = 'Y-m-d H:i:s';

    /**
     * Log Handlers
     *
     * The logging system supports multiple actions to be taken when something
     * is logged. This is done by allowing for multiple Handlers, special classes
     * designed to write the log to their chosen destinations, whether that is
     * a file on the server, a cloud-based service, or even taking actions such
     * as emailing the dev team.
     *
     * Each handler is defined by the class name used for that handler, and it
     * MUST implement the `CodeIgniter\Log\Handlers\HandlerInterface` interface.
     *
     * @var array<class-string, array<string, mixed>>
     */
    public $handlers = [
        FileHandler::class => [
            'handles' => [
                'critical',
                'error',
                'warning',
                'notice',
                'info',
                'debug',
                'emergency',
                'alert',
            ],
            'fileExtension' => 'log',
            'filePermissions' => 0664,
            'path' => WRITEPATH . 'logs/',
        ],
    ];

    /**
     * The default filename extension for log files.
     * An extension of 'php' allows for protecting the log files via basic
     * scripting, when they are to be stored under a publicly accessible directory.
     *
     * @var string
     */
    public $fileExtension = 'log';

    /**
     * The file system permissions to be applied on newly created log files.
     *
     * @var int
     */
    public $filePermissions = 0664;

    /**
     * Logging Directory Path
     *
     * @var string
     */
    public $path = '';
}
