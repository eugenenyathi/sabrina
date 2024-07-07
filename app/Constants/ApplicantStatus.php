<?php

namespace App\Constants;

class ApplicantStatus
{
    const WAITING = 'waiting';
    const APPROVED  = 'approved';
    const DECLINED = 'declined';

    const STATUS = [self::WAITING, self::APPROVED, self::DECLINED];
}
