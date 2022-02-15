<?php
declare(strict_types = 1);
namespace SchamsNet\Nagios\Middleware;

/*
 * This file is part of the TYPO3 CMS Extension "Nagios TYPO3 Monitoring"
 *
 * Author: Michael Schams <schams.net>
 * Website: https://schams.net
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TYPO3\CMS\Core\Configuration\ExtensionConfiguration;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use SchamsNet\Nagios\Controller\NagiosController;

/**
 * PSR-15 middleware for Nagios
 */
class NagiosMiddleware implements MiddlewareInterface
{
    /**
     * Extension key
     */
    private string $extensionKey = 'nagios';

    /**
     * Extension configuration object
     */
    private ExtensionConfiguration $extensionConfiguration;

    /**
     * Dispatches the request to the corresponding typoscript_rendering configuration
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // If request does match configured expected URI, pass on to next middleware
        if (!$this->isNagiosRequest($request)) {
            return $handler->handle($request);
        }

        // Process request
        $nagiosController = GeneralUtility::makeInstance(NagiosController::class);
        return $nagiosController->execute($request);
    }

    /**
     * Checks if the request is for the TYPO3 Nagios extension
     */
    private function isNagiosRequest(ServerRequestInterface $request): bool
    {
        // Extract configured URI from extension configuration (e.g. "/nagios")
        $this->extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
        $expectedUri = $this->extensionConfiguration->get($this->extensionKey, 'expectedUri');
        $expectedUri = self::sanitizeString($expectedUri);

        // Check if the request is a request for the Nagios extension
        if (preg_match('/^\/[a-zA-Z0-9\/\-\_]{3,}/', $expectedUri) && $request->getRequestTarget() === $expectedUri) {
            return true;
        }

        return false;
    }

    /**
     * Sanitize string
     */
    private static function sanitizeString(string $uri): string
    {
        // Remove trailing slashes
        $uri = preg_replace('/\/{1,}$/', '', $uri);
        // Add a slash at the start, but replace multiple slashes with one slash
        $uri = preg_replace('/\/{1,}/', '/', '/' . $uri);
        // Return a left/right trimmed string (remove white spaces)
        return trim($uri);
    }
}
