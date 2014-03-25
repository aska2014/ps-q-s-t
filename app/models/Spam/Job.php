<?php namespace Spam;

class Job {

    /**
     * Name for this job
     *
     * @var string
     */
    protected $name;

    /**
     * Number of times this job can be done in the given interval
     *
     * @var int
     */
    protected $numberOfTimes;

    /**
     * Interval to do this job number of times
     *
     * @var int
     */
    protected $interval;

    /**
     * @var IdentifierInterface
     */
    protected $identifier;

    /**
     * @var StoreInterface
     */
    protected $store;

    /**
     * @param $name
     * @param $numberOfTimes
     * @param $interval
     * @param StoreInterface $store
     */
    public function __construct($name, $numberOfTimes, $interval, StoreInterface $store)
    {
        $this->name = $name;
        $this->numberOfTimes = $numberOfTimes;
        $this->interval = $interval;
        $this->store = $store;
    }

    /**
     *
     */
    public function canBeDone()
    {
        // Get the time this job was last saved
        $time = $this->store->get($this->name);
    }

    /**
     * Save the job to the store
     */
    public function save()
    {
        $this->store->save($this->name);
    }
}