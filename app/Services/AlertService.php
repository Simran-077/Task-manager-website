<?php

namespace App\Services;

use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Mail;
use App\Mail\TaskAssignedMail;
use Illuminate\Support\Facades\Log;

class AlertService
{
    /**
     * Send notifications based on user preferences.
     */
    public static function sendTaskAlert(User $user, Task $task, string $type = 'assigned')
    {
        // 1. Email Notification
        if ($user->notify_email && $user->email) {
            try {
                Mail::to($user->email)->send(new TaskAssignedMail($task));
                Log::info("Email alert sent to {$user->email} for task: {$task->title}");
            } catch (\Exception $e) {
                Log::error("Failed to send email to {$user->email}: " . $e->getMessage());
            }
        }

        // 2. SMS Notification (Using Log as placeholder if no API key)
        if ($user->notify_sms && $user->phone) {
            // In a real app, you would use Twilio or Nexmo here:
            // Twilio::message($user->phone, "New Task: {$task->title}. Deadline: {$task->deadline}");
            Log::info("SMS ALERT (Simulated) to {$user->phone}: New Task '{$task->title}' assigned.");
        }

        // 3. Phone Call Alert (Simulated Ring)
        if ($user->notify_call && $user->phone) {
            // Example Twilio Call:
            // Twilio::call($user->phone, "You have a new urgent task: {$task->title}");
            Log::info("PHONE CALL ALERT (Simulated) to {$user->phone}: Calling user for task '{$task->title}'");
        }
    }
}
