<?php

namespace Pwc\SirBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pwc\SirBundle\Entity\VulnDescription;
use Pwc\SirBundle\Form\VulnDescriptionType;

/**
 * VulnDescription controller.
 *
 * @Route("/vulndescription")
 */
class VulnDescriptionController extends Controller
{
    /**
     * Lists all VulnDescription entities.
     *
     * @Route("/", name="vulndescription")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PwcSirBundle:VulnDescription')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a VulnDescription entity.
     *
     * @Route("/{id}/show", name="vulndescription_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:VulnDescription')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VulnDescription entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new VulnDescription entity.
     *
     * @Route("/new", name="vulndescription_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new VulnDescription();
        $form   = $this->createForm(new VulnDescriptionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new VulnDescription entity.
     *
     * @Route("/create", name="vulndescription_create")
     * @Method("POST")
     * @Template("PwcSirBundle:VulnDescription:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new VulnDescription();
        $form = $this->createForm(new VulnDescriptionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vulndescription_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing VulnDescription entity.
     *
     * @Route("/{id}/edit", name="vulndescription_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:VulnDescription')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VulnDescription entity.');
        }

        $editForm = $this->createForm(new VulnDescriptionType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing VulnDescription entity.
     *
     * @Route("/{id}/update", name="vulndescription_update")
     * @Method("POST")
     * @Template("PwcSirBundle:VulnDescription:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:VulnDescription')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VulnDescription entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new VulnDescriptionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vulndescription_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a VulnDescription entity.
     *
     * @Route("/{id}/delete", name="vulndescription_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PwcSirBundle:VulnDescription')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find VulnDescription entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('vulndescription'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
