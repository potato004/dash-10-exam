<?php
use Illuminate\Support;  // https://laravel.com/docs/5.8/collections - provides the collect methods & collections class
use LSS\Array2Xml;
require_once('classes/Exporter.php');

class Controller extends Exporter{
    private $search = [];
    public function __construct($args) {
        $this->args = $args;

        $this->setSearch();
    }

    private function setSearch() {
        $searchArgs = ['player', 'playerId', 'team', 'position', 'country'];
        $this->search = $this->args->filter(function($value, $key) use ($searchArgs) {
            return in_array($key, $searchArgs);
        });

        return $this;
    }

    public function export($type, $format) {
        $exporter   = new Exporter();
        $data       = $exporter->getData($this->search, $type);

        if (!$data) {
            exit("Error: No data found!");
        }

        return $exporter->$format($data);
    }
}

