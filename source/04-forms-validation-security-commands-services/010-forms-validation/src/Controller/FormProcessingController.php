<?php // src/Controller/FormBuilderController
namespace App\Controller;

use App\Entity\Location;
use App\Form\NewLocationType;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FormProcessingController extends AbstractController
{
    public function newAction(Request $request): Response
    {
        $location = new Location();
        $form = $this->createForm(NewLocationType::class, $location);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($location);
            $em->flush();

            return $this->redirectToRoute('form_processing_index');
        }

        return $this->render(
            'form_processing/new.html.twig',
            ['form' => $form->createView(),]
        );
    }

    public function indexAction(LocationRepository $repository): Response
    {
        $locations = $repository->findAll();
        return $this->render('form_processing/index.html.twig', [
            'locations' => $locations,
        ]);
    }
}
