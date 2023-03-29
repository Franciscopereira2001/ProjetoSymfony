<?php

namespace App\Controller;

use App\Entity\Gericht;
use App\Form\GerichtType;
use App\Repository\GerichtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/gericht", name="gericht.")
 */
class GerichtController extends AbstractController
{
    /**
    * @Route("/", name="bearbeiten")
     */
    public function index(GerichtRepository $gr): Response
    {

        $gerichte = $gr->findAll();

        return $this->render('gericht/index.html.twig;', [
            'gerichte' => $gerichte
        ]);
    }

    /**
     * @Route("/anlegen", name="anlegen")
     */
    public function anlegechn(Request $request)
    {
        $gericht = new Gericht();

        //Formulario
        $form = $this->createForm(GerichtType::class, $gericht);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            //EntityManager
            $em = $this->getDoctrine()->getManager();
            $bild = $request->files->get('gericht')['anhang'];

            if ($bild) {
                $dateiname = md5(uniqid()) . '.' . $bild->guessClientExtension();
            }

            $bild->move(
                $this->getParameter('bilder_ordner'),
                $dateiname
            );

            $gericht->setBild($dateiname);
            $em->persist($gericht);
            $em->flush();

            return $this->redirect($this->generateUrl('gericht.bearbeiten'));
        }

        //Response
        return $this->render('gericht/anlegen.html.twig', [
            'anlegenForm' => $form->createView()
        ]);
    }

    /**
     * @Route("delete/{id}", name="delete")
     */
    public function delete($id, GerichtRepository $gr){
        $em = $this->getDoctrine()->getManager();
        $gericht = $gr->find($id);
        $em->remove($gericht);
        //Serve para que as atualizacoes sejam atualizadas na base de dados
        $em->flush();

        //message
        $this->addFlash('erfolg', 'Gericht wurde erfolgreich entfernt');
        return $this->redirect($this->generateUrl('gericht.bearbeiten'));
    }

    /**
     * @Route("/anzeigen/{id}", name="anzeigen")
     */
    public function anteigen(Gericht $gericht)
    {
        return $this->render('gericht/anzeigen.html.twig', [
            'gericht' => $gericht
        ]);
    }


    /**
     * @Route("/preis/{id}", name="preis")
     */
    public function preis($id, GerichtRepository $gerichtRepository)
    {
        $gericht = $gerichtRepository->find5Euro($id);
        dump($gericht);
    }
}



