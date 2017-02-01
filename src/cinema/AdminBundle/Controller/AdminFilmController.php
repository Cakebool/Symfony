<?php
namespace cinema\AdminBundle\Controller;

use cinema\filmBundle\Entity\Film;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use cinema\AdminBundle\Form\FilmType;
/**
* @Route("/admin/films")
*/
class AdminFilmController extends Controller
{
    /**
    * @Route("/ajout", name="admin_film_ajout")
    */
    public function addAction(Request $request)
    {
        $film = new Film(); 
        $form = $this->createForm(FilmType::class, $film); 
        
        $form->handleRequest($request); //on lie le formulaire à la requête HTTP

        if ($form->isSubmitted() && $form->isValid()) { //si le formulaire a bien été soumis et qu'il est valide
            $film = $form->getData(); //on crée un objet Genre avec les valeurs du formulaire soumis

            $em = $this->getDoctrine()->getManager(); //on récupère le gestionnaire d'entités de Doctrine

            $em->persist($film); //on s'en sert pour enregistrer le genre (mais pas encore dans la base de données)

            $em->flush(); //écriture en base de toutes les données persistées

            return $this->redirectToRoute('admin_film_liste'); //puis on redirige l'utilisateur vers la page des genres
        }
        
        return $this->render(
            'cinemaAdminBundle:Film:form.html.twig',
            ['form' => $form->createView()]
        );
    }
    
    /**
    * @Route("/liste", name="admin_film_liste")
    */
    public function listAction()
    {
        $films = $this->getDoctrine()->getRepository('cinemafilmBundle:Film')->findAll();

        return $this->render(
            'cinemaAdminBundle:Film:list.html.twig',
            ['films' => $films]
        );
    }
    

    /**
    * @Route("/modif/{id}", name="admin_film_modif", requirements={"id": "\d+"})
    */
    public function editAction(Request $request, $id)
    {
        $film = $this->getDoctrine()->getRepository('cinemafilmBundle:Film')->find($id);

        $form = $this->createForm(FilmType::class, $film); 
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $film = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($film);
            $em->flush();

            return $this->redirectToRoute('admin_film_liste');
        }

        return $this->render(
            'cinemaAdminBundle:Film:form.html.twig',
            ['form' => $form->createView()]
        );
    }
    
    /**
    * @Route("/supprimer/{id}", name="admin_film_supprimer", requirements={"id": "\d+"})
    */
    public function deleteAction($id)
    {
        $film = $this->getDoctrine()->getRepository('cinemafilmBundle:Film')->find($id);

        $em = $this->getDoctrine()->getManager(); 
        $em->remove($film); 
        $em->flush(); 

        return $this->redirectToRoute('admin_film_liste'); 
    }

}