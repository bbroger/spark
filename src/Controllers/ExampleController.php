<?php

namespace App\Controllers;

use Respect\Validation\Validator as v;

class ExampleController extends Controller 
{
    public function index($request, $response)
    {
        return $this->view->render($response, 'example.twig');
    }

    public function store($request, $response)
    {
        $this->validate($request, [
            'name' => v::notBlank(),
            'subject' => v::notBlank()
        ], [
            'name.notBlank' => 'Preencha o campo nome!',
            'subject' => 'Preencha o campo assunto!'
        ]);

        $response->write('Validação com sucesso!');

        return $response;
    }
}