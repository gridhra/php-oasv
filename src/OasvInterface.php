<?php

namespace Yiegle\Oasv;

use PHPUnit\Framework\AssertionFailedError;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * 機能：SpecificationとPSR-7 Messageとを比較するバリデーション
 * 前提：PHPUnitTestの実装クラスでuseすることを前提する.
 *
 * なぜInterfaceとして定義しているか：
 * 現状の実装クラスは比較的歴史の浅い外部ライブラリに依存している
 * が、これが仮に継続的にメンテナンスされなくなっても容易に置換可能なようにしておきたい
 */
interface OasvInterface
{
    /**
     * レスポンスボディのjsonのスキーマがOpenAPI仕様書で定義された内容と合致しているかを検査するメソッド.
     *
     * @throws AssertionFailedError
     */
    public function assertResponseIsCompliantForOas(
        ResponseInterface $testResponse,
        string $httpMethod,
        string $pathInOas
    );

    /**
     * リクエストボディのjsonのスキーマがOpenAPI仕様書で定義された内容と合致しているかを検査するメソッド.
     */
    public function assertRequestIsCompliantForOas(
        RequestInterface $requestBody,
        string $httpMethod,
        string $contentType,
        string $pathInOas
    );
}
