<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ContainsUniqueAssociate extends Constraint
{
    public string $message = 'L\'association suivante "Téléphone: {{ telephone }} - contrat: {{ contrat }}" est déja enregistré en base de donnée ';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }

}
