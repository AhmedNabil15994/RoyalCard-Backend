<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Notification\Repositories\Dashboard\NotificationRepository as Notification;
use Modules\Notification\Traits\SendNotificationTrait as SendNotification;
use Tocaan\FcmFirebase\Facades\FcmFirebase;

class SendScheduledNotifications extends Command
{
    use SendNotification;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for sending notifications to customers.';

    /**
     * Execute the console command.
     *
     * @return int
     */

    public $notification;

    public function __construct(Notification $notification)
    {
        parent::__construct();
        $this->notification = $notification;
    }

    public function handle()
    {
        $notifications = $this->notification->getNotifications();
        if(count($notifications)){
            $tokens = $this->notification->getAllFcmTokens();
            $tokensArr = [];
            if (count($tokens)) {
                $data['type'] = 'general';
                $data['id'] = -1;
                foreach($tokens as $key => $token){
                    $tokensArr[] = $token->firebase_token;
                }
            }

            foreach ($notifications as $notification){
                $data['title']= [
                    'ar'    =>  $notification->getTranslations('title')['ar'],
                    'en'    =>  $notification->getTranslations('title')['en'] ?? ''
                ];
                $data['description'] = [
                    'ar'    =>  $notification->getTranslations('body')['ar'],
                    'en'    =>  $notification->getTranslations('body')['en'] ?? ''
                ];
                FcmFirebase::sendToAllDevices($data);
                $notification->is_sent = 1;
                $notification->save();
            }
        }
    }
}
