<?php
namespace Hermes\Bureau;

use Hermes\Bureau\Services\IBureaucratService;


/**
 * Description of BureaucratOfficer
 *
 * @author jguevara
 */
class BureaucratOfficer
{

    private $id;
    private $name;

    /**
     *
     * @var IBureaucratService
     */
    private $function;

    public function __construct(int $id, $name, IBureaucratService $function) {
        $this->id = $id;
        $this->name = $name;
        $this->function = $function;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getFunction(): IBureaucratService {
        return $this->function;
    }
}
