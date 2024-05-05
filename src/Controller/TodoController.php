<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{   
    //Gestion de l'ajout et de l'affichage des tâches
    #[Route('/todo', name: 'todo', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        session_start();

        $todos = $this->getSessionTodos();

        if ($request->isMethod('POST')) {
            $task = $request->request->get('task');
            if (!empty($task)) {
                $todos[] = ['task' => $task, 'done' => false];
                $this->setSessionTodos($todos);
            }
        }

        return $this->render('Todo/todo.html.twig', [
            'todos' => $todos,
        ]);
    }

    //Gestion de la mise à jour de la tâche (terminée/pas terminée)
    #[Route('/todo/update/{index}', name: 'todo_update', methods: ['POST'])]
    public function update(int $index): Response
    {
        session_start();

        $todos = $this->getSessionTodos();
        if (isset($todos[$index])) {
            $todos[$index]['done'] = !$todos[$index]['done'];
            $this->setSessionTodos($todos);
        }

        return $this->redirectToRoute('todo');
    }

    //Gestion de la suppression de la tâche
    #[Route('/todo/delete/{index}', name: 'todo_delete', methods: ['POST'])]
    public function delete(int $index): Response
    {
        session_start();

        $todos = $this->getSessionTodos();
        if (isset($todos[$index])) {
            unset($todos[$index]);
            $this->setSessionTodos($todos);
        }

        return $this->redirectToRoute('todo');
    }

    private function getSessionTodos(): array
    {
        return $_SESSION['todos'] ?? [];
    }

    private function setSessionTodos(array $todos): void
    {
        $_SESSION['todos'] = $todos;
    }
}