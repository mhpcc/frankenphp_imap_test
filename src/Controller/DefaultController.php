<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Webklex\PHPIMAP\Client;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default')]
    public function index(Request $request): Response
    {
        if ($request->getMethod() === 'GET') {
            $html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP IMAP</title>
</head>
<body>
    <h1>PHP IMAP</h1>
    <form method="POST">
        <label for="host">Host</label>
        <input type="text" name="host" id="host" required>
        <br>
        <label for="username">Username</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit">Get Folders</button>
    </form>
</body>
</html>
HTML;

            return new Response($html);
        }
        $client = new Client([
            'host'          => $request->request->get('host'),
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => false,
            'username'      => $request->request->get('username'),
            'password'      => $request->request->get('password'),
        ]);
        
        return new JsonResponse($client->getFolders());
    }
}