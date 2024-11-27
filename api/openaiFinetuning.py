from openai import OpenAI
client = OpenAI()

client.fine_tuning.jobs.create(
  training_file="file-5LSwAXwumrTfMTu3G511fk",
  model="gpt-4o-mini-2024-07-18"
)