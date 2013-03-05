<?php

namespace Pwc\SirBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pwc\SirBundle\Entity\Tool;
use Pwc\SirBundle\Form\ToolType;

/**
 * Tool controller.
 *
 * @Route("/tool")
 */
class ToolController extends Controller
{
    /**
     * Lists all Tool entities.
     *
     * @Route("/", name="tool")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PwcSirBundle:Tool')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Tool entity.
     *
     * @Route("/{id}/show", name="tool_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:Tool')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tool entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Tool entity.
     *
     * @Route("/new", name="tool_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Tool();
        $form   = $this->createForm(new ToolType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new Tool entity.
     *
     * @Route("/create", name="tool_create")
     * @Method("POST")
     * @Template("PwcSirBundle:Tool:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Tool();
        $form = $this->createForm(new ToolType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tool_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Tool entity.
     *
     * @Route("/{id}/edit", name="tool_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:Tool')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tool entity.');
        }

        $editForm = $this->createForm(new ToolType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Tool entity.
     *
     * @Route("/{id}/update", name="tool_update")
     * @Method("POST")
     * @Template("PwcSirBundle:Tool:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:Tool')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Tool entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new ToolType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tool_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Tool entity.
     *
     * @Route("/{id}/delete", name="tool_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PwcSirBundle:Tool')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Tool entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tool'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
