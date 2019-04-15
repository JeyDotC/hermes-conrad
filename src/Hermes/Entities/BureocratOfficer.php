<?php
namespace Hermes\Entities;

use Hermes\Services\IBureocratService;


/**
 * Description of BureocratOfficer
 *
 * @author jguevara
 */
class BureocratOfficer
{

    private $id;
    private $name;

    /**
     *
     * @var IBureocratService
     */
    private $function;

    public function __construct(int $id, $name, IBureocratService $function) {
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

    public function getFunction(): IBureocratService {
        return $this->function;
    }
}
