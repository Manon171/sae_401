<?php

namespace App\Controller;

use App\Entity\StatistiqueLogement;
use App\Entity\Departement;
use App\Entity\Region;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class StatistiqueController extends AbstractController
{
    #[Route('/statistique/logement/', name: 'stat_logement')]
    public function logement(EntityManagerInterface $entityManager): Response
    {
        $statistiques = $entityManager
            ->getRepository(StatistiqueLogement::class)
            ->findAll();

        return $this->json($statistiques, 200, [], ['groups' => 'logement']);
    }

    #[Route('/statistique/departement/', name: 'stat_departement')]
    public function departement(EntityManagerInterface $entityManager): Response
    {
        $statistiques = $entityManager
            ->getRepository(Departement::class)
            ->findAll();

        return $this->json($statistiques, 200, [], ['groups' => 'departement']);
    }

    #[Route('/statistique/region/', name: 'stat_region')]
    public function region(EntityManagerInterface $entityManager): Response
    {
        $statistiques = $entityManager
            ->getRepository(Region::class)
            ->findAll();

        return $this->json($statistiques, 200, [], ['groups' => 'region']);
    }
}