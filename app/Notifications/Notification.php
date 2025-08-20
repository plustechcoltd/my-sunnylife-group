<?php

namespace App\Notifications;

use App\Helpers\LocalizationHelper;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification as BaseNotification;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;

class Notification extends BaseNotification implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        private readonly array $via,
        private readonly string $holder,
        private readonly string $category,
        private readonly string $action_to_receiver,
        private readonly array $data = []
    ) {
    }

    public function toMail($notifiable): bool|MailMessage
    {
        $langs = LocalizationHelper::getLang();
        $defaultLocale = collect($langs)->where('default_yn', 'y')->keys()->first()
            ?? config('app.locale', 'en');
        $lang = $notifiable->language ?? $defaultLocale;

        $holder = $this->holder;
        $category = $this->category;
        $action_to_receiver = $this->action_to_receiver;

        $template = "emails.$lang.$holder.$category.$action_to_receiver";
        if (!View::exists($template)) {
            $lang = $defaultLocale;
            $fallback_template = "emails.$lang.$holder.$category.$action_to_receiver";
            $message = "Template $template is not exist. Falling back to $fallback_template";
            Log::error($message);

            $template = $fallback_template;
            if (!View::exists($template)) {
                $message = "Template $template is not exist.";
                Log::error($message);
                throw new Exception($message);
            }
        }

        $mailObjects = collect($this->data['mail']['mail_objects'])->mapWithKeys(function ($object, $key) {
            if ($object instanceof Model) {
                $key = Str::snake(class_basename($object));
                $relatedData = $object->toArray();
                return [$key => $relatedData];
            }
            return [$key => $object];
        })->toArray();

        $flattenMailObjects = Arr::dot($mailObjects);

        return (new MailMessage())
            ->subject(__("mail_subject.$holder.$category.$action_to_receiver", $flattenMailObjects))
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->replyTo(config('mail.reply_to.address'), config('mail.reply_to.name'))
            ->cc($this->data['mail']['cc'] ?? [])
            ->bcc($this->data['mail']['bcc'] ?? [])
            ->view($template, $mailObjects);
    }

    public function via(): array
    {
        return $this->via;
    }

    public function toWeb($notifiable)
    {
        return new NotificationDataBuilder(
            notifiable: $notifiable,
            holder: $this->holder,
            category: $this->category,
            action_to_receiver: $this->action_to_receiver,
            data: $this->data['web']
        );
    }
}
