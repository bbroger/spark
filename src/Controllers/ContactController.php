<?php

namespace App\Controllers;

use Respect\Validation\Validator as v;

class ContactController extends Controller 
{
    public function index($request, $response)
    {
        return $this->view->render($response, 'contact.twig');
    }

    public function store($request, $response)
    {
        $this->validate($request, [
            'name' => v::notBlank(),
            'body' => v::notBlank()
        ]);

        return $response;
    }
}