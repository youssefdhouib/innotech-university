<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $message = $request->input('message');
        if (!$message) {
            return response()->json(['reply' => 'Please provide a message'], 400);
        }

        $context = <<<CONTEXT
You are a helpful assistant for InnoTech University.

Here is information you must use when answering:

- InnoTech University was founded in 2025 and is a reference in technological higher education.
- Mission: Train highly qualified professionals ready to face future tech challenges.
- 15+ teachers, 98% job placement rate.
- Core Values: Innovation, Excellence, Openness, Collaboration.

🗺️ Address: 123 University Avenue, Tech City, TC 12345, France
📞 Phone: +33 1 23 45 67 89
📧 Email: contact@InnoTech-university.fr
🕘 Office Hours: Mon–Fri: 8AM–6PM, Sat: 9AM–2PM

🎓 Licence Programs:
• Génie Logiciel et IA
• Big Data et Analyse de Données
• Systèmes Embarqués et IoT
• Mécatronique
• Ingénierie & Admin. des Affaires
• Sciences des Données Industrielles

🎓 Mastère Programs:
• Génie Logiciel et DevOps
• Ingénierie Automobile & Test Logiciel
• Data & Intelligence Artificielle

📋 Pre-registration: https://InnoTech.tn/formulaires/preinscription
🏛️ Departments: Génie Logiciel, Data Science & IA, Cybersécurité, IoT, Management
👩‍🏫 Faculty: Dr. Vance, Dr. Jenkins, Dr. Chen, Pr. Chang, etc.
📅 Events: AI Hackathon (Oct 12), Career Fair (Nov 5), Sports Day (Dec 1)

Answer clearly based on this information.
If the question is unrelated, reply politely but stay on-topic.
CONTEXT;

        $messages = [
            [
                "role" => "system",
                "content" => $context
            ],
            [
                "role" => "user",
                "content" => $message
            ]
        ];

        $apiKey = env('GROQ_API_KEY');
        $url = "https://api.groq.com/openai/v1/chat/completions";

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$apiKey}",
            'Content-Type' => 'application/json'
        ])->post($url, [
            "model" => "llama-3.3-70b-versatile",
            "messages" => $messages,
            "temperature" => 0.7
        ]);

        if ($response->failed()) {
            \Log::error('Groq API error:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);
            return response()->json(['reply' => 'Could not reach Groq'], 500);
        }

        $reply = $response->json()['choices'][0]['message']['content'] ?? "Sorry, I don’t know how to answer that yet.";
        // Convert [text](url) markdown links into clickable HTML links
        $reply = preg_replace(
            '/\[(.*?)\]\((.*?)\)/',
            '<a href="$2" target="_blank" rel="noopener noreferrer">$1</a>',
            $reply
        );
        return response()->json([
            'code' => 200,
            'message' => 'Response generated successfully',
            'data' => ['reply' => $reply],
            'errors' => null
        ]);
    }
}
