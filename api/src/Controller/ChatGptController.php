<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\QuestionRepository;
use App\Enum\QuestionType;
use App\Service\ChatGptService;

class ChatGptController extends AbstractController
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly ChatGptService $chatGptService,
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
        $userAnswer = strtolower($data['userAnswer'] ?? '');
        $questionId = $data['questionId'] ?? null;
        $currentPoints = $data['currentPoints'] ?? 0;
        $correctAnswer = strtolower($this->questionRepository->find($questionId)->getAnswer());
        $cluesArray = $this->questionRepository->find($questionId)->getClues();
        $correctAnswerForSequence = strtolower($cluesArray[3]);
        $questionType = $this->questionRepository->find($questionId)->getType();

        $validator = Validation::createValidator();

        $violations = $validator->validate($userAnswer, [
            new Assert\Length([
                'max' => 100,
                'maxMessage' => 'Answer cannot exceed 100 characters.',
            ]),
            new Assert\Regex([
                'pattern' => '/^[\p{L}\p{N}\s]+$/u',
                'message' => 'Only alphanumeric characters, accented letters, and spaces are allowed.',
            ]),
        ]);

        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[] = $violation->getMessage();
            }
            return new JsonResponse(['errors' => $errors], 400);
        }

        $type = QuestionType::from($questionType);

        $clueString = implode(", ", $cluesArray);

        $systemPrompt = $this->chatGptService->getSystemPromptForType($type);
        $userPrompt = $this->chatGptService->getUserPromptForType($type, $userAnswer, $correctAnswer, $correctAnswerForSequence);

        $response = $this->chatGptService->validateAnswerWithApi($systemPrompt, $userPrompt);
        if (!$response) {
            return new JsonResponse(['error' => 'Failed to validate answer'], 500);
        }

        $validatorMessage = $response['choices'][0]['message']['content'];
        $isValid = true;
        if (str_ends_with(trim($validatorMessage), 'Désolé !')) {
            $isValid = false;
        }

        return new JsonResponse(['isValid' => $isValid, 'validatorMessage' => $validatorMessage, 'correctAnswer' => $correctAnswer, 'questionType' => $questionType]);
    }
}

// if ($type === QuestionType::COMMON) {
//     $prompt = "Tu es un bot validateur d'un jeu de quiz où il s'agit pour le joueur de trouver le lien entre des indices. Tu es marrant. Tu ne valides pas les réponses vides. Tu es assez tolérant pour les réponses trop vagues ou générales. Tu regardes les indices. Le bon lien entre les indices est celui de la bonne réponse. Tu compares la réponse utilisateur avec la bonne réponse et tu décides de valider ou pas. Si tu ne valides pas, finis ton message par le mot 'Désolé !'";
//     $response = $this->httpClient->request('POST', 'https://api.openai.com/v1/chat/completions', [
//         'headers' => [
//             'Authorization' => 'Bearer ' . $this->openAiApiKey,
//             'Content-Type' => 'application/json',
//         ],
//         'json' => [
//             'model' => 'gpt-4o-mini',
//             'messages' => [
//                 ['role' => 'system', 'content' => $prompt],
//                 ['role' => 'user', 'content' => "ma réponse étant $userAnswer et la bonne réponse attendue étant $correctAnswer, valides-tu ma réponse ? Si $correctAnswer énumère plusieurs noms d'artistes ou titres d'oeuvres, n'en tiens pas compte dans la validation"],
//                 // ['role' => 'user', 'content' => "  Indices: $clueString. Réponse utilisateur: $userAnswer. La bonne réponse est : $correctAnswer .Valides-tu ?"],
//             ],
//         ],

//     ]);
// } else {
//     $prompt = "Tu es un bot validateur d'un jeu de quiz.. Tu es marrant. Tu ne valides pas les réponses vides. Si tu décides de ne pas valider, tu termines ta réponse par 'Désolé ! '";
//     $response = $this->httpClient->request('POST', 'https://api.openai.com/v1/chat/completions', [
//         'headers' => [
//             'Authorization' => 'Bearer ' . $this->openAiApiKey,
//             'Content-Type' => 'application/json',
//         ],
//         'json' => [
//             'model' => 'gpt-4o-mini',
//             'messages' => [
//                 ['role' => 'system', 'content' => $prompt],
//                 ['role' => 'user', 'content' => "ma réponse étant $userAnswer et la bonne réponse attendue étant $correctAnswerForSequence, valides-tu ma réponse ?"],

//             ],
//         ],

//     ]);
// }
