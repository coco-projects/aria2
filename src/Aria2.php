<?php

    declare(strict_types = 1);

    namespace Coco\aria2;

    //https://aria2.github.io/manual/en/html/aria2c.html#aria2.addUri
    use Coco\jsonrpc\JsonRPCClient;
    use Coco\jsonrpc\payload\Payload;

    /**
     * @method string addUri(array $uris, array $options = [], int $position = 0) 将 URIs 添加到下载队列中。
     * @method string addTorrent(string $torrent, array $uris = [], array $options = [], int $position = 0) 将种子文档添加到下载队列中。
     * @method string addMetalink(string $metalink, array $options = [], int $position = 0) 将 metalink 文档添加到下载队列中。
     * @method bool remove(string $gid) 删除由 gid 标识的下载任务。
     * @method bool forceRemove(string $gid) 强制删除由 gid 标识的下载任务。
     * @method bool pause(string $gid) 暂停由 gid 标识的下载任务。
     * @method bool pauseAll() 暂停所有下载任务。
     * @method bool forcePause(string $gid) 强制暂停由 gid 标识的下载任务。
     * @method bool forcePauseAll() 强制暂停所有下载任务。
     * @method bool unpause(string $gid) 解除暂停由 gid 标识的下载任务。
     * @method bool unpauseAll() 解除暂停所有下载任务。
     * @method array tellStatus(string $gid, array $keys = []) 获取由 gid 标识的特定下载任务的状态。
     * @method array getUris(string $gid) 获取由 gid 标识的特定下载任务的 URIs。
     * @method array getFiles(string $gid) 获取由 gid 标识的特定下载任务的文档信息。
     * @method array getPeers(string $gid) 获取由 gid 标识的特定下载任务的对等信息。
     * @method array getServers(string $gid) 获取由 gid 标识的特定下载任务的服务器信息。
     * @method array tellActive(array $keys = []) 获取当前活动下载任务的状态。
     * @method array tellWaiting(int $offset, int $num, array $keys = []) 获取等待下载任务的状态。
     * @method array tellStopped(int $offset, int $num, array $keys = []) 获取已停止下载任务的状态。
     * @method bool changePosition(string $gid, int $pos, string $how) 更改由 gid 标识的下载任务的位置。
     * @method bool changeUri(string $gid, int $fileIndex, array $delUris, array $addUris = [], int $position = 0) 更改特定文档的 URIs。
     * @method array getOption(string $gid) 获取由 gid 标识的特定下载任务的选项。
     * @method bool changeOption(string $gid, array $options) 更改由 gid 标识的特定下载任务的选项。
     * @method array getGlobalOption() 获取全局选项。
     * @method bool changeGlobalOption(array $options) 更改全局选项。
     * @method array getGlobalStat() 获取全局统计信息。
     * @method bool purgeDownloadResult() 清除下载结果。
     * @method bool removeDownloadResult(string $gid) 删除特定 gid 的下载结果。
     * @method string getVersion() 获取 aria2 的版本。
     * @method array getSessionInfo() 获取会话信息。
     * @method bool shutdown() 优雅地关闭 aria2。
     * @method bool forceShutdown() 强制关闭 aria2。
     * @method bool saveSession() 保存当前会话。
     */
class Aria2 extends JsonRPCClient
{
    public function __construct(string $api, private $token = null)
    {
        parent::__construct($api);
    }

    public function setToken(null $token): void
    {
        $this->token = $token;
    }

    public function doRequest($method, array $parameters = []): array
    {
        $payload = Payload::method('aria2.' . $method);

        if ($this->token) {
            $payload->withParameter("token:" . $this->token);
        }

        foreach ($parameters as $k => $parameter) {
            $payload->withParameter($parameter);
        }

        return $this->request($payload);
    }

    public function __call($name, $arguments)
    {
        return $this->doRequest($name, $arguments);
    }


    /****************************************************/

    public function addUriToDownload(string $uri, ?string $saveName = null, ?string $savePath = null)
    {
        $options = [];

        if ($saveName) {
            $options['out'] = $saveName;
        }

        if ($savePath) {
            $options['dir'] = $savePath;
        }

        return $this->addUri([$uri], $options);
    }
}
