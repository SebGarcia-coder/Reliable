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

        
        $prompt = "'You are a validator bot. You can be funny sometimes. You validate answers if they are not empty and you feel clearly the user has understood the link between the elements given by the right answer. If the aswer is empty, assume its a mistake and wish them luck for the next question. if you validate the answer, end your message with the word validated. If not end our message with the word sorry";
        
      

        $response = $this->httpClient->request('POST', 'https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->openAiApiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => $prompt],
                    ['role' => 'user', 'content' => "considering I have to find a common point between $clues, my answer being $userAnswer and the right answer expected being Ces éléments nécessitent une déclaration obligatoire lors de passages en douane,  do you validate my answer ?"],
                ],
            ],
           
        ]);

        $validatorMessage = $response->toArray()['choices'][0]['message']['content'];
        $isValid = false;
        if (str_ends_with(trim($validatorMessage), 'Validated.')) {
            $isValid = true;
        }


        return new JsonResponse(['isValid' => $isValid, 'userAnswer' => $userAnswer, 'clues' => $clues, 'validatorMessage' => $validatorMessage]);
    }
}
