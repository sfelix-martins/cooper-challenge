<?php

namespace App\Models;

class OrderStatus
{
    const PENDING_SHIPPING = 'pending_shipping';

    const SENT = 'sent';

    const DELIVERED = 'delivered';

    const ALL = [
        self::PENDING_SHIPPING => self::PENDING_SHIPPING,
        self::SENT => self::SENT,
        self::DELIVERED => self::DELIVERED,
    ];

    const ALL_AS_STRING = self::PENDING_SHIPPING.','.self::SENT.','.self::DELIVERED;

    public static $statusMapping = [
        OrderStatus::PENDING_SHIPPING => 'Entrega Pendente',
        OrderStatus::SENT => 'Enviado',
        OrderStatus::DELIVERED => 'Entregue',
    ];

    public static function displayStatuses()
    {
        $display = [];
        foreach (self::ALL as $key => $value) {
            $display[$key] = self::$statusMapping[$value];
        }

        return $display;
    }
}
