<?php
declare(strict_types=1);

namespace App\Service\FileSystemAdapter;

interface FilesystemAdapterInterface
{
    public function open(string $name);
    public function close($handle);
}