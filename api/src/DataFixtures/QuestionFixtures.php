<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Question;

class QuestionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
    $jsonFile = __DIR__ . '/questions.json';

    $jsonData = json_decode(file_get_contents($jsonFile), true);

    if ($jsonData === null) {
        throw new \Exception('Invalid JSON format or file not found.');
    }

    foreach ($jsonData['questions'] as $questionData) {
        if (!isset($questionData['clues'], $questionData['type'], $questionData['answer'])) {
            throw new \Exception('Missing keys in question data.');
        }

        $question = new Question();
        $question->setType($questionData['type']);
        $question->setClues($questionData['clues']);
        $question->setAnswer($questionData['answer']);

        $manager->persist($question);
    }

    $manager->flush();
    }
}
