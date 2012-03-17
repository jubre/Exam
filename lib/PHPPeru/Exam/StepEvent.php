<?php
namespace PHPPeru\Exam;

use Symfony\Component\EventDispatcher\Event as BaseEvent;

/**
 * Provides information about an step lifecycle event
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 */
class StepEvent extends BaseEvent
{
    /**
     * The step that triggered the event
     *
     * @var ExamInterface 
     */
    protected $step;

    /**
     * Default constructor
     *
     * @param ExamInterface $step 
     */
    public function __construct(StepInterface $step)
    {
        $this->step = $step;
    }
    
    /**
     * Retrieves the step registered with the event
     *
     * @return StepInterface 
     */
    public function getStep()
    {
        return $this->step;
    }
}