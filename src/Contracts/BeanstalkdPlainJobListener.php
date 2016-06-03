<?php

namespace AFSardo\PlainQueue\Contracts;


interface BeanstalkdPlainJobListener {

	/**
	 * Method that handles the job (payload) that comes from the queue.
	 */
	public function handle($payload);

}