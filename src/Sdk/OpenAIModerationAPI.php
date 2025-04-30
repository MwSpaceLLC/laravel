<?php

namespace MwSpace\Laravel\Sdk;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class OpenAIModerationAPI
{
    /**
     * URL per le completions di OpenAI
     *
     * @var string
     */
    protected $apiUrl = 'https://api.openai.com/v1/chat/completions';

    /**
     * Chiave API di OpenAI
     *
     * @var string
     */
    protected $apiKey;

    /**
     * Modello di OpenAI da utilizzare
     *
     * @var string
     */
    protected $model;

    /**
     * Open AI Results
     */
    protected $results;

    /**
     * Costruttore del servizio
     */
    public function __construct()
    {
        $this->apiKey = config('services.openai.key', env('OPENAI_API_KEY'));
        $this->model = config('services.openai.model', 'gpt-4.1-nano');
    }

    /**
     * Verifica se un form di contatto è appropriato o spam
     *
     * @param array $formData I dati del form da verificare
     * @return array Risultato della verifica
     * @throws Exception In caso di errore nella richiesta
     */
    public function validateContactForm(array $formData): array
    {

        // Crea il prompt per OpenAI
        $systemPrompt = "Sei un esperto validatore di form di contatto aziendali. ";
        $systemPrompt .= "Il tuo compito è determinare se una richiesta è legittima o spam. ";
        $systemPrompt .= "Una richiesta legittima contiene informazioni coerenti e pertinenti. ";
        $systemPrompt .= "Le richieste spam spesso contengono messaggi generici. ";
        $systemPrompt .= "Le richieste spam spesso possono includere link sospetti, riferimenti a prodotti o servizi non correlati, o avere un tono inappropriato. ";
        $systemPrompt .= "Valuta ogni richiesta in base a: pertinenza, coerenza dei dati, professionalità e legittimità. ";
        $systemPrompt .= "Messaggi che contengono solo parole come 'test', 'prova', 'verifica' senza ulteriori dettagli devono essere classificati come spam o non legittimi.";

        // Formatta i dati del form per il prompt
        $formContent = "Nome: " . ($formData['name'] ?? 'Non specificato') . "\n";
        $formContent .= "Email: " . ($formData['email'] ?? 'Non specificata') . "\n";
        $formContent .= "Telefono: " . ($formData['tel'] ?? 'Non specificato') . "\n";
        $formContent .= "Messaggio: " . ($formData['message'] ?? 'Non specificato');

        // Definizione dello schema di risposta strutturato
        $responseFormat = [
            "name" => "spam_check",
            "schema" => [
                "type" => "object",
                "properties" => [
                    "is_spam" => [
                        "type" => "boolean",
                        "description" => "Indicates whether the content is considered spam."
                    ],
                    "reason" => [
                        "type" => "string",
                        "description" => "The reason why the content is identified as spam or not."
                    ]
                ],
                "required" => ["is_spam", "reason"],
                "additionalProperties" => false
            ],
            "strict" => true
        ];

        try {
            // Preparazione dei dati da inviare
            $data = [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'developer',
                        'content' => $systemPrompt
                    ],
                    [
                        'role' => 'user',
                        'content' => "Valuta se questa richiesta di contatto è legittima o spam: \n\n" . $formContent
                    ]
                ],
                'response_format' => ['type' => 'json_schema', 'json_schema' => $responseFormat],
                'temperature' => 0.0, // Minore temperatura per risposte più deterministiche
                'max_completion_tokens' => 500,
                'store' => false
            ];

            // Esegui la richiesta HTTP utilizzando Laravel HTTP Client
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, $data);

            // Verifica errori nella risposta
            if (!$response->successful()) {
                $errorMsg = $response->json('error.message') ?? 'Errore sconosciuto';
                Log::error('OpenAI API Error', [
                    'status' => $response->status(),
                    'error' => $errorMsg
                ]);
                throw new Exception('Errore API OpenAI: ' . $errorMsg);
            }

            $result = $response->json();

            $content = $result['choices'][0]['message']['content'] ?? '{}';

            // Decodifica la risposta JSON
            $this->results = json_decode($content, true);

            if (!is_array($this->results) || !isset($this->results['is_spam'])) {
                Log::error('OpenAI Response Format Error', [
                    'content' => $content
                ]);
                throw new Exception('Errore nel formato della risposta');
            }

            return $this->results;

        } catch (Exception $e) {
            Log::error('OpenAI Form Validator Exception', [
                'message' => $e->getMessage(),
                'form_data' => array_map(function ($value) {
                    return is_string($value) ? (strlen($value) > 50 ? substr($value, 0, 50) . '...' : $value) : $value;
                }, $formData)
            ]);

            // In caso di errore, consideriamo la richiesta come potenzialmente spam per sicurezza
            return [
                'is_spam' => true,
                'reason' => 'Impossibile verificare - errore nel sistema di validazione'
            ];
        }
    }

    /**
     * Metodo semplificato che restituisce solo un booleano
     *
     * @param array $formData I dati del form da verificare
     * @return bool True se il form è considerato spam
     */
    public function isSpam(array $formData): bool
    {
        try {
            $result = $this->validateContactForm($formData);
            return $result['is_spam'] ?? true;
        } catch (Exception $e) {
            return true; // In caso di errore, considera spam per sicurezza
        }
    }

    public function getResults()
    {
        return $this->results;
    }
}
