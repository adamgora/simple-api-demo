<?php
declare(strict_types=1);

namespace App\Service\FileSystemAdapter;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;

class LocalFilesystemAdapter implements FilesystemAdapterInterface
{
    private string $storagePath;

    public function __construct(ContainerBagInterface $containerBag)
    {
        $this->containerBag = $containerBag;
        $this->storagePath = $containerBag->get('kernel.project_dir') . '/var/storage';
    }

    public function open(string $name)
    {
        return fopen($this->storagePath . DIRECTORY_SEPARATOR . $name, 'wb');
    }

    public function close($handle)
    {
        return fclose($handle);
    }
}