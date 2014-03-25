<?php namespace Spam;

use Session;

class SessionStore implements StoreInterface {

    /**
     * Save the job in the repository
     *
     * @param $jobName
     */
    public function save($jobName)
    {
        $edited = false;

        // Get all jobs in the session
        $jobs = Session::get('spam.jobs', array());

        // Find the job by name
        foreach($jobs as &$job)
        {
            if($job['name'] = $jobName)
            {
                // Modify the job at and no
                $job['at'] = time();

                $job['no'] = $job['no'] + 1;

                // Set edited to true to not add this job again
                $edited = true;
            }
        }

        // If no edit has been done then add new
        if(! $edited)
        {
            $jobs[] = array(
                'name' => $jobNamejmnnnnnnnnnnnnnnnnnnn,
                'at' => time(),
                'no' => 1,
            );
        }

        Session::put('spam.jobs', $jobs);
    }

    /**
     * @param $job
     * @return string timestamps
     */
    public function get($job)
    {
        $jobs = Session::get('spam.jobs', array());

        foreach($jobs as $job)
        {
            if($job['name'] == $job)
            {
                return $job['time'];
            }
        }

        return 0;
    }
}