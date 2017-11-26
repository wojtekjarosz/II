<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Trail;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Trail controller.
 *
 * @Route("trail")
 */
class TrailController extends Controller
{
    /**
     * Lists all trail entities.
     *
     * @Route("/", name="trail_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $trails = $em->getRepository('AppBundle:Trail')->findAll();

        return $this->render('trail/index.html.twig', array(
            'trails' => $trails,
        ));
    }

    /**
     * Creates a new trail entity.
     *
     * @Route("/new", name="trail_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $trail = new Trail();
        $form = $this->createFormBuilder($trail)
            -> add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'), 'label' => 'Nazwa'))
            -> add('startPoint', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'), 'label' => 'Punkt początkowy'))
            -> add('finalPoint', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'), 'label' => 'Punkt końcowy'))
            -> add('colour', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'), 'label' => 'Kolor'))
            -> add('difficulty', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'), 'label' => 'Czas'))
            -> getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($trail);
            $em->flush();

            return $this->redirectToRoute('trail_show', array('id' => $trail->getId()));
        }

        return $this->render('trail/new.html.twig', array(
            'trail' => $trail,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a trail entity.
     *
     * @Route("/{id}", name="trail_show")
     * @Method("GET")
     */
    public function showAction(Trail $trail)
    {
        $deleteForm = $this->createDeleteForm($trail);

        return $this->render('trail/show.html.twig', array(
            'trail' => $trail,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing trail entity.
     *
     * @Route("/{id}/edit", name="trail_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Trail $trail)
    {
        $deleteForm = $this->createDeleteForm($trail);
        $editForm = $this->createFormBuilder($trail)
            -> add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'), 'label' => 'Nazwa'))
            -> add('startPoint', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'), 'label' => 'Punkt początkowy'))
            -> add('finalPoint', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'), 'label' => 'Punkt końcowy'))
            -> add('colour', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'), 'label' => 'Kolor'))
            -> add('difficulty', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px'), 'label' => 'Czas'))
            -> getForm();
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('trail_edit', array('id' => $trail->getId()));
        }

        return $this->render('trail/edit.html.twig', array(
            'trail' => $trail,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a trail entity.
     *
     * @Route("/{id}", name="trail_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Trail $trail)
    {
        $form = $this->createDeleteForm($trail);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($trail);
            $em->flush();
        }

        return $this->redirectToRoute('trail_index');
    }

    /**
     * Creates a form to delete a trail entity.
     *
     * @param Trail $trail The trail entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Trail $trail)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trail_delete', array('id' => $trail->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
