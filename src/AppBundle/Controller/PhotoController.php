<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Photo controller.
 *
 * @Route("photo")
 */
class PhotoController extends Controller
{
    /**
     * Lists all photo entities.
     *
     * @Route("/", name="photo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $photos = $em->getRepository('AppBundle:Photo')->findAll();

        return $this->render('photo/index.html.twig', array(
            'photos' => $photos,
        ));
    }

    /**
     * Creates a new photo entity.
     *
     * @Route("/new", name="photo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $photo = new Photo();
        $form = $this->createFormBuilder($photo)
            -> add('photo', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            -> add('trail', EntityType::class, array('class' => 'AppBundle:Trail', 'choice_label' => 'name', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            -> add('author', EntityType::class, array('class' => 'AppBundle:Author', 'choice_label' => 'surname' , 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            -> add('file', FileType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $photo->upload();
            $em->persist($photo);
            $em->flush();

            return $this->redirectToRoute('photo_show', array('id' => $photo->getId()));
        }

        return $this->render('photo/new.html.twig', array(
            'photo' => $photo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a photo entity.
     *
     * @Route("/{id}", name="photo_show")
     * @Method("GET")
     */
    public function showAction(Photo $photo)
    {
        $deleteForm = $this->createDeleteForm($photo);

        return $this->render('photo/show.html.twig', array(
            'photo' => $photo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing photo entity.
     *
     * @Route("/{id}/edit", name="photo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Photo $photo)
    {
        $deleteForm = $this->createDeleteForm($photo);
        $editForm = $this->createFormBuilder($photo)
            -> add('photo', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            -> add('trail', EntityType::class, array('class' => 'AppBundle:Trail', 'choice_label' => 'name', 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            -> add('author', EntityType::class, array('class' => 'AppBundle:Author', 'choice_label' => 'surname' , 'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->getForm();
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('photo_edit', array('id' => $photo->getId()));
        }

        return $this->render('photo/edit.html.twig', array(
            'photo' => $photo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a photo entity.
     *
     * @Route("/{id}", name="photo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Photo $photo)
    {
        $form = $this->createDeleteForm($photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($photo);
            $em->flush();
        }

        return $this->redirectToRoute('photo_index');
    }

    /**
     * Creates a form to delete a photo entity.
     *
     * @param Photo $photo The photo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Photo $photo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('photo_delete', array('id' => $photo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
