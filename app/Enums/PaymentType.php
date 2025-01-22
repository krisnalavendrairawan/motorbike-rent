<?php

namespace App\Enums;

enum PaymentType: string
{
    case Cash = 'cash';
    case Transfer = 'transfer';
    case Qris = 'qris';
}
