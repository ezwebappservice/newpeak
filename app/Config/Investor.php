<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Investor extends BaseConfig
{
    /** Maximum upload size in kilobytes (10 MB). */
    public int $maxUploadSizeKb = 10240;

    /** Number of years to show in dropdowns (including current). */
    public int $yearRange = 10;

    /** Documents listed per page on the frontend investor documents screen. */
    public int $documentsPerPage = 10;

    /** Allowed document extensions (lowercase). */
    public array $allowedExtensions = [
        'pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'html', 'htm', 'txt', 'zip',
    ];

    /** Blocked executable / script extensions. */
    public array $blockedExtensions = [
        'exe', 'bat', 'cmd', 'com', 'pif', 'scr', 'vbs', 'js', 'jar', 'msi',
        'php', 'php3', 'php4', 'php5', 'phtml', 'sh', 'bash', 'pl', 'py', 'rb',
        'asp', 'aspx', 'cgi', 'dll', 'so', 'app', 'deb', 'rpm',
    ];

    /** Optional document type dropdown values. */
    public array $documentTypes = [
        'PDF',
        'DOC',
        'DOCX',
        'XLS',
        'XLSX',
        'CSV',
        'HTML',
        'TXT',
        'ZIP',
        'Other',
    ];
}
