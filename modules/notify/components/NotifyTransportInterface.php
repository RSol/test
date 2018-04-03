<?php

namespace app\modules\notify\components;


interface NotifyTransportInterface
{
    public function run($model);
}