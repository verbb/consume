<?php
namespace verbb\consume\helpers;

use GuzzleHttp\Exception\RequestException;

class ExceptionHelper
{
    // Constants
    // =========================================================================

    private const MAX_SUMMARY_LENGTH = 200;


    // Static Methods
    // =========================================================================

    /**
     * Returns bounded diagnostic metadata without copying exception messages, request URLs, or response bodies.
     */
    public static function getSafeSummary(object $exception): string
    {
        $summary = $exception::class;

        // Anonymous class names include the defining file and line after a null byte.
        if (str_contains($summary, '@anonymous') || str_contains($summary, "\0")) {
            $summary = get_parent_class($exception) ?: 'Anonymous exception';
        }

        if ($exception instanceof RequestException && ($response = $exception->getResponse())) {
            $summary .= ' (HTTP ' . $response->getStatusCode() . ')';
        }

        return substr($summary, 0, self::MAX_SUMMARY_LENGTH);
    }
}
