<?php

namespace App\FileHelper;

use App\Exception\CreatePointerException;

final class File
{
    /** @var string File Name */
    public string $filename;

    /**
     * @param string $filename          File Name
     * @param string $mode              Access Type
     * @param bool|int $useIncludePath  The optional third parameter
     * @param resource $context         Resource with context
     * @throws CreatePointerException
     */
    public static function openFile(string $filename, string $mode, bool $useIncludePath =  false, $context = null)
    {
        $filePointer = fopen($filename, $mode, $useIncludePath, $context);

        if ($filePointer === false) {
            throw new CreatePointerException(sprintf('Failed to open a file "%s". ', $filename));
        }

        return $filePointer;
    }

    /**
     * @param string $path Path to file
     * @return string      Normalized Path
     */
    public static function normalizePath(string $path): string
    {
        $isWindowsShare = strpos($path, '\\\\') === 0;

        if ($isWindowsShare) {
            $path = substr($path, 2);
        }

        if (strpos('/' . $path, '/.') === false && strpos($path, '//') === false) {
            return $isWindowsShare ? "\\\\$path" : $path;
        }

        $parts = [];

        foreach (explode('/', $path) as $part) {
            if ($part === '..' && !empty($parts) && end($parts) !== '..') {
                array_pop($parts);
            } elseif ($part !== '.' && ($part !== '' || empty($parts))) {
                $parts[] = $part;
            }
        }

        $path = implode('/', $parts);

        if ($isWindowsShare) {
            $path = '\\\\' . $path;
        }

        return $path === '' ? '.' : $path;
    }
}