<?php

namespace PHPPeru\Exam;

use Symfony\Component\EventDispatcher\EventDispatcherInterface,
    Symfony\Component\EventDispatcher\EventDispatcher,
    BadMethodCallException;
use PHPPeru\Exam\Event\Events;
use PHPPeru\Exam\StepEvent;

/**
 * Description of SimpleStep
 *
 * @author juan
 */
class SimpleStep implements StepInterface {

    const STATUS_NEW       = 0;
    const STATUS_READ      = 1;
    const STATUS_ANSWERED  = 2;
    
    const EVENT_READ       = 'read';
    const EVENT_ANSWER     = 'answer';
    
    protected $status = self::STATUS_NEW;
    protected $description;

    /**
     * Event dispatcher used internally to trigger events during lifecycle
     *
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;    
    
    /**
     * Default constructor, initializes events 
     */
    public function __construct($description) {       
        $this->eventDispatcher = new EventDispatcher();
        $this->setDescription($description);
    }    

    /**
     * {@inheritdoc}
     */
    public function read() {
        if (!$this->isNew()) {
            throw new BadMethodCallException('Step is not new');
        }        
        $this->setStatus(self::STATUS_READ);
        $this->eventDispatcher->dispatch(Events::onReadStep, new StepEvent($this));
    }
    
    
    private function setDescription($description) {
        if( !empty($description) ) 
        {
            $this->description = $description;
        }
        else
        {
            throw new \InvalidArgumentException("Description is already defined or the passed value is not valid.");
        }
    }

    public function getDescription() {
        return $this->description;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    
    public function isNew() {
        return $this->status == self::STATUS_NEW;
    }

    public function isRead() {
        return $this->status == self::STATUS_READ;
    }

    public function isAnswered() {
        return $this->status == self::STATUS_ANSWERED;
    }

}

?>
