<?php

namespace App\DataFixtures;

use App\Entity\Profession;
use App\Entity\AdType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        //Professions
        $professions = [
            'Acupuncteur/trice',
            'Agent(e) thermal(e)',
            'Aide-soignant(e)',
            'Allergologue',
            'Ambulancier/ière',
            'Anesthésiste-réanimateur/trice',
            'Animalier/ière de laboratoire',
            'Assistant(e) médical(e)',
            'Assistant(e) dentaire',
            'Audioprothésiste',
            'Auxiliaire de puériculture',
            'Brancardier/ière',
            'Cardiologue',
            'Chiropracteur/tice',

            'Chirurgien(ne)',
            'Chirurgien(ne)-dentiste',
            'Délégué(e) de l\'assurance maladie',
            'Délégué(e) pharmaceutique',
            'Dermatologue',
            'Diététicien(ne)',
            'Directeur/trice d\'établissement médical',
            'Ergothérapeute',
            'Gériatre',
            'Gynécologue - obstétricien(ne)',
            'Infirmier/ière anesthésiste',
            'Infirmier/ière de bloc opératoire',
            'Infirmier/ière hygiéniste',
            'Infirmier/ière',

            'Ingénieur(e) en recherche clinique',
            'Ingénieur(e) sécurité sanitaire',
            'Kinésithérapeute',
            'Manipulateur/trice d\'électroradiologie médicale',
            'Médecin',
            'Médecin légiste',
            'Ophtalmologiste',
            'Opticien(ne) - lunetier/ière',
            'Optométriste',
            'Orthésiste',
            'Orthophoniste',
            'Orthoprothésiste',
            'Orthoptiste',
            'Ostéopathe',

            'Pédiatre',
            'Pédicure - podologue',
            'Pédopsychiatre',
            'Pharmacien(ne)',
            'Phythothérapeute / Conseiller en pythothérapie',
            'Préparateur/trice en pharmacie',
            'Prothésiste dentaire',
            'Psychiatre',
            'Psychomotricien(ne)',
            'Puériculteur/trice',
            'Radiologue',
            'Sage-femme',
            'Secrétaire médical(e)',
            'Technicien(ne) biologiste',

            'Technicien(ne) d\'analyse biomédicales',
            'Visiteur/use médicale'
        ];

        foreach ($professions as $value) {
            $profession = new Profession();
            $profession->setName($value);
            $manager->persist($profession);
        }

        //AdTypes
        $adTypes = [
            'Cession de patientèle',
            'Collaboration libérale',
            'Demande d’emploi',
            'Location de cabinet',
            'Offre d’emploi',
            'Remplacement',
            'Vente de locaux'
        ];

        foreach ($adTypes as $value) {
            $adType = new AdType();
            $adType->setName($value);
            $manager->persist($adType);
        }

        $manager->flush();
    }
}
