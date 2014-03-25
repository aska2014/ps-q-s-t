<?php namespace Spam;

interface StoreInterface {

    /**
     * @param $job
     * @return string timestamps
     */
    public function get($job);

    /**
     * Save the job in the repository
     *
     * @param $jobName
     */
    public function save($jobName);

} 