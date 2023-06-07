<?php

namespace App\Console\Commands\Projects;

class Extractor
{
    private const PROJECT_LINK_PATTERN = '/href="(.+\/gallery\/floorplans\/\w+\/[^\"]+)">[^<]+/iu';
    private const CANVAS_LINK_PATTERN  = '/href="(.+\/v\?key=\w+&viewMode=[^\"]+)"/u';
    private const TITLE_PATTERN        = '/<h1.*?>(.+)<\/h1>/mis';

    public static function extractProjectLinks(string $body): array
    {
        preg_match_all(static::PROJECT_LINK_PATTERN, $body, $matches);
        if (empty($matches[1])) {
            throw new \Exception('Projects are missed');
        }
        return $matches[1];
    }

    public static function extractCanvasLink(string $body): string
    {
        preg_match(static::CANVAS_LINK_PATTERN, $body, $matches);
        if (empty($matches[1])) {
            throw new \Exception('Canvas missed');
        }
        return trim($matches[1]);
    }

    public static function extractProjectTitle(string $body): string
    {
        preg_match(static::TITLE_PATTERN, $body, $matches);
        if (empty($matches[1])) {
            throw new \Exception('Title missed');
        }
        return trim($matches[1]);
    }
}
