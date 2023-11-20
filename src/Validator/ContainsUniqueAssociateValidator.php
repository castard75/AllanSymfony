<?php

namespace App\Validator;

use App\DTO\TelephoneDTO;
use App\Entity\Controle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ContainsUniqueAssociateValidator extends ConstraintValidator
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$value instanceof TelephoneDTO) {
            throw new UnexpectedValueException($value, TelephoneDTO::class);
        }

        if (!$constraint instanceof ContainsUniqueAssociate) {
            throw new UnexpectedTypeException($constraint, ContainsUniqueAssociate::class);
        }



        $controle = $this->em->getRepository(Controle::class)->findOneBy([
            'telephoneid' => $value->getTelephone(),
            'contratid' => $value->getContrat()
        ]);

        if ($controle instanceof Controle) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ telephone }}',  $value->getTelephone())
                ->setParameter('{{ contrat }}', $value->getContrat())
                ->addViolation();
        }



    }
}
