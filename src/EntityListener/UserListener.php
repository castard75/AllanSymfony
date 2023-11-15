<?php
namespace App\EntityListener;
use App\Entity\Employees;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
class UserListener {

private UserPasswordHasherInterface  $hasher;
public function __construct (UserPasswordHasherInterface $hasher){
$this->hasher = $hasher;

}

public function prePersit(Employees $employees){
$this->encodePassword($employees);


}


public function preUpdate (Employees $employees){

    $this->encodePassword($employees);
}


public function encodePassword(Employees $employees){

if($employees->getPlainPassword() === null) 
{
 return;
       }

       $employees->setPassword( $this->$hasher->hashPassword(
        $employees,
        $employees->getPlainPassword()
       )  );

}
};