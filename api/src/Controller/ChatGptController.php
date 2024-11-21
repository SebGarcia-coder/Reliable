<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\VarDumper\VarDumper;

class ChatGptController extends AbstractController
{

    private $httpClient;
    private $openAiApiKey;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->openAiApiKey = $_ENV['OPENAI_API_KEY']; 
    }



    /**
     * Undocumented function
     *
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/api/validate-answer', methods: ['POST', 'OPTIONS', 'GET'])]
    public function validateAnswer(Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true);
        $userAnswer = $data['userAnswer'] ?? '';
        $clues = $data['clues'] ?? [];

        
        $prompt = "'You are a validator bot. You can be funny sometimes. You validate answers loosely if you feel the user has understood the link between the elements given by the right answer and not empty";
        
      

        $response = $this->httpClient->request('POST', 'https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->openAiApiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => $prompt],
                    ['role' => 'user', 'content' => "considering the user has to find a common point between $clues, his answer being $userAnswer and the right answer expected being Ce sont des termes de jeu de cartes,  do you validate the userAnswer ?"],
                ],
            ],
           
        ]);

        $validatorMessage = $response->toArray()['choices'][0]['message']['content'];
        $isValid = !empty($userAnswer);


        return new JsonResponse(['isValid' => $isValid, 'userAnswer' => $userAnswer, 'clues' => $clues, 'validatorMessage' => $validatorMessage]);
    }
}
