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

    private $id;

    /**
     *
     * @var IList
     */
    private $components;

    public static function create($id = 0): Form {
        return new static($id, EnumerableList::empty());
    }

    function __construct($id, IList $components) {
        $this->id = $id;
        $this->components = $components;
    }

    function getId() {
        return $this->id;
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
