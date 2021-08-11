<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Centre;
use App\Form\SearchType;
use App\Repository\CentreRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    private $repoCentre;

    public function __construct(CentreRepository $repoCentre)
    {
        $this->repoCentre = $repoCentre;
    }


    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {

        $centres = $this->repoCentre->findBy([], ['nom'=>'asc']);
        
        /* ---------------------------------------------------------------------------------------------*/
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $centres = $this->repoCentre->findWithSearch($search);
        }
        else
        {
            $centres = $this->repoCentre->findBy([], ['nom'=>'asc']);
        }
        /* ---------------------------------------------------------------------------------------------*/



        /*paginator*/
        $centres = $paginator->paginate(
            $centres, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            12 // Nombre de résultats par page

        );

        return $this->render('home/index.html.twig', [
            'centres' => $centres,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/centre/{slug}", name="centre_view")
     */
    public function centre_show(Centre $centre): Response
    {
        if(!$centre){
            return $this->redirectToRoute('home');
        }

        return $this->render('home/show.html.twig', [
            'centre' => $centre,
        ]);
    }


}
