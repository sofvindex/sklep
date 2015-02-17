<?php

namespace SklepBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use SklepBundle\Entity\Review;
use SklepBundle\Form\ReviewType;

/**
 * Review controller.
 *
 * @Route("/review")
 */
class ReviewController extends Controller
{

    /**
     * Lists all Review entities.
     *
     * @Route("/", name="review")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SklepBundle:Review')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Review entity.
     *
     * @Route("/", name="review_create")
     * @Method("POST")
     * @Template("SklepBundle:Review:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Review();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return new Response(json_encode(array('ok' => 1)));
        }

        return new Response(json_encode(array('ok' => 0)));
    }

    /**
     * Creates a form to create a Review entity.
     *
     * @param Review $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Review $entity)
    {
        $form = $this->createForm(new ReviewType(), $entity, array(
            'action' => $this->generateUrl('review_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Review entity.
     *
     * @Route("/new", name="review_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Review();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Pokazuje receznje do konkretnego filmu
     *
     * @Route("/{id}", name="review_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = new Review();
        // Ustawianie filmu
        $movie = $em->getRepository('SklepBundle:Movie')->find($id);
        $entity->setMovie($movie);
        
        $form   = $this->createCreateForm($entity);

        

        $entities = $em->getRepository('SklepBundle:Review')->findByMovie($id);
        //\Doctrine\Common\Util\Debug::dump($entity);

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'entities'      => $entities,
            'delete_form' => $deleteForm->createView(),
            'movie' => $movie
        );
    }

    /**
     * Displays a form to edit an existing Review entity.
     *
     * @Route("/{id}/edit", name="review_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SklepBundle:Review')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Review entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Review entity.
    *
    * @param Review $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Review $entity)
    {
        $form = $this->createForm(new ReviewType(), $entity, array(
            'action' => $this->generateUrl('review_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Review entity.
     *
     * @Route("/{id}", name="review_update")
     * @Method("PUT")
     * @Template("SklepBundle:Review:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SklepBundle:Review')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Review entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('review_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Review entity.
     *
     * @Route("/{id}", name="review_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SklepBundle:Review')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Review entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('review'));
    }

    /**
     * Creates a form to delete a Review entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('review_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
