<?php

namespace AFSardo\PlainQueue\Jobs;

use Illuminate\Queue\Jobs\BeanstalkdJob;
use Illuminate\Contracts\Queue\Job as JobContract;

use AFSardo\PlainQueue\Contracts\BeanstalkdPlainJobListener;

class BeanstalkdPlainJob extends BeanstalkdJob implements JobContract
{

    /**
     * Fire the job.
     *
     * @return void
     */
    public function fire()
    {
        $listener = app('AFSardo\PlainQueue\Contracts\BeanstalkdPlainJobListener');

        $payload = json_decode($this->getRawBody(), true);
        
        if ($listener instanceof BeanstalkdPlainJobListener) {
            $listener->handle($payload);
        } else {
            throw new Exception('Please bind BeanstalkdPlainJobListener contract in your AppServiceProvider.');
        }
        
        if (! $this->isDeletedOrReleased()) {
            $this->delete();
        }
    }

    
}
