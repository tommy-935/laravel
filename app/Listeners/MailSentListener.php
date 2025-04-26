<?php
namespace App\Listeners;

use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;
use App\Models\EmailLogs;

class MailSentListener
{
    public function handle(MessageSent $event)
    {
        // 获取邮件的主题和内容
        $message = $event->message;
        $subject = $message->getSubject();
        $body = $message->getHtmlBody();
        $uid = auth()->id ?? 0;

        // 获取邮件的收件人
        $toEmail = implode(', ', array_map(function ($address) {
            return $address->getAddress();
        }, $message->getTo()));

        // 保存邮件日志到数据库
        EmailLogs::create([
            'subject' => $subject,
            'body' => $body,
            'email' => $toEmail,
            'status' => 1,
            'created_by' => $uid,
            'updated_by' => $uid,
        ]);
        
        // 可选: 记录日志
        // Log::info("邮件已发送: {$subject}, 收件人: {$toEmail}");
    }
}
