<?php

    declare(strict_types = 1);

    namespace Coco\aria2;

    //https://aria2.github.io/manual/en/html/aria2c.html#aria2.addUri
    use Coco\jsonrpc\JsonRPCClient;
    use Coco\jsonrpc\payload\Payload;

    /**
     * @method bool listMethods() 数组形式返回所有可用的 RPC 方法。
     * @method bool listNotifications() 数组形式返回所有可用的 RPC 通知。
     */
class Aria2System extends JsonRPCClient
{
    public array $calls = [];

    public function __construct(string $api, private $token = null)
    {
        parent::__construct($api);
    }

    public function setToken(null $token): void
    {
        $this->token = $token;
    }

    public function addCall($method, array $parameters = []): static
    {
        $params = [];

        if ($this->token) {
            $params[] = "token:" . $this->token;
        }

        foreach ($parameters as $k => $parameter) {
            $params[] = $parameter;
        }

        $this->calls[] = [
            'methodName' => 'aria2.' . $method,
            'params'     => $params,
        ];

        return $this;
    }

    public function doRequest($method, array $parameters = []): array
    {
        $payload = Payload::method('system.' . $method);

        $payload->withParameterArray($parameters);

        return $this->request($payload);
    }

    public function __call($name, $arguments)
    {
        return $this->doRequest($name, $arguments);
    }


    /****************************************************/

    public function multicall(): array
    {
        $result = $this->doRequest('multicall', [$this->calls]);
        $this->calls = [];

        return $result;
    }

    public function addUriToDownload(string $uri, ?string $saveName = null, ?string $savePath = null): static
    {
        $p = [];

        if ($saveName) {
            $p['out'] = $saveName;
        }

        if ($savePath) {
            $p['dir'] = $savePath;
        }

        $this->addCall('addUri', [
            [$uri],
            $p,
        ]);

        return $this;
    }
}
