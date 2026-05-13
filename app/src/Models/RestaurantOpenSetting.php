<?php

namespace App\Models;

use App\Core\Model;

class RestaurantOpenSetting extends Model
{
    protected $table = 'restaurant_open_setting';

    public function updateOpenSetting($restaurantId, $day, $isOpen, $startTime, $endTime)
    {
        return $this->updateOrCreate(
            [
                'day' => $day,
                'restaurant_setting_id' => $restaurantId
            ],
            [
                'is_open' => $isOpen,
                'start_time' => $startTime,
                'end_time' => $endTime
            ]
        );
    }

    public function getOpenSettings($restaurantId)
    {
        $settings = $this->where('restaurant_setting_id', $restaurantId);
        $mapped = [];
        foreach ($settings as $setting) {
            $mapped[$setting->day] = $setting;
        }
        return $mapped;
    }
}
