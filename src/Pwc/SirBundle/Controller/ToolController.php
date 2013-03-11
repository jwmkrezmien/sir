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
 * @Route("/settings/tool")
 */
class ToolController extends Controller
{
    protected $title = "Settings";

    /**
     * Lists all Tool entities.
     *
     * @Route("/", name="tool")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $pc = $this->get('pagination_checker');
        $pc->addAllowedFieldName('name');

        $pc->setPaginatedSubject($pc->isSortable() ? $em->getRepository('PwcSirBundle:Tool')->findAllSorted($pc->getSortField(), $pc->getSortDirection()) : $em->getRepository('PwcSirBundle:Tool')->findAll());

        $deleteForm = $this->createDeleteForm('');

        return array(
            'title'      => $this->title,
            'subtitle'   => $this->get('translator')->trans('form.general.subtitle.management', array('%type%' => 'Tool')),
            'pagination' => $pc->getPagination(),
            'delete_form' => $deleteForm->createView()
        );
    }

    /**
     * Finds and displays a Tool entity.
     *
     * @Route("/{slug}/show", name="tool_show")
     * @Template()
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:Tool')->findOneBySlug($slug);

        if (!$entity) throw $this->createNotFoundException('Unable to find Tool entity.');

        $deleteForm = $this->createDeleteForm($entity->getSlug());

        return array(
            'entity'      => $entity,
            'title'       => $this->title,
            'subtitle'    => $this->get('translator')->trans('form.general.subtitle.details', array('%type%' => 'Tool')),
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
            'entity'      => $entity,
            'title'       => $this->title,
            'subtitle'    => $this->get('translator')->trans('form.general.subtitle.new', array('%type%' => 'Tool')),
            'form'        => $form->createView()
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
        $entity = new Tool();
        $form = $this->createForm(new ToolType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            foreach($entity->getProducts() as $product)
            {
                $product->addTool($entity);
                $em->persist($product);
            }

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tool_show', array('slug' => $entity->getSlug())));
        }

        $this->get('session')->getFlashBag()->add('warning', 'form.general.flash.save_unable');

        return array(
            'entity'      => $entity,
            'form'        => $form->createView(),
            'title'       => $this->title,
            'subtitle'    => $this->get('translator')->trans('form.general.subtitle.new', array('%type%' => 'Tool'))
        );
    }

    /**
     * Displays a form to edit an existing Tool entity.
     *
     * @Route("/{slug}/edit", name="tool_edit")
     * @Template()
     */
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:Tool')->findOneBySlug($slug);

        if (!$entity) throw $this->createNotFoundException('Unable to find Tool entity.');

        $editForm = $this->createForm(new ToolType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'title'       => $this->title,
            'subtitle'    => $this->get('translator')->trans('form.general.subtitle.edit', array('%type%' => 'Tool'))
        );
    }

    /**
     * Edits an existing Tool entity.
     *
     * @Route("/{slug}/update", name="tool_update")
     * @Method("POST")
     * @Template("PwcSirBundle:Tool:edit.html.twig")
     */
    public function updateAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:Tool')->findOneBySlug($slug);

        if (!$entity) throw $this->createNotFoundException('Unable to find Tool entity.');

        $products = array();
        foreach ($entity->getProducts() as $product) $products[] = $product;

        $editForm = $this->createForm(new ToolType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid())
        {
            // filter tools that are no longer present
            foreach ($entity->getProducts() as $product)
            {
                foreach ($products as $key => $toDel) if ($toDel->getId() === $product->getId()) unset($products[$key]);
            }

            //var_dump($entity->getProducts());

            // remove the relationship
            foreach ($products as $product)
            {
                $product->getTools()->removeElement($entity);
                $em->persist($product);
            }

            //var_dump($entity->getProducts()); exit();

            foreach($entity->getProducts() as $product)
            {
                $product->addTool($entity);
                $em->persist($product);
            }

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('tool_show', array('slug' => $entity->getSlug())));
        }

        $this->get('session')->getFlashBag()->add('warning', 'form.general.flash.save_unable');

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'title'       => $this->title,
            'subtitle'    => $this->get('translator')->trans('form.general.subtitle.edit', array('%type%' => 'Tool'))
        );
    }

    /**
     * Deletes a Tool entity.
     *
     * @Route("/{slug}/delete", name="tool_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $slug)
    {
        $form = $this->createDeleteForm($slug);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PwcSirBundle:Tool')->findOneBySlug($slug);

            if (!$entity) throw $this->createNotFoundException('Unable to find Tool entity.');

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('tool'));
    }

    private function createDeleteForm($slug)
    {
        return $this->createFormBuilder(array('slug' => $slug))
            ->add('slug', 'hidden')
            ->getForm();
    }
}
