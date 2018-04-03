<?php

namespace app\modules\notify\components;

use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\Event;

class Notify extends Component implements BootstrapInterface
{
    public $events = [];

    public function bootstrap($app)
    {
        foreach ($this->events as $notifyEvent) {
            Event::on($notifyEvent['eventClass'], $notifyEvent['event'], function (Event $event) use ($notifyEvent) {
                foreach ($notifyEvent['transports'] as $transport) {
                    $transport = new $transport;
                    if (!$transport instanceof NotifyTransportInterface) {
                        return;
                    }
                    $transport->run($event->sender);
                }
            });
        }
    }
}
