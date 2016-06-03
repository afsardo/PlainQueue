<?php

namespace AFSardo\PlainQueue;

use Pheanstalk\Job as PheanstalkJob;
use AFSardo\PlainQueue\Jobs\BeanstalkdPlainJob;
use Illuminate\Contracts\Queue\Queue as QueueContract;
use Illuminate\Queue\BeanstalkdQueue;

class BeanstalkdPlainQueue extends BeanstalkdQueue implements QueueContract
{

    /**
     * Pop the next job off of the queue.
     *
     * @param  string  $queue
     * @return \Illuminate\Contracts\Queue\Job|null
     */
    public function pop($queue = null)
    {
        $queue = $this->getQueue($queue);

        $job = $this->pheanstalk->watchOnly($queue)->reserve(0);

        if ($job instanceof PheanstalkJob) {
            return new BeanstalkdPlainJob($this->container, $this->pheanstalk, $job, $queue);
        }
    }

}
