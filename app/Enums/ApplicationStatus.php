<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case DRAFT = 'draft';
    case SUBMITTED = 'submitted';
    case PAID = 'paid';
    case SHORTLISTED = 'shortlisted';
    case REJECTED = 'rejected';
}
