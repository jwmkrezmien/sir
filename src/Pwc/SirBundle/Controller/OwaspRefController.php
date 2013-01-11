<?php

namespace Pwc\SirBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pwc\SirBundle\Entity\OwaspRef;
use Pwc\SirBundle\Form\OwaspRefType;

/**
 * OwaspRef controller.
 *
 * @Route("/owaspref")
 */
class OwaspRefController extends Controller
{
    /**
     * Lists all OwaspRef entities.
     *
     * @Route("/", name="owaspref")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('PwcSirBundle:OwaspRef')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a OwaspRef entity.
     *
     * @Route("/{id}/show", name="owaspref_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:OwaspRef')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OwaspRef entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new OwaspRef entity.
     *
     * @Route("/new", name="owaspref_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new OwaspRef();
        $form   = $this->createForm(new OwaspRefType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a new OwaspRef entity.
     *
     * @Route("/create", name="owaspref_create")
     * @Method("POST")
     * @Template("PwcSirBundle:OwaspRef:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new OwaspRef();
        $form = $this->createForm(new OwaspRefType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('owaspref_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing OwaspRef entity.
     *
     * @Route("/{id}/edit", name="owaspref_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:OwaspRef')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OwaspRef entity.');
        }

        $editForm = $this->createForm(new OwaspRefType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing OwaspRef entity.
     *
     * @Route("/{id}/update", name="owaspref_update")
     * @Method("POST")
     * @Template("PwcSirBundle:OwaspRef:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:OwaspRef')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OwaspRef entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new OwaspRefType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('owaspref_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a OwaspRef entity.
     *
     * @Route("/{id}/delete", name="owaspref_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PwcSirBundle:OwaspRef')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find OwaspRef entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('owaspref'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
