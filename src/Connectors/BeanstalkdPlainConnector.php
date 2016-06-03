<?php

namespace AFSardo\PlainQueue\Connectors;

use Pheanstalk\Pheanstalk;
use Illuminate\Support\Arr;
use Pheanstalk\PheanstalkInterface;
use AFSardo\PlainQueue\BeanstalkdPlainQueue;
use Illuminate\Queue\Connectors\ConnectorInterface;


class BeanstalkdPlainConnector implements ConnectorInterface
{
    /**
     * Establish a queue connection.
     *
     * @param  array  $config
     * @return \Illuminate\Contracts\Queue\Queue
     */
    public function connect(array $config)
    {
        $pheanstalk = new Pheanstalk($config['host'], Arr::get($config, 'port', PheanstalkInterface::DEFAULT_PORT));

        return new BeanstalkdPlainQueue(
            $pheanstalk, $config['queue'], Arr::get($config, 'ttr', Pheanstalk::DEFAULT_TTR)
        );
    }
}