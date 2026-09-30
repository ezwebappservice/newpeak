<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Workshop extends BaseConfig
{
    public string $title = 'Understand Your Teen';

    public string $badge = 'Workshop Registration';

    public string $summary = 'Please fill in your details below to reserve your seat — 4th October 2026, 11 AM–12 PM (IST)';

    public string $when = '4th October 2026, 11:00 AM–12:00 PM IST';

    public string $where = 'Live on Zoom';

    public string $audience = 'Parents of 13+ year olds';

    /** Seat fee in rupees. Override with workshop.amountInr in .env. */
    public int $amountInr = 299;

    public string $currency = 'INR';

    /** @var list<string> */
    public array $mediums = ['English', 'Hindi', 'English & Hindi'];

    /** @var list<string> */
    public array $sources = ['LinkedIn', 'Facebook', 'Instagram', 'Other Sources'];

    public function __construct()
    {
        parent::__construct();

        $amount = env('workshop.amountInr');

        if ($amount !== null && $amount !== false && $amount !== '') {
            $this->amountInr = max(1, (int) $amount);
        }
    }

    public function amountPaise(): int
    {
        return $this->amountInr * 100;
    }

    public function amountLabel(): string
    {
        return '₹' . number_format($this->amountInr);
    }
}
