<?php

namespace Pwc\SirBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pwc\SirBundle\Entity\VulnRef;
use Pwc\SirBundle\Form\VulnRefType;

/**
 * VulnRef controller.
 *
 * @Route("/vulnref")
 */
class VulnRefController extends Controller
{
    /**
     * Lists all VulnRef entities.
     *
     * @Route("/", name="vulnref")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PwcSirBundle:VulnRef')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a VulnRef entity.
     *
     * @Route("/{id}/show", name="vulnref_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:VulnRef')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VulnRef entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new VulnRef entity.
     *
     * @Route("/new", name="vulnref_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new VulnRef();
        $form   = $this->createForm(new VulnRefType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new VulnRef entity.
     *
     * @Route("/create", name="vulnref_create")
     * @Method("POST")
     * @Template("PwcSirBundle:VulnRef:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new VulnRef();
        $form = $this->createForm(new VulnRefType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vulnref_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing VulnRef entity.
     *
     * @Route("/{id}/edit", name="vulnref_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:VulnRef')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VulnRef entity.');
        }

        $editForm = $this->createForm(new VulnRefType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing VulnRef entity.
     *
     * @Route("/{id}/update", name="vulnref_update")
     * @Method("POST")
     * @Template("PwcSirBundle:VulnRef:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:VulnRef')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find VulnRef entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new VulnRefType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vulnref_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a VulnRef entity.
     *
     * @Route("/{id}/delete", name="vulnref_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PwcSirBundle:VulnRef')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find VulnRef entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('vulnref'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
