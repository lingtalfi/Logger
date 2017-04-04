<?php


namespace Logger\Formatter;


class TagFormatter implements FormatterInterface
{

    private $model;
    private $formattedTags;


    public static function create()
    {
        return new static();
    }

    public function __construct()
    {
        $this->model = '{date} {time} - [{identifier}]: {msg}';
    }

    public function format($msg, $identifier)
    {
        $tags = $this->getFormattedTags($msg, $identifier);
        return str_replace(array_keys($tags), array_values($tags), $this->model);
    }

    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    //--------------------------------------------
    //
    //--------------------------------------------
    protected function prepareTags(array &$tags)
    {

    }

    //--------------------------------------------
    //
    //--------------------------------------------
    private function getFormattedTags($msg, $identifier)
    {
        if (null === $this->formattedTags) {
            $tags = [
                "msg" => $msg,
                "identifier" => $identifier,
                "date" => date("Y-m-d"),
                "time" => date("H:i:s"),
            ];
            $this->prepareTags($tags);
            $this->formattedTags = [];
            foreach ($tags as $tag => $value) {
                $this->formattedTags['{' . $tag . '}'] = $value;
            }
        }
        return $this->formattedTags;
    }

}