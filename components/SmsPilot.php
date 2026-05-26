<?php

namespace app\components;

use Yii;
use yii\base\Component;

class SmsPilot extends Component
{
    private $apiKey = 'XXXXXXXX-XXXX-XXXX-XXXX-XXXXXXXXXXXX'; // Тестовый ключ эмулятора
    private $apiUrl = 'https://smspilot.ru/api.php';
    
    public function send($phone, $message)
    {
        // Очищаем номер телефона
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($phone) === 10) {
            $phone = '7' . $phone;
        } elseif (strlen($phone) === 11 && $phone[0] === '8') {
            $phone = '7' . substr($phone, 1);
        }
        
        $data = [
            'apikey' => $this->apiKey,
            'to' => $phone,
            'text' => $message,
            'from' => 'INFO',
            'format' => 'json',
        ];
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        // Логируем для отладки
        Yii::info("SMS отправка на {$phone}: {$message}", 'sms');
        Yii::info("Ответ: {$response}", 'sms');
        
        return $httpCode === 200;
    }
}