<?php

namespace App\Constants;

class PortalStatusConstants
{
    const APPLICATION = 'application';
    const CANDIDATE_ONBOARDING = 'on-boarding';
    const VOTING = 'voting';
    const FEED = 'feed';

    const ACTIVE = 1;
    const INACTIVE = 0;

    const ACTIVE_STATE = [self::ACTIVE, self::INACTIVE];
    const PORTAL_STATE = [self::APPLICATION, self::CANDIDATE_ONBOARDING, self::VOTING, self::FEED];
}
