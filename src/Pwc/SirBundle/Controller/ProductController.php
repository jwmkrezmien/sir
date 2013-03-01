<?php

namespace Pwc\SirBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Pwc\SirBundle\Entity\Product;
use Pwc\SirBundle\Form\ProductType;

/**
 * Product controller.
 *
 * @Route("/settings/product")
 */
class ProductController extends Controller
{
    /**
     * Lists all Product entities.
     *
     * @Route("/", name="product")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pc = $this->get('pagination_checker');
        $pc->setAllowedFieldNames(array('name'));

        $entities = ($pc->getSortField() ? $em->getRepository('PwcSirBundle:Product')->findAllSorted($pc->getSortField(), $pc->getSortDirection()) : $em->getRepository('PwcSirBundle:Product')->findAll());

        $pc->setPaginatedSubject($entities);

        $pagination = $this->get('knp_paginator')->paginate(
            $entities,
            $pc->getPage(),
            $pc->getPageLimit()
        );

        return array(
            'title'      => 'Settings',
            'subtitle'   => 'Product management',
            'entities'   => $entities,
            'pagination' => $pagination
        );
    }

    /**
     * Finds and displays a Product entity.
     *
     * @Route("/{slug}/show", name="product_show")
     * @Template()
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:Product')->findOneBySlug($slug);

        if (!$entity) throw $this->createNotFoundException('Unable to find Product entity.');

        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity'      => $entity,
            'title'       => 'Settings',
            'subtitle'    => 'Product details',
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new Product entity.
     *
     * @Route("/new", name="product_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Product();
        $form   = $this->createForm(new ProductType(), $entity);

        return array(
            'entity'      => $entity,
            'title'       => 'Settings',
            'subtitle'    => 'form.label.product._new',
            'form'        => $form->createView(),
        );
    }

    /**
     * Creates a new Product entity.
     *
     * @Route("/create", name="product_create")
     * @Method("POST")
     * @Template("PwcSirBundle:Product:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Product();
        $form = $this->createForm(new ProductType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('product_show', array('slug' => $entity->getSlug())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     * @Route("/{slug}/edit", name="product_edit")
     * @Template()
     */
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:Product')->findOneBySlug($slug);

        if (!$entity) throw $this->createNotFoundException('Unable to find Product entity.');

        $editForm = $this->createForm(new ProductType(), $entity);
        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Product entity.
     *
     * @Route("/{slug}/update", name="product_update")
     * @Method("POST")
     * @Template("PwcSirBundle:Product:edit.html.twig")
     */
    public function updateAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:Product')->findOneBySlug($slug);

        if (!$entity) throw $this->createNotFoundException('Unable to find Product entity.');

        $deleteForm = $this->createDeleteForm($entity->getId());
        $editForm = $this->createForm(new ProductType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('product_show', array('slug' => $entity->getSlug())));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Product entity.
     *
     * @Route("/{slug}/delete", name="product_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $slug)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PwcSirBundle:Product')->findOneBySlug($slug);

            if (!$entity) throw $this->createNotFoundException('Unable to find Product entity.');

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('product'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
