<?php

namespace App\Enums;

use InvalidArgumentException;

class TaskStatus
{
    const TODO = 'Todo';
    const IN_PROGRESS = 'InProgress';
    const DONE = 'Done';

    /**
     * @param string $status
     * @return string
     */
    public static function valueOf(string $status): string
    {
        if (!in_array($status, [self::TODO, self::IN_PROGRESS, self::DONE])) {
            throw new InvalidArgumentException("Invalid task status: {$status}");
        }

        return $status;
    }
}