<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class Programs extends MY_Controller
{
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->Model_common = new \App\Models\Model_common();
    }

    public function parents()
    {
        $this->render_frontend('view_for_parents', [
            'current_page'     => 'for-parents',
            'meta_title'       => 'For Parents | Peak Potential Academy',
            'meta_description' => 'Science-backed tools and practical strategies to raise emotionally strong, well-behaved children in today’s digital world.',
        ]);
    }

    public function school()
    {
        $this->render_frontend('view_for_school', [
            'current_page'     => 'for-school',
            'meta_title'       => 'For Schools | Peak Potential Academy',
            'meta_description' => 'Partner with Peak Potential Academy to help students manage emotions, break screen addiction and build inner skills they need to thrive.',
        ]);
    }

    public function students()
    {
        $this->render_frontend('view_for_students', [
            'current_page'     => 'for-students',
            'meta_title'       => 'For Students | Peak Potential Academy',
            'meta_description' => 'Help your child thrive in life, not just in exams — break screen addiction, manage emotions and build stronger habits.',
        ]);
    }

    public function corporate()
    {
        $this->render_frontend('view_for_corporate', [
            'current_page'     => 'for-corporate',
            'meta_title'       => 'For Corporates | Peak Potential Academy',
            'meta_description' => 'Raise emotionally resilient teams. Lead with clarity. Drive real transformation with Peak Potential Academy.',
        ]);
    }
}
