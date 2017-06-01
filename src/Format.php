<?php

namespace CrazyFactory\Utils;


class Format
{
    /**
     * Returns a seconds-integer into a time elapsed string
     * e.g. 02m 14s, 01h 00m 00s, 22s, etc.
     *
     * @param int $time_in_seconds
     *
     * @return string
     */
    public static function timeElapsed(?int $time_in_seconds): string
    {
        if ($time_in_seconds === null) {
            return "";
        }

        $hours = $minutes = 0;
        if ($time_in_seconds >= 3600) {
            $hours = floor($time_in_seconds / 3600);
            $time_in_seconds -= $hours * 3600;
        }

        if ($time_in_seconds >= 60) {
            $minutes = floor($time_in_seconds / 60);
            $time_in_seconds -= $minutes * 60;
        }

        $seconds = $time_in_seconds;

        if ($hours) {
            return sprintf('%02dh %02dm %02ds', $hours, $minutes, $seconds);
        }
        else if ($minutes) {
            return sprintf('%02dm %02ds', $minutes, $seconds);
        }

        return sprintf('%02ds', $seconds);
    }
}
