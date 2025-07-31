<?php

namespace App\Controllers;

class HomePage extends BaseController
{
    public function index(): string
    {
        $data['title'] = 'Home Page';
        return view('templates/HomeHeader', $data)
            . view('pages/HomePage')
            . view('templates/Footer');
    }
}
