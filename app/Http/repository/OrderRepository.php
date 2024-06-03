<?php

namespace App\Http\repository;

use App\Http\repository\RepositoryInterface\OrderRepositoryInterface;
use App\Models\Orders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Mail;

class OrderRepository implements OrderRepositoryInterface
{
    public function filter(array $criteria)
    {

        $query = Orders::query();

        foreach ($criteria as $filter => $value) {
            try {
                $criteriaClass = ucfirst($filter) . 'Criteria';
                if (!class_exists("App\\Criteria\\$criteriaClass")) {
                    $this->notifyAdmin("این فیلتر پشتیبانی نمی شود: $filter");
                    continue;
                }
                $criteriaObject = app("App\\Criteria\\$criteriaClass");
                $criteriaObject->apply($query, $value);
            } catch (Exception $e) {
                $this->notifyAdmin($e->getMessage());
                Log::error($e->getMessage());
            }
        }


        return $query->with('user')->get();
    }

    private function notifyAdmin($message)
    {
        $adminEmail = 'admin@admin.ir';
        $adminMobile = '0910000000';

        $this->sendEmail($adminEmail, 'Notification', $message);
        $this->sendSMS($adminMobile, $message);
    }

    private function sendEmail($to, $subject, $message)
    {
        $headers = "From: test@gmail.com\r\n" .
            "Reply-To: admin@admin.ir\r\n" .
            "X-Mailer: PHP/" . phpversion();
        $isMailSent = mail($to, $subject, $message, $headers);

        if ($isMailSent) {
            echo "ایمیل با موفقیت به $to ارسال شد.\n";
        } else {
            echo "ارسال ایمیل به $to ناموفق بود.\n";
        }
    }


    private function sendSMS($number, $message)
    {
        $smsGatewayUrl=env('smsGatewayUrl');
        $smsApiKey=env('smsApiKey');
        $smsData = [
            'apikey' => $smsApiKey,
            'number' => $number,
            'message' => urlencode($message)
        ];

        $response = $this->makeHttpPostRequest($smsGatewayUrl, $smsData);
        $this->handleSMSResponse($response, $number);
    }

    private function handleSMSResponse($response, $number)
    {
        if ($response === false) {
            echo "ارسال پیامک به $number ناموفق بود. هیچ پاسخی از درگاه پیامک دریافت نشد.\n";
            return;
        }

        $responseArray = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE || !isset($responseArray['success'])) {
            echo "تجزیه پاسخ درگاه پیامک برای $number ناموفق بود. پاسخ: $response\n";
            return;
        }

        if ($responseArray['success']) {
            echo "پیامک با موفقیت به $number ارسال شد.\n";
        } else {
            $errorMessage = $responseArray['error_message'] ?? 'خطای ناشناخته';
            echo "ارسال پیامک به $number ناموفق بود. خطا: $errorMessage\n";
        }
    }

    private function makeHttpPostRequest($url, $data)
    {
        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($data)
            ]
        ];

        $context = stream_context_create($options);
        return file_get_contents($url, false, $context);
    }
}
