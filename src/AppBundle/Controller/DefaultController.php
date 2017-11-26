<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Trail;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/about", name="homepageAbout")
     */
    public function aboutAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/about.html.twig');
    }

    /**
     * @Route("/gallery", name="homepageGallery")
     */
    public function galleryAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/gallery.html.twig');
    }
    /**
     * @Route("/trails", name="homepageTrails")
     */
    public function trailsAction(Request $request)
    {
        $trails = $this->getDoctrine()
            ->getRepository('AppBundle:Trail')
            ->findAll();
        // replace this example code with whatever you need
        return $this->render('default/trails.html.twig', array(
            'trails' => $trails
        ));
    }
    /**
     * @Route("/createtrail", name="createTrail")
     */
    public function createTrailAction(Request $request)
    {
        $trail = new Trail;
        $form = $this->createFormBuilder($trail)
            -> add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            -> add('startPoint', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            -> add('finalPoint', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            -> add('colour', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            -> add('difficulty', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            -> add('save', SubmitType::class, array('label' => 'Create Trail', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
            -> getForm();

        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // Get Data
            $name = $form['name']->getData();
            $startPoint = $form['startPoint']->getData();
            $finalPoint = $form['finalPoint']->getData();
            $colour = $form['colour']->getData();
            $difficulty = $form['difficulty']->getData();

            $trail->setName($name);
            $trail->setStartPoint($startPoint);
            $trail->setFinalPoint($finalPoint);
            $trail->setColour($colour);
            $trail->setDifficulty($difficulty);

            $em = $this->getDoctrine()->getManager();
            $em->persist($trail);
            $em->flush();
            $this->addFlash(
                'notice',
                'Trail Added'
            );

            return $this->redirectToRoute('homepageTrails');
        }

        // replace this example code with whatever you need
        return $this->render('default/createtrail.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/traildetails/{id}", name="trailDetails")
     */
    public function trailDetailsAction($id)
    {
        $trail = $this->getDoctrine()
            ->getRepository('AppBundle:Trail')
            ->find($id);
        // replace this example code with whatever you need
        return $this->render('default/traildetails.html.twig', array(
            'trail' => $trail
        ));


    }

    /**
     * @Route("/deletetrail/{id}", name="deleteTrail")
     */
    public function deleteTrailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $trail = $em->getRepository('AppBundle:Trail')->find($id);

        $em->remove($trail);
        $em->flush();

        $this->addFlash(
            'notice',
            'Trail Removed'
        );

        return $this->redirectToRoute('homepageTrails');

    }

    /**
     * @Route("/edittrail/{id}", name="editTrail")
     */
    public function editTrailAction($id, Request $request)
    {
        $trail = $this->getDoctrine()
            ->getRepository('AppBundle:Trail')
            ->find($id);

        $trail->setName($trail->getName());
        $trail->setStartPoint($trail->getStartPoint());
        $trail->setFinalPoint($trail->getFinalPoint());
        $trail->setColour($trail->getColour());
        $trail->setDifficulty($trail->getDifficulty());

        $form = $this->createFormBuilder($trail)
            -> add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            -> add('startPoint', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            -> add('finalPoint', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            -> add('colour', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            -> add('difficulty', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            -> add('save', SubmitType::class, array('label' => 'Edytuj Szlak', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
            -> getForm();

        $form -> handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // Get Data
            $name = $form['name']->getData();
            $startPoint = $form['startPoint']->getData();
            $finalPoint = $form['finalPoint']->getData();
            $colour = $form['colour']->getData();
            $difficulty = $form['difficulty']->getData();

            $em = $this->getDoctrine()->getManager();
            $trail = $em->getRepository('AppBundle:Trail')->find($id);

            $trail->setName($name);
            $trail->setStartPoint($startPoint);
            $trail->setFinalPoint($finalPoint);
            $trail->setColour($colour);
            $trail->setDifficulty($difficulty);



            $em->flush();
            $this->addFlash(
                'notice',
                'Trail Updated'
            );

            return $this->redirectToRoute('homepageTrails');
        }
        // replace this example code with whatever you need
        return $this->render('default/edittrail.html.twig', array(
            'trail' => $trail,
            'form' => $form->createView()
        ));


    }
    /**
     * @Route("/maps", name="homepageMaps")
     */
    public function mapsAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/maps.html.twig');
    }

    /**
     * @Route("/", name="homepageLogin")
     */
    public function loginAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/login.html.twig');
    }

}
