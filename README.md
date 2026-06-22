
# AI PDF Reader

This project is a Laravel application that utilizes OpenAI embeddings for searching through PDF documents.

#Features
- Convert PDF files into text and extract relevant information.
- Search through PDF documents using natural language queries.

#Requirements
- PHP >= 8.1
- Laravel >= 9
- OpenAI API key

#Installation

1. Clone the repository.
2. Install the required dependencies via Composer.
3. Configure your OpenAI API key in the `.env` file.
4. Run the database migrations.
5. Start the Laravel development server.

# Local Demo

The project has been updated so it can run as a client demo even when an OpenAI API key is not configured.
When `OPENAI_API_KEY` is empty, the app uses local keyword/vector matching and shows the most relevant
source text. When an OpenAI key is configured, it uses OpenAI embeddings and completions.

Local demo URL:

```
http://127.0.0.1:8003
```

Windows run command:

```
run-local-demo.bat
```

Demo flow:

1. Open the homepage.
2. Use "Upload PDF" to upload and index a document.
3. Use "Search PDF" to select a PDF and ask a question.

A sample document named "Frendo AI Demo Notes" is already seeded in the local SQLite database for a quick demo.
To recreate it after a fresh migration, run:

```
php artisan db:seed --class=DemoPdfSeeder
```

Unit Testing -> (dev branch)

   example queries:
what is the employer's name in this w2?
what is the gross and net income in this W2?
what is the employer's FED ID number in this w2?
![ScreenShot Tool -20240427214151](https://github.com/nidadev/home-assign/assets/53574300/c68fc9e5-dd54-4a1b-84ba-7bd1af2ed231)


![ScreenShot Tool -20240427214022](https://github.com/nidadev/home-assign/assets/53574300/4c0fd4cd-0b61-426e-955b-2c5b8c3a2ed3)
![ScreenShot Tool -20240427215659](https://github.com/nidadev/home-assign/assets/53574300/6964f836-ea22-40a0-a10d-3aac6a519fab)
![ScreenShot Tool -20240428104854](https://github.com/nidadev/home-assign/assets/53574300/814e3677-6d96-4fca-8207-e10fb73ac5a1)
