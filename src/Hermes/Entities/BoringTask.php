<?php

namespace Hermes\Entities;

use Hermes\ValueObjects\IBoringTaskComponent;
use JeyDotC\EnumerableList;
use JeyDotC\IEnumerable;
use JeyDotC\IList;

/**
 * Description of BoringTask
 *
 * @author jguevara
 */
class BoringTask
{

    private $id;

    /**
     *
     * @var IList
     */
    private $components;

    public static function create($id = 0): BoringTask {
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

    function getComponent($className): IBoringTaskComponent {
        return $this->components->ofType($className)->firstOrDefault();
    }

    function getComponentsOfType($className): IEnumerable {
        return $this->components->ofType($className);
    }

    public function addComponent(IBoringTaskComponent $component): BoringTask {
        $this->components->add($component);
        return $this;
    }

}
