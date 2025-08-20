<?php

namespace App\Traits;

use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

trait ModelNotifiableTrait
{
    public function getRedirectUrlAttribute()
    {
        return $this->route_name ? route($this->route_name, $this->route_data) : '';
    }

    public function getMessageAttribute()
    {
        $relatedData = $this->simplifyNotificationObjects();
        
        $translationKey = "notification.{$this->category_type}.{$this->type}";
        
        $replacements = Arr::dot($relatedData);
        
        return Lang::get($translationKey, $replacements);
    }

    public function simplifyNotificationObjects()
    {
        return $this->notificationObjects->mapWithKeys(function ($object) {
            $key = Str::snake(class_basename($object->record_model));
            $relatedData = $object->loadedModel ? $object->loadedModel->toArray() : null;
            return [$key => $relatedData];
        });
    }
}
