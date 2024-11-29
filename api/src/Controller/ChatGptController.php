<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\VarDumper\VarDumper;
use App\Repository\QuestionRepository;

class ChatGptController extends AbstractController
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly QuestionRepository $questionRepository,
    ) {
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
        $questionId = $data['questionId'] ?? null;
        $currentPoints = $data['currentPoints'] ?? 0;
        $correctAnswer = $this->questionRepository->find($questionId)->getAnswer();
        $cluesArray = $this->questionRepository->find($questionId)->getClues();

        $clueString = implode(", ", $cluesArray);
        


        // $prompt = "Tu es un bot validateur d'un jeu de quiz où il s'agit pour le joueur de trouver le lien entre des indices. Tu ne dois jamais valider une réponse vide. Tu es drôle et sarcastique.  ";
        $prompt = "Tu es un bot validateur d'un jeu de quiz où il s'agit pour le joueur de trouver le lien entre des indices. Tu es marrant. Tu ne valides pas les réponses vides. Tu es assez tolérant pour les réponses trop vagues ou générales. Tu regardes les indices. Le bon lien entre les indices est celui de la bonne réponse. Tu compares la réponse utilisateur avec la bonne réponse et tu décides de valider ou pas. Si tu ne valides pas, finis ton message par le mot 'Désolé !'";




        $response = $this->httpClient->request('POST', 'https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->openAiApiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'system', 'content' => $prompt],
                    ['role' => 'user', 'content' => "ma réponse étant $userAnswer et la bonne réponse attendue étant $correctAnswer, valides-tu ma réponse ? Si $correctAnswer énumère plusieurs noms d'artistes ou titres d'oeuvres, n'en tiens pas compte dans la validation"],
                    // ['role' => 'user', 'content' => "  Indices: $clueString. Réponse utilisateur: $userAnswer. La bonne réponse est : $correctAnswer .Valides-tu ?"],
                ],
            ],

        ]);

        $validatorMessage = $response->toArray()['choices'][0]['message']['content'];
        $isValid = true;
        if (str_ends_with(trim($validatorMessage), 'Désolé !')) {
            $isValid = false;
        }


        return new JsonResponse(['isValid' => $isValid, 'validatorMessage' => $validatorMessage, 'correctAnswer' => $correctAnswer]);
    }
}
