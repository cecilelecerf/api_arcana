<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Family;
use App\Entity\People;
use App\Entity\Instrument;
use App\Entity\PeopleInstrument;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;

class AppFixtures extends Fixture
{

    public function __construct(private PasswordHasherFactoryInterface $passwordHasherFactory) {
    }
        
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $user = new User();
        $user   ->setEmail($faker->email())
                ->setFirstname($faker->firstname())
                ->setLastname($faker->lastname())
                ->setCa($faker->boolean())
                ->setPassword($this->passwordHasherFactory->getPasswordHasher(User::class)->hash('user'));
        $manager->persist($user);

        $family = new Family();
        $family ->setName($faker->lastname())
                ->setMember($faker->boolean())
                ->setEmail($faker->email())
                ->setResident($faker->boolean())
                ->setPaid($faker->boolean())
                ->setMeansOfPayment(3);
        $manager->persist($family);

        $people = new People();
        $people ->setLastname($faker->lastname())
                ->setFirstname($faker->firstname())
                ->setStreet($faker->streetAddress())
                ->setCity($faker->city())
                ->setPostalCode("95100")
                ->setPhone("0629697478")
                ->setDateOfBirth(new \DateTimeImmutable("2023-05-28T09:10:18.005Z"))
                ->setFamily($family);
        $manager->persist($people);

        $instrument = new Instrument();
        $instrument ->setName('instrument')
                ->setIcon($faker->imageUrl(640, 480, 'animals', true));
        $manager->persist($instrument);

        $peopleInstrument = new PeopleInstrument();
        $peopleInstrument ->setPeople($people)
                ->setInstrument($instrument);
        $manager->persist($peopleInstrument);

        $manager->flush();
    }
}
