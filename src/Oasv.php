<?php

namespace Yiegle\Oasv;

use Yiegle\Oasv\ErrorHandler;
use League\OpenAPIValidation\PSR7\OperationAddress;
use League\OpenAPIValidation\PSR7\ValidatorBuilder;
use League\OpenAPIValidation\PSR7\Exception\ValidationFailed;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

final class Oasv implements OasvInterface
{
    private ErrorHandler $errorHandler;

    public function __construct(
        private string $oasYamlFilePath,
    ) {
        $this->errorHandler = new ErrorHandler();
    }

    public function assertResponseIsCompliantForOas(
        ResponseInterface $response,
        string $httpMethod,
        string $pathInOas
    ) {
        $validator = (new ValidatorBuilder())
            ->fromYamlFile($this->oasYamlFilePath)
            ->getResponseValidator();

        // 確実に要求する文字列を与えるために strtolower() で小文字にしている
        $operation = new OperationAddress($pathInOas, strtolower($httpMethod));

        try {
            $validator->validate($operation, $response);
        } catch (ValidationFailed $validationFailed) {
            $this->errorHandler->handle($validationFailed); // log error message and rethrows exception
        }

        assert(true);
    }

    public function assertRequestIsCompliantForOas(
        RequestInterface $request,
        string $httpMethod,
        string $contentType,
        string $pathInOas
    ) {
        $validator = (new ValidatorBuilder())
            ->fromYamlFile($this->oasYamlFilePath)
            ->getRequestValidator();

        try {
            $validator->validate($request);
        } catch (ValidationFailed $validationFailed) {
            $this->errorHandler->handle($validationFailed); // log error message and rethrows exception
        }

        assert(true);
    }
}
