<?php

namespace App\Controller;


use App\Manager\PersonManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PersonController extends Controller
{
    /**
     * @var PersonManager
     */
    private $personManager;

    public function __construct(PersonManager $personManager)
    {
        $this->personManager = $personManager;
    }

    /**
     * @Route("/person/list/{letter}", name="app_person_list", defaults={"letter":"A"})
     *
     * @param Request $request
     * @param string $letter
     * @return string
     */
    public function listAction(Request $request, string $letter)
    {
        return $this->render('pages/list.html.twig', [
            'persons' => $this->personManager->findByLetter($letter),
        ]);
    }

    /**
     * @Route("/person/fiche/{pid}", name="app_person_fiche")
     *
     * @param Request $request
     * @param string $pid
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function ficheAction(Request $request, string $pid)
    {
        $person = $this->personManager->getByPid($pid);
        if(empty($person))
        {
            throw new NotFoundHttpException();
        }
        return $this->render('pages/fiche.html.twig', [
            'person' => $this->personManager->getByPid($pid),
        ]);
    }
}