<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Enum\QuestionType;
use App\Enum\SystemPromptType;

class ChatGptService
{
    private string $openAiApiKey;

    public function __construct(
        private readonly HttpClientInterface $httpClient,
    ) {
        $this->openAiApiKey = $_ENV['OPENAI_API_KEY'];
    }

    public function validateAnswerWithApi(string $systemPrompt, string $userPrompt): ?array
    {
        try {
            $response = $this->httpClient->request('POST', 'https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->openAiApiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $userPrompt],
                    ],
                ],
            ]);

            return $response->toArray();
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getSystemPromptForType(
        QuestionType $type,
    ): string {
        return match ($type) {
            QuestionType::COMMON => SystemPromptType::COMMON->value,
            QuestionType::SEQUENCE => SystemPromptType::SEQUENCE->value
        };
    }

    public function getUserPromptForType(
        QuestionType $type,
        string $userAnswer,
        string $correctAnswer,
        string $correctAnswerForSequence = ''
    ): string {
        return match ($type) {
            QuestionType::COMMON => "Ma réponse étant $userAnswer et la bonne réponse attendue étant $correctAnswer, valides-tu ma réponse ?",
            QuestionType::SEQUENCE => "Ma réponse étant $userAnswer et la bonne réponse attendue étant $correctAnswerForSequence, valides-tu ma réponse ?",
        };
    }
}
