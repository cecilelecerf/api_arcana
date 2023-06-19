<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use DateTimeImmutable;

use Exception;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Family;
use App\Entity\People;
use App\Entity\PeopleInstrument;
use App\Entity\Instrument;
use App\Entity\Classe;
use App\Entity\PeopleClasse;
use DateTimeInterface;

class FamiliesController extends AbstractController
{
    #[Route('/family', name: 'create_family', methods: ['POST'])]
    public function createFamilies(Request $request, ValidatorInterface $validator, EntityManagerInterface $manager): JsonResponse
    {                
        $data = json_decode($request->getContent(), true);
        $family = new Family();
        $family->setName($data['name'])
            ->setMember($data['member'])
            ->setEmail($data['email'])
            ->setResident($data['resident'])
            ->setPaid($data['paid'])
            ->setMeansOfPayment($data['meansOfPayment']);
            
        foreach($data['people'] as $dataPeople){
            try {
                $dateOfBirth = new DateTime($dataPeople['dateOfBirth']);
            } catch (Exception $e) {
                return new JsonResponse(['error' => 'La date de naissance n\'est pas valide'], JsonResponse::HTTP_BAD_REQUEST);
            }
            $dateOfBirth = new \DateTimeImmutable($dataPeople['dateOfBirth']);
            $people = new People();
            $people->setFirstname($dataPeople['firstname'])
                ->setLastname($dataPeople['lastname'])
                ->setStreet($dataPeople['street'])
                ->setCity($dataPeople['city'])
                ->setPostalCode($dataPeople['postalCode'])
                ->setPhone($dataPeople['phone'])
                ->setDateOfBirth($dateOfBirth);
            $family->addPerson($people);
            if(isset($data['peopleInstrument']) && !empty($data['peopleInstrument'])){
                foreach($dataPeople['peopleInstrument'] as $dataPeopleInstrument){
                    $instrument = $manager->getRepository(Instrument::class)->find($dataPeopleInstrument['instrument']);
                    $dateTime = new \DateTime($dataPeopleInstrument['time']);
                    $peopleInstrument = new PeopleInstrument();
                    $peopleInstrument->setInstrument($instrument)
                        ->setTime($dateTime);
                    $people->addPeopleInstrument($peopleInstrument);

                    $errors = $validator->validate($peopleInstrument);
                    if (count($errors) > 0) {
                        $errorMessages = [];
                        foreach ($errors as $error) {
                            $propertyPath = $error->getPropertyPath();
                            $message = $error->getMessage();
                            $errorMessages[$propertyPath][] = $message;
                        }
                        return new JsonResponse(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
                    }
                    $manager->persist($peopleInstrument);
                }
            }

            if(isset($data['peopleClasse']) && !empty($data['peopleClasse'])){
                foreach($dataPeople['peopleClasse'] as $dataPeopleClasse){
                    $classe = $manager->getRepository(Classe::class)->find($dataPeopleClasse['classe']);
                    $peopleClasse = new PeopleClasse();
                    $peopleClasse->setClasse($classe);
                    $people->addPeopleClass($peopleClasse);

                    $errors = $validator->validate($peopleClasse);
                    if (count($errors) > 0) {
                        $errorMessages = [];
                        foreach ($errors as $error) {
                            $propertyPath = $error->getPropertyPath();
                            $message = $error->getMessage();
                            $errorMessages[$propertyPath][] = $message;
                        }
                        return new JsonResponse(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
                    }
                    $manager->persist($peopleClasse);
                }
            }

            $errors = $validator->validate($people);
            if (count($errors) > 0) {
                $errorMessages = [];
                foreach ($errors as $error) {
                    $propertyPath = $error->getPropertyPath();
                    $message = $error->getMessage();
                    $errorMessages[$propertyPath][] = $message;
                }
                return new JsonResponse(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
            }
            $manager->persist($people);
        }
        $errors = $validator->validate($family);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $propertyPath = $error->getPropertyPath();
                $message = $error->getMessage();
                $errorMessages[$propertyPath][] = $message;
            }
            return new JsonResponse(['errors' => $errorMessages], JsonResponse::HTTP_BAD_REQUEST);
        }
 
        $manager->persist($family);
        $manager->flush();
        return new JsonResponse(['message' => 'Inscription réussie avec succès'], JsonResponse::HTTP_CREATED);
    }
}
