<?php

namespace Pwc\SirBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pwc\SirBundle\Entity\OwaspItem;
use Pwc\SirBundle\Form\OwaspItemType;

/**
 * OwaspItem controller.
 *
 * @Route("/owaspitem")
 */
class OwaspItemController extends Controller
{
    /**
     * Lists all OwaspItem entities.
     *
     * @Route("/", name="owaspitem")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PwcSirBundle:OwaspItem')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a OwaspItem entity.
     *
     * @Route("/{id}/show", name="owaspitem_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:OwaspItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OwaspItem entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new OwaspItem entity.
     *
     * @Route("/new", name="owaspitem_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new OwaspItem();
        $form   = $this->createForm(new OwaspItemType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new OwaspItem entity.
     *
     * @Route("/create", name="owaspitem_create")
     * @Method("POST")
     * @Template("PwcSirBundle:OwaspItem:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new OwaspItem();
        $form = $this->createForm(new OwaspItemType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('owaspitem_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing OwaspItem entity.
     *
     * @Route("/{id}/edit", name="owaspitem_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:OwaspItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OwaspItem entity.');
        }

        $editForm = $this->createForm(new OwaspItemType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing OwaspItem entity.
     *
     * @Route("/{id}/update", name="owaspitem_update")
     * @Method("POST")
     * @Template("PwcSirBundle:OwaspItem:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:OwaspItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OwaspItem entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new OwaspItemType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('owaspitem_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a OwaspItem entity.
     *
     * @Route("/{id}/delete", name="owaspitem_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PwcSirBundle:OwaspItem')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find OwaspItem entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('owaspitem'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
