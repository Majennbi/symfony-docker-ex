<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TodoController extends AbstractController
{   
    #[Route('/todo')]
    public function index(): Response
    {
        return $this->render('Todo/todo.html.twig');
    }
}