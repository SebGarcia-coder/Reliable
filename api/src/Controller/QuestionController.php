<?php

namespace App\Controller;

use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class QuestionController extends AbstractController
{
    #[Route('/question', name: 'app_question')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/QuestionController.php',
        ]);
    }

    #[Route('/api/questions/random', name: 'random_question', methods: ['GET'])]
    public function getRandomQuestion(Request $request, QuestionRepository $repository): JsonResponse
    {
        $type = $request->query->get('type');
        // dd($type);
        $question = $repository->findOneRandomQuestionByType($type);

        if (!$question) {
            return new JsonResponse(['error' => 'No questions available'], 404);
        }

        return new JsonResponse([
            'questionId' => $question->getId(),
            'firstClue' => $question->getClues()[0],
        ]);
    }

    #[Route('/api/questions/{id}/clue/{index}', name: 'next_clue', methods: ['GET'])]
    public function getNextClue(int $id, int $index, QuestionRepository $repository): JsonResponse
    {
        $question = $repository->find($id);

        if (!$question || !isset($question->getClues()[$index])) {
            return new JsonResponse(['error' => 'Clue not found'], 404);
        }

        $clues = $question->getClues();

        return new JsonResponse([
            'clue' => $clues[$index],
            'isLastClue' => $index === count($clues) - 1,
        ]);
    }

    #[Route('/api/questions/{id}', name: 'all_clues', methods: ['GET'])]
    public function getAllClues(int $id, QuestionRepository $repository): JsonResponse
    {
        $question = $repository->find($id);

        if (!$question) {
            return new JsonResponse(['error' => 'Clue not found'], 404);
        }

        $clues = $question->getClues();
        if (!$clues) {
            return new JsonResponse(['error' => 'No clues found'], 404);
        }

        return new JsonResponse([
            'allClues' => $clues,
            'test' => 'test'
        ]);
    }

    #[Route('/api/questions/{id}/validate', name: 'validate_answer', methods: ['POST'])]
    public function validateAnswer(int $id, Request $request, QuestionRepository $repository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $userAnswer = $data['userAnswer'];
        $cluesUsed = $data['cluesUsed'];

        $question = $repository->find($id);
        if (!$question) {
            return new JsonResponse(['error' => 'Question not found'], 404);
        }

        $isCorrect = strtolower(trim($userAnswer)) === strtolower(trim($question->getAnswer()));

        return new JsonResponse([
            'isCorrect' => $isCorrect,
            'message' => $isCorrect ? 'Correct!' : 'Incorrect. The answer is '.$question->getAnswer(),
            'score' => $isCorrect ? max(1, 5 - $cluesUsed) : 0,
        ]);
    }
}
