import json

def validate_jsonl(file_path):
    with open(file_path, 'r') as file:
        for line_number, line in enumerate(file, start=1):
            try:
                json.loads(line)
            except json.JSONDecodeError as e:
                print(f"Erreur ligne {line_number}: {e}")
                return
    print("Fichier JSONL valide.")

# Remplacez 'trainingData.jsonl' par le chemin de votre fichier
validate_jsonl('trainingData.jsonl')
