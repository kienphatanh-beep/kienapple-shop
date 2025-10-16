<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ChatGPTService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
    }

    public function ask(string $prompt): string
    {
        if (empty($this->apiKey)) {
            return '❌ Thiếu API Key, vui lòng kiểm tra file .env (OPENAI_API_KEY).';
        }

        try {
            $response = Http::timeout(15) // tránh treo request
                ->withHeaders([
                    'Authorization' => "Bearer {$this->apiKey}",
                    'Content-Type' => 'application/json',
                ])
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini', // bạn có thể đổi sang 'gpt-5-mini' nếu muốn
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'Bạn là trợ lý AI thông minh của cửa hàng Kiên Apple, chuyên hỗ trợ khách hàng tìm kiếm, tư vấn và mua sản phẩm Apple.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ],
                    ],
                    'temperature' => 0.7,
                ]);

            if ($response->failed()) {
                return '⚠️ Không thể kết nối tới ChatGPT API, vui lòng thử lại.';
            }

            return $response->json('choices.0.message.content') ?? 'Xin lỗi, tôi chưa hiểu rõ yêu cầu của bạn 😅';
        } catch (\Throwable $e) {
            return '❌ Lỗi hệ thống: ' . $e->getMessage();
        }
    }
}
