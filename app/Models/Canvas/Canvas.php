<?php

namespace App\Models\Canvas;

use User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use RuntimeException;

class Canvas
{
    /**
     * Return a list of available language codes.
     *
     * @return array
     */
    public static function availableLanguageCodes(): array
    {
        $locales = preg_grep('/^([^.])/', scandir(dirname(__DIR__, 1).'/resources/lang'));
        $translations = collect();

        foreach ($locales as $locale) {
            $translations->push($locale);
        }

        return $translations->toArray();
    }

    /**
     * Return an encoded string of app translations.
     *
     * @param $locale
     * @return string
     */
    public static function availableTranslations($locale): string
    {
        return collect(trans('canvas::app', [], $locale))->toJson();
    }

    /**
     * Return an array of available user roles.
     *
     * @return array
     */
    public static function availableRoles(): array
    {
        return [
            User::CONTRIBUTOR => 'Contributor',
            User::EDITOR => 'Editor',
            User::ADMIN => 'Admin',
        ];
    }

    /**
     * Return the configured public path url, prioritizing a subdomain.
     *
     * @return string
     */
    public static function basePath(): string
    {
        return config('blog.domain') ?? '/'.config('blog.path');
    }

    /**
     * Return the configured storage path url.
     *
     * @return string
     */
    public static function baseStoragePath(): string
    {
        return sprintf('%s/%s', config('blog.storage_path'), 'images');
    }

    /**
     * Check if a given URL is valid.
     *
     * @param string|null $url
     * @return bool
     */
    public static function isValid(?string $url): bool
    {
        return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
    }

    /**
     * Trim a given URL and return the base.
     *
     * @param string|null $url
     * @return mixed
     */
    public static function trim(?string $url)
    {
        return parse_url($url)['host'] ?? null;
    }
}
