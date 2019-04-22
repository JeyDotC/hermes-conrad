<?php

namespace Hermes\Bureau;

use Hermes\Bureau\IFormComponent;
use JeyDotC\EnumerableList;
use JeyDotC\IEnumerable;
use JeyDotC\IList;

/**
 * Description of Form
 *
 * @author jguevara
 */
class Form
{

    /**
     *
     * @var int
     */
    private $formNumber;

    /**
     *
     * @var IList
     */
    private $components;

    public static function create($formNumber = 0): Form {
        return new static($formNumber, EnumerableList::empty());
    }

    function __construct($id, IList $components) {
        $this->formNumber = $id;
        $this->components = $components;
    }

    function getFormNumber() {
        return $this->formNumber;
    }

    function hasComponent($className): bool {
        return $this->components->ofType($className)->any();
    }

    function getComponent($className): IFormComponent {
        return $this->components->ofType($className)->firstOrDefault();
    }

    function getComponentsOfType($className): IEnumerable {
        return $this->components->ofType($className);
    }

    public function addComponent(IFormComponent $component): Form {
        $this->components->add($component);
        return $this;
    }

}
