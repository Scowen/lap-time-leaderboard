<?php

namespace app\components;

use Yii;

class Timing
{
    private $start;
    private $stop;
    private $result;

    public function start()
    {
        $this->start = microtime(true);
    }

    public function stop()
    {
        $this->stop = microtime(true);
    }

    public function result()
    {
        if (!$this->start)
            return "Timer not started. (Timing->start())";
        elseif (!$this->stop)
            return "Timer not stopped. (Timing->stop())";

        $this->result = $this->stop - $this->start;
        return number_format($this->result, 4);
    }

    public function lastResult()
    {
        if (!$this->result)
            return "No result recorded. (Timing->result())";

        return number_format($this->result, 4);
    }
}