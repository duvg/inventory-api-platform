<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\File;

use App\Service\File\FileService;
use Faker\Core\File;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\Visibility;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FileServiceTest extends TestCase
{
    /** @var FilesystemOperator|MockObject */
    private $storage;

    /** @var LoggerInterface|MockObject */
    private $logger;

    /** @var string */
    private $mediaPath;

    private FileService $fileService;

    public function setUp(): void
    {
        parent::setUp();

        $this->storage = $this->getMockBuilder(FilesystemOperator::class)->disableOriginalConstructor()->getMock();
        $this->logger = $this->getMockBuilder(LoggerInterface::class)->disableOriginalConstructor()->getMock();
        $this->mediaPath = 'https://storage.com/';
        $this->fileService = new FileService($this->storage, $this->logger, $this->mediaPath);
    }

    public function testUploadFile(): void
    {
        $uploadedFile = $this->getMockBuilder(UploadedFile::class)->disableOriginalConstructor()->getMock();
        $uploadedFile->method('getPathname')->willReturn('/tmp');
        $uploadedFile->method('guessExtension')->willReturn('png');
        $prefix = 'avatar';

        $response = $this->fileService->uploadFile($uploadedFile, $prefix, Visibility::PUBLIC);

        $this->assertIsString($response);
    }

    public function testValidateFile(): void
    {
        $uploadedFile = $this->getMockBuilder(UploadedFile::class)->disableOriginalConstructor()->getMock();
        $request = new Request([],[],[],[],['avatar' => $uploadedFile]);

        $response = $this->fileService->validateFile($request, FileService::AVATAR_INPUT_NAME);

        $this->assertInstanceOf(UploadedFile::class, $response);
    }

    public function testValidateInvalidFile(): void
    {
        $uploadedFile = $this->getMockBuilder(UploadedFile::class)->disableOriginalConstructor()->getMock();
        $request = new Request([],[],[],[],['file' => $uploadedFile]);


        $this->expectException(BadRequestHttpException::class);

        $this->fileService->validateFile($request, FileService::AVATAR_INPUT_NAME);
    }

    public function testDeleteFile(): void
    {
        $path = \sprintf('%s/%s', $this->mediaPath, 'avatar/1234.png');

        $this->storage
            ->expects($this->exactly(1))
            ->method('delete')
            ->with($path);

        $this->fileService->deleteFile($path);
    }
}