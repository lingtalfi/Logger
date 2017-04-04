<?php


namespace Logger\Listener;


/**
 * The first question a loggerListener must answer is:
 *
 * - do I respond to the log message or not?
 *
 *
 * This class provides one way of handling that question.
 *
 *
 */
abstract class AbstractLoggerListener implements LoggerListenerInterface
{

    private $identifiers;


    public function __construct()
    {
        $this->identifiers = [];
    }

    public static function create()
    {
        return new static();
    }

    abstract protected function doListen($msg, $identifier);


    public function listen($msg, $identifier)
    {
        if (true === $this->willListen($identifier)) {
            $this->doListen($msg, $identifier);
        }
    }

    public function addIdentifier($identifier)
    {
        $this->identifiers[] = $identifier;
        return $this;
    }

    public function setIdentifiers(array $identifiers)
    {
        $this->identifiers = $identifiers;
        return $this;
    }




    //--------------------------------------------
    //
    //--------------------------------------------
    protected function willListen($identifier)
    {
        return in_array($identifier, $this->identifiers, true);
    }
}