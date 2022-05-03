<?php

declare(strict_types=1);

namespace Easy\Ecommerce\Contracts;

/**
 * @FileUploadInterface
 */
interface FileUploadInterface
{
    /**
     * media root directory
     */
    public const MEDIA_ROOT_DIRECTORY = 'app/public';
    /**
     * image root directory
     */
    public const IMAGE_ROOT_DIRECTORY = 'image';
    /**
     * Fallback placeholder
     */
    public const NO_FILE_PLACEHOLDER_PATH = 'media/image/noImage.png';

    /**
     * createResizedImagePath
     *
     * @param array $files
     * @param string $retrievePath
     * @param int $height
     * @return array
     */
    public function createResizedImagePath(array $files, string $retrievePath, int $height): array;

    /**
     * updateResizedImagePath
     *
     * @param array $files
     * @param string $path
     * @param int $height
     * @return array
     */
    public function updateResizedImagePath(array $files, string $path, int $height): array;

    /**
     * deleteFileFromDirectory
     *
     * @param string $path
     * @return bool
     */
    public function deleteFileFromDirectory(string $path): bool;
}
