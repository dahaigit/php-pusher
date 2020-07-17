<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\HttpServer\Request;
use Hyperf\WebSocketServer\Sender;

/**
 * @AutoController
 */
class SenderController
{
    /**
     * @Inject
     * @var Sender
     */
    protected $sender;

//    public function close(int $fd)
//    {
//        go(function () use ($fd) {
//            sleep(1);
//            $this->sender->disconnect($fd);
//        });
//
//        return '';
//    }

    /**
     * 消息推送器，满足站内通信
     * @return string
     */
    public function send(Request $request)
    {
        $this->sender->push((int)$request->input('user'), $request->input('message'));

        return '';
    }

    /**
     * 消息推送器，满足站内通信
     * @return string
     */
    public function ioSend(Request $request)
    {
        $io = \Hyperf\Utils\ApplicationContext::getContainer()->get(\Hyperf\SocketIOServer\SocketIO::class);

        // sending to all clients in 'game' room, including sender
        // 向 game 房间内的所有连接推送 bigger-announcement 事件。
        $io->in('user1')->emit('close-door-event', '用户手动关闭了门');

        return '';
    }
}
