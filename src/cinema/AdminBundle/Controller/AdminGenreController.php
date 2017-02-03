<?php
namespace cinema\AdminBundle\Controller;

use cinema\filmBundle\Entity\Genre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use cinema\AdminBundle\Form\GenreType;
/**
* @Route("/admin/genres")
*/
class AdminGenreController extends Controller
{
    /**
    * @Route("/ajout", name="admin_genre_ajout")
    */
    public function addAction(Request $request)
    {
        $genre = new Genre(); 
        $form = $this->createForm(GenreType::class, $genre); 
        
        $form->handleRequest($request); //on lie le formulaire à la requête HTTP

        if ($form->isSubmitted() && $form->isValid()) { //si le formulaire a bien été soumis et qu'il est valide
            $genre = $form->getData(); //on crée un objet Genre avec les valeurs du formulaire soumis

            $em = $this->getDoctrine()->getManager(); //on récupère le gestionnaire d'entités de Doctrine

            $em->persist($genre); //on s'en sert pour enregistrer le genre (mais pas encore dans la base de données)

            $em->flush(); //écriture en base de toutes les données persistées

            return $this->redirectToRoute('admin_genre_liste'); //puis on redirige l'utilisateur vers la page des genres
        }
        
        return $this->render(
            'cinemaAdminBundle:Genre:form.html.twig',
            ['form' => $form->createView()]
        );
    }
    
    /**
    * @Route("/liste", name="admin_genre_liste")
    */
    public function listAction()
    {
        $genres = $this->getDoctrine()->getRepository('cinemafilmBundle:Genre')->findAll();

        return $this->render(
            'cinemaAdminBundle:Genre:list.html.twig',
            ['genres' => $genres]
        );
    }
    

    /**
    * @Route("/modif/{id}", name="admin_genre_modif", requirements={"id": "\d+"})
    */
    public function editAction(Request $request, $id)
    {
        $genre = $this->getDoctrine()->getRepository('cinemafilmBundle:Genre')->find($id);

        $form = $this->createForm(GenreType::class, $genre); 
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $genre = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($genre);
            $em->flush();

            return $this->redirectToRoute('admin_genre_liste');
        }

        return $this->render(
            'cinemaAdminBundle:Genre:form.html.twig',
            ['form' => $form->createView()]
        );
    }
    
    /**
    * @Route("/supprimer/{id}", name="admin_genre_supprimer", requirements={"id": "\d+"})
    */
    public function deleteAction($id)
    {
        $genre = $this->getDoctrine()->getRepository('cinemafilmBundle:Genre')->find($id);

        $em = $this->getDoctrine()->getManager(); 
        $em->remove($genre); 
        $em->flush(); 

        return $this->redirectToRoute('admin_genre_liste'); 
    }

}