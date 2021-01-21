<?php

namespace App\Tests\Entity;

use App\Entity\InvitationCode;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validation;

class InvitationCodeTest extends KernelTestCase
{

    public function getEntity(): InvitationCode
    {
        return (new InvitationCode())
            ->setCode('12345')
            ->setDescription('Description de test')
            ->setExpireAt(new \DateTime());
    }

    public function assertHasErrors(InvitationCode $code, int $number = 0): void
    {
        self::bootKernel();
        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();
        $errors = $validator->validate($code);

        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' .
                $error->getMessage();
        }

        self::assertCount($number, $errors, implode(',', $messages));
    }

    public function testValidEntity(): void
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testSetDescription(): void
    {
        $this->assertHasErrors($this->getEntity()->setDescription(''), 1);
    }

    public function testSetCode(): void
    {
        $this->assertHasErrors($this->getEntity()->setCode('1q234'), 1);
        $this->assertHasErrors($this->getEntity()->setCode('1234'), 1);
        $this->assertHasErrors($this->getEntity()->setCode(''), 1);
    }
}
