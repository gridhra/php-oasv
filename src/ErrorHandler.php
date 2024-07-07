<?php

namespace Yiegle\Oasv;

use League\OpenAPIValidation\PSR7\Exception\ValidationFailed;
use League\OpenAPIValidation\Schema\Exception\KeywordMismatch;

final class ErrorHandler
{
    public function handle(\Exception $exception): void
    {
        if ($exception instanceof ValidationFailed) {
            $this->echoErrorDetail($exception);
        }

        throw $exception;
    }

    /**
     * output error detail
     * TODO: echo -> logger
     */
    private function echoErrorDetail(ValidationFailed $validationFailed): void
    {
        $previousException = $validationFailed->getPrevious();
        if ($previousException instanceof KeywordMismatch) {
            $chain = $previousException->dataBreadCrumb()->buildChain();

            $breadCrumbMessage = 'breadcrumbs as right: ' . json_encode($previousException->dataBreadCrumb()->buildChain()) . PHP_EOL;
            $mismatchedKeyNameMessage = 'mismatched key name is: ' . json_encode($chain[array_key_last($chain)]) . PHP_EOL;

            echo "\033[31m{$breadCrumbMessage}\033[0m"; // ANSI escape sequences used for colorizing the output
            echo "\033[31m{$mismatchedKeyNameMessage}\033[0m";
            echo PHP_EOL;
        }
    }
}
