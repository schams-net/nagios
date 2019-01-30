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
     *
     * @access private
     * @var string
     */
    private $extensionKey = 'nagios';

    /**
     * Extension configuration object
     *
     * @access private
     * @var ExtensionConfiguration;
     */
    private $extensionConfiguration;

    /**
     * Dispatches the request to the corresponding typoscript_rendering configuration
     *
     * @param ServerRequestInterface $request Server request interface
     * @param RequestHandlerInterface $handler Request handler interface
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // If request does match configured expected URI, pass on to next middleware
        if (!$this->isNagiosRequest($request)) {
            return $handler->handle($request);
        }

        // Process request
        $nagiosController = GeneralUtility::makeInstance(NagiosController::class);
        $nagiosController->setServerRequest($request);
        return $nagiosController->execute($response);
    }

    /**
     * Checks if the request is for the TYPO3 Nagios extension
     *
     * @access private
     * @param ServerRequestInterface $request PSR-7 server request interface
     * @return bool
     */
    private function isNagiosRequest(ServerRequestInterface $request): bool
    {
        /** @var NormalizedParams $normalizedParams */
        $normalizedParams = $request->getAttribute('normalizedParams');
        $requestUri = self::sanitizeString($normalizedParams->getRequestUri());

        // Extract configured URI from extension configuration (e.g. "/nagios")
        $this->extensionConfiguration = GeneralUtility::makeInstance(ExtensionConfiguration::class);
        $expectedUri = $this->extensionConfiguration->get($this->extensionKey, 'expectedUri');
        $expectedUri = self::sanitizeString($expectedUri);

        if (preg_match('/^\/[a-zA-Z0-9\/]{3,}/', $expectedUri) && $requestUri === $expectedUri) {
            return true;
        }

        return false;
    }

    /**
     * Sanitize string
     *
     * @access private
     * @param string $uri Uniform resource identifier (URI) to sanitize
     * @return string
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
