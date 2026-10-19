<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Workshop extends BaseConfig
{
    public string $title = 'Understand Your Teen';

    public string $badge = 'Workshop Registration';

    public string $summary = 'Please fill in your details below to reserve your seat — 18 Oct 2026, 07 AM – 08 AM';

    public string $eventDate = '18 Oct 2026';

    public string $eventTime = '07 AM – 08 AM';

    public string $eventFormat = 'Live on Zoom';

    /** Optional Zoom URL. Empty when the admin has not added a link. */
    public string $zoomLink = '';

    /** Optional YouTube URL shown beside the workshop headline. */
    public string $youtubeUrl = '';

    public string $when = '18 Oct 2026, 07 AM – 08 AM';

    public string $where = 'Live on Zoom';

    public string $audience = 'Parents of 13+ year olds';

    /** Seat fee in rupees. Admin Workshop Seats overrides workshop.amountInr in .env. */
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

        $this->applyStoredAmount();
        $this->applyStoredSchedule();
        $this->applyStoredVideo();
    }

    /**
     * Use the seat fee saved from the admin panel when it is available.
     */
    public function applyStoredAmount(): void
    {
        try {
            $db = \Config\Database::connect();

            if (! $db->tableExists('tbl_settings') || ! $db->fieldExists('workshop_seat_fee', 'tbl_settings')) {
                return;
            }

            $row = $db->table('tbl_settings')->select('workshop_seat_fee')->where('id', 1)->get()->getRowArray();
            $fee = (int) ($row['workshop_seat_fee'] ?? 0);

            if ($fee > 0) {
                $this->amountInr = $fee;
            }
        } catch (\Throwable $e) {
            log_message('error', 'Workshop seat fee could not be loaded: ' . $e->getMessage());
        }
    }

    /**
     * Use the date, time, format, and optional Zoom link saved from the admin panel.
     */
    public function applyStoredSchedule(): void
    {
        try {
            $db = \Config\Database::connect();

            if (! $db->tableExists('tbl_settings') || ! $db->fieldExists('workshop_event_date', 'tbl_settings')) {
                $this->syncDerived();

                return;
            }

            $row = $db->table('tbl_settings')
                ->select('workshop_event_date, workshop_event_time, workshop_event_format, workshop_zoom_link')
                ->where('id', 1)
                ->get()
                ->getRowArray();

            $date = trim((string) ($row['workshop_event_date'] ?? ''));
            $time = trim((string) ($row['workshop_event_time'] ?? ''));
            $format = trim((string) ($row['workshop_event_format'] ?? ''));
            $zoom = trim((string) ($row['workshop_zoom_link'] ?? ''));

            if ($date !== '') {
                $this->eventDate = $date;
            }

            if ($time !== '') {
                $this->eventTime = $time;
            }

            if ($format !== '') {
                $this->eventFormat = $format;
            }

            $this->zoomLink = $this->isHttpUrl($zoom) ? $zoom : '';
            $this->syncDerived();
        } catch (\Throwable $e) {
            log_message('error', 'Workshop schedule could not be loaded: ' . $e->getMessage());
            $this->syncDerived();
        }
    }

    /**
     * Use the YouTube link saved from the admin panel when it is available.
     */
    public function applyStoredVideo(): void
    {
        try {
            $db = \Config\Database::connect();

            if (! $db->tableExists('tbl_settings') || ! $db->fieldExists('workshop_youtube_url', 'tbl_settings')) {
                return;
            }

            $row = $db->table('tbl_settings')->select('workshop_youtube_url')->where('id', 1)->get()->getRowArray();
            $url = trim((string) ($row['workshop_youtube_url'] ?? ''));
            $this->youtubeUrl = $this->youtubeId($url) !== '' ? $url : '';
        } catch (\Throwable $e) {
            log_message('error', 'Workshop video could not be loaded: ' . $e->getMessage());
        }
    }

    /**
     * Privacy-enhanced embed URL, or empty when the saved link is not a YouTube video.
     */
    public function youtubeEmbedUrl(): string
    {
        $id = $this->youtubeId($this->youtubeUrl);

        return $id === '' ? '' : 'https://www.youtube-nocookie.com/embed/' . rawurlencode($id);
    }

    public function youtubeId(string $url): string
    {
        $url = trim($url);

        if ($url === '') {
            return '';
        }

        if (preg_match('/^[A-Za-z0-9_-]{11}$/', $url) === 1) {
            return $url;
        }

        if (! $this->isHttpUrl($url)) {
            return '';
        }

        $host = strtolower((string) parse_url($url, PHP_URL_HOST));
        $host = (string) preg_replace('/^www\./', '', $host);
        $path = (string) parse_url($url, PHP_URL_PATH);
        parse_str((string) parse_url($url, PHP_URL_QUERY), $params);
        $watchId = (string) ($params['v'] ?? '');

        if (in_array($host, ['youtube.com', 'm.youtube.com', 'music.youtube.com', 'youtube-nocookie.com'], true)) {
            if (preg_match('/^[A-Za-z0-9_-]{11}$/', $watchId) === 1) {
                return $watchId;
            }

            if (preg_match('#^/(?:embed|shorts|live|v)/([A-Za-z0-9_-]{11})(?:/|$)#', $path, $match) === 1) {
                return $match[1];
            }
        }

        if ($host === 'youtu.be' && preg_match('#^/([A-Za-z0-9_-]{11})(?:/|$)#', $path, $match) === 1) {
            return $match[1];
        }

        return '';
    }

    public function syncDerived(): void
    {
        $this->when = trim($this->eventDate . ', ' . $this->eventTime, " \t\n\r\0\x0B,");
        $this->where = $this->eventFormat;
        $this->summary = 'Please fill in your details below to reserve your seat — ' . $this->when;
    }

    public function isHttpUrl(string $url): bool
    {
        if ($url === '' || filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        return $scheme === 'http' || $scheme === 'https';
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
