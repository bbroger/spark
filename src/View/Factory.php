<?php

namespace App\View;

class Factory
{
    private $view;
    private $data;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function make($template, $data = null)
    {
        $this->data = $data;
        return $this;
    }

    public function render()
    {
        return $this->view->fetch('pagination/default.twig', $this->data);
    }

    public function __toString()
    {
        return $this->render();
    }
}
