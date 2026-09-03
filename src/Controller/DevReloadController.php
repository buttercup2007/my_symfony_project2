<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Attribute\Route;

class DevReloadController
{
	#[Route('/_dev/reload', name: 'dev_reload', methods: ['GET'])]
	public function __invoke(KernelInterface $kernel): JsonResponse
	{
		if ($kernel->getEnvironment() !== 'dev') {
			return new JsonResponse(null, 404);
		}

		$files = [];
		$projectDirectory = dirname(__DIR__, 2);

		foreach (['assets', 'config', 'src', 'templates'] as $directory) {
			$path = $projectDirectory . DIRECTORY_SEPARATOR . $directory;
			$iterator = new \RecursiveIteratorIterator(
				new \RecursiveDirectoryIterator($path, \FilesystemIterator::SKIP_DOTS)
			);

			foreach ($iterator as $file) {
				if ($file->isFile()) {
					$files[$file->getPathname()] = $file->getMTime() . ':' . $file->getSize();
				}
			}
		}

		ksort($files);

		return new JsonResponse([
			'signature' => hash('sha256', json_encode($files, JSON_THROW_ON_ERROR)),
		]);
	}
}