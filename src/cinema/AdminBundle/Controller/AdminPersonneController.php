<?php
namespace cinema\AdminBundle\Controller;

use cinema\filmBundle\Entity\Personne;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use cinema\AdminBundle\Form\PersonneType;
/**
* @Route("/admin/personnes")
*/
class AdminPersonneController extends Controller
{
    /**
    * @Route("/ajout", name="admin_personne_ajout")
    */
    public function addAction(Request $request)
    {
        $personne = new Personne(); 
        $form = $this->createForm(PersonneType::class, $personne); 
        
        $form->handleRequest($request); //on lie le formulaire à la requête HTTP

        if ($form->isSubmitted() && $form->isValid()) { //si le formulaire a bien été soumis et qu'il est valide
            $personne = $form->getData(); //on crée un objet Genre avec les valeurs du formulaire soumis

            $em = $this->getDoctrine()->getManager(); //on récupère le gestionnaire d'entités de Doctrine

            $em->persist($personne); //on s'en sert pour enregistrer le genre (mais pas encore dans la base de données)

            $em->flush(); //écriture en base de toutes les données persistées

            return $this->redirectToRoute('admin_personne_liste'); //puis on redirige l'utilisateur vers la page des genres
        }
        
        return $this->render(
            'cinemaAdminBundle:Personne:form.html.twig',
            ['form' => $form->createView()]
        );
    }
    
    /**
    * @Route("/liste", name="admin_personne_liste")
    */
    public function listAction()
    {
        $personnes = $this->getDoctrine()->getRepository('cinemafilmBundle:Personne')->findAll();

        return $this->render(
            'cinemaAdminBundle:Personne:list.html.twig',
            ['personnes' => $personnes]
        );
    }
    

    /**
    * @Route("/modif/{id}", name="admin_personne_modif", requirements={"id": "\d+"})
    */
    public function editAction(Request $request, $id)
    {
        $personne = $this->getDoctrine()->getRepository('cinemafilmBundle:Personne')->find($id);

        $form = $this->createForm(PersonneType::class, $personne); 
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $personne = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($personne);
            $em->flush();

            return $this->redirectToRoute('admin_personne_liste');
        }

        return $this->render(
            'cinemaAdminBundle:Personne:form.html.twig',
            ['form' => $form->createView()]
        );
    }
    
    /**
    * @Route("/supprimer/{id}", name="admin_personne_supprimer", requirements={"id": "\d+"})
    */
    public function deleteAction($id)
    {
        $personne = $this->getDoctrine()->getRepository('cinemafilmBundle:Personne')->find($id);

        $em = $this->getDoctrine()->getManager(); 
        $em->remove($personne); 
        $em->flush(); 

        return $this->redirectToRoute('admin_personne_liste'); 
    }

}