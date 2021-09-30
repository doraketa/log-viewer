<?php

namespace App\FileHelper;

use App\Exception\CreatePointerException;

final class File
{
    /** @var string File Name */
    public string $filename;

    /**
     * Method for safely opening a file
     *
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
}
