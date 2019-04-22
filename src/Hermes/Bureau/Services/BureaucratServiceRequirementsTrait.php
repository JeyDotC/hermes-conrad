<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Hermes\Bureau\Services;

use Hermes\Bureau\Form;
use JeyDotC\Enumerable;

/**
 *
 * @author Win 10
 */
trait BureaucratServiceRequirementsTrait {

    public function requireCompoents(Form $form, array $classNames) {
        return Enumerable::from($classNames)
                ->all(function (string $className) use($form){
                    return $form->hasComponent($className);
                });
    }
    
    

}
