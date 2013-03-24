<?php

namespace Pwc\SirBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pwc\SirBundle\Entity\OwaspSet;
use Pwc\SirBundle\Form\OwaspSetType;

/**
 * OwaspSet controller.
 *
 * @Route("/settings/owaspset")
 */
class OwaspSetController extends Controller
{
    protected $title = "Settings";

    /**
     * Lists all OwaspSet entities.
     *
     * @Route("/", name="owaspset")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pc = $this->get('pagination_checker');
        $pc->addAllowedFieldName('name');

        $pc->setPaginatedSubject($pc->isSortable() ? $em->getRepository('PwcSirBundle:OwaspSet')->findAllSorted($pc->getSortField(), $pc->getSortDirection()) : $em->getRepository('PwcSirBundle:OwaspSet')->findAll());

        $deleteForm = $this->createDeleteForm('');

        return array(
            'title'      => $this->title,
            'subtitle'   => $this->get('translator')->trans('form.general.subtitle.management', array('%type%' => 'OWASP List')),
            'pagination' => $pc->getPagination(),
            'delete_form' => $deleteForm->createView()
        );
    }

    /**
     * Creates a new OwaspSet entity.
     *
     * @Route("/", name="owaspset_create")
     * @Method("POST")
     * @Template("PwcSirBundle:OwaspSet:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new OwaspSet();

        for ($i = 1; $i <= 10; $i++)
        {
            $owaspitem = new \Pwc\SirBundle\Entity\OwaspItem();
            $owaspitem->setRank($i);
            $entity->addOwaspItem($owaspitem);
        }

        $form = $this->createForm(new OwaspSetType(), $entity);
        $form->bind($request);

        //var_dump($entity); exit();
        //var_dump($request->request->get('pwc_sirbundle_owaspsettype')); exit();

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('owaspset_show', array('slug' => $entity->getSlug())));
        }

        $this->get('session')->getFlashBag()->add('warning', 'form.general.flash.save_unable');

        return array(
            'entity'      => $entity,
            'form'        => $form->createView(),
            'title'       => $this->title,
            'subtitle'    => $this->get('translator')->trans('form.general.subtitle.new', array('%type%' => 'OWASP List'))
        );
    }

    /**
     * Displays a form to create a new OwaspSet entity.
     *
     * @Route("/new", name="owaspset_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new OwaspSet();

        for ($i = 1; $i <= 10; $i++)
        {
            $owaspitem = new \Pwc\SirBundle\Entity\OwaspItem();
            $owaspitem->setRank($i);
            $entity->addOwaspItem($owaspitem);
        }

        $form = $this->createForm(new OwaspSetType(), $entity);

        return array(
            'entity'      => $entity,
            'title'       => $this->title,
            'subtitle'    => $this->get('translator')->trans('form.general.subtitle.new', array('%type%' => 'OWASP List')),
            'form'        => $form->createView()
        );
    }

    /**
     * Finds and displays a OwaspSet entity.
     *
     * @Route("/{slug}", name="owaspset_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:OwaspSet')->findOneBySlug($slug);

        if (!$entity) throw $this->createNotFoundException('Unable to find OwaspSet entity.');

        $deleteForm = $this->createDeleteForm($entity->getSlug());

        return array(
            'entity'      => $entity,
            'title'       => $this->title,
            'subtitle'    => $this->get('translator')->trans('form.general.subtitle.details', array('%type%' => 'OWASP List')),
            'delete_form' => $deleteForm->createView()
        );
    }

    /**
     * Displays a form to edit an existing OwaspSet entity.
     *
     * @Route("/{slug}/edit", name="owaspset_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:OwaspSet')->findOneBySlug($slug);

        if (!$entity) throw $this->createNotFoundException('Unable to find OwaspSet entity.');

        $editForm = $this->createForm(new OwaspSetType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'title'       => $this->title,
            'subtitle'    => $this->get('translator')->trans('form.general.subtitle.edit', array('%type%' => 'OWASP List'))
        );
    }

    /**
     * Edits an existing OwaspSet entity.
     *
     * @Route("/{slug}", name="owaspset_update")
     * @Method("PUT")
     * @Template("PwcSirBundle:OwaspSet:edit.html.twig")
     */
    public function updateAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:OwaspSet')->findOneBySlug($slug);

        if (!$entity) throw $this->createNotFoundException('Unable to find OwaspSet entity.');

        $editForm = $this->createForm(new OwaspSetType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('owaspset_show', array('slug' => $entity->getSlug())));
        }

        $this->get('session')->getFlashBag()->add('warning', 'form.general.flash.save_unable');

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'title'       => $this->title,
            'subtitle'    => $this->get('translator')->trans('form.general.subtitle.edit', array('%type%' => 'OWASP List'))
        );
    }

    /**
     * Deletes a OwaspSet entity.
     *
     * @Route("/{slug}", name="owaspset_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $slug)
    {
        $form = $this->createDeleteForm($slug);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PwcSirBundle:OwaspSet')->findOneBySlug($slug);

            if (!$entity) throw $this->createNotFoundException('Unable to find OwaspSet entity.');

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('owaspset'));
    }

    /**
     * Creates a form to delete a OwaspSet entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($slug)
    {
        return $this->createFormBuilder(array('slug' => $slug))
            ->add('slug', 'hidden')
            ->getForm();
    }
}
