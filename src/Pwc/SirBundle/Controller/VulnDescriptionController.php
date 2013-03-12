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
 * @Route("/vulnerability/description")
 */
class VulnDescriptionController extends Controller
{
    /**
     * Finds and displays a VulnDescription entity.
     *
     * @Route("/show/{slug}", name="description_show")
     * @Template()
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:VulnDescription')->findOneBySlug($slug);

        if (!$entity) throw $this->createNotFoundException('Unable to find Description entity.');

        $deleteForm = $this->createDeleteForm($entity->getSlug());

        return array(
            'entity'        => $entity,
            'vulnerability' => $entity->getVulnerability(),
            'delete_form'   => $deleteForm->createView(),
            'subtitle'      => $this->get('translator')->trans('form.general.subtitle.details', array('%type%' => 'Description'))
        );
    }

    /**
     * Displays a form to create a new VulnDescription entity.
     *
     * @Route("/new/{languageSlug}/{vulnerabilitySlug}", name="description_new")
     * @Template()
     */
    public function newAction($languageSlug, $vulnerabilitySlug)
    {
        $em = $this->getDoctrine()->getManager();

        $vulnerability = $em->getRepository('PwcSirBundle:Vulnerability')->findOneBySlug($vulnerabilitySlug);
        if (!$vulnerability) throw $this->createNotFoundException('Unable to find Vulnerability entity.');

        $language = $em->getRepository('PwcSirBundle:Language')->findOneBySlug($languageSlug);
        if (!$language) throw $this->createNotFoundException('Unable to find Language entity.');

        $entity = new VulnDescription();
        $entity->setVulnerability($vulnerability);
        $entity->setLanguage($language);
        $form = $this->createForm(new VulnDescriptionType(), $entity);

        return array(
            'form'          => $form->createView(),
            'language'      => $language,
            'vulnerability' => $vulnerability,
            'subtitle'      => $this->get('translator')->trans('form.general.subtitle.new', array('%type%' => 'Description'))
        );
    }

    /**
     * Creates a new VulnDescription entity.
     *
     * @Route("/create/{languageSlug}/{vulnerabilitySlug}", name="description_create")
     * @Method("POST")
     * @Template("PwcSirBundle:VulnDescription:new.html.twig")
     */
    public function createAction(Request $request, $languageSlug, $vulnerabilitySlug)
    {
        $em = $this->getDoctrine()->getManager();

        $vulnerability = $em->getRepository('PwcSirBundle:Vulnerability')->findOneBySlug($vulnerabilitySlug);
        if (!$vulnerability) throw $this->createNotFoundException('Unable to find Vulnerability entity.');

        $language = $em->getRepository('PwcSirBundle:Language')->findOneBySlug($languageSlug);
        if (!$language) throw $this->createNotFoundException('Unable to find Language entity.');

        $entity = new VulnDescription();
        $entity->setVulnerability($vulnerability);
        $entity->setLanguage($language);

        $form = $this->createForm(new VulnDescriptionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vulnerability_show', array('slug' => $vulnerability->getSlug())));
        }

        return array(
            'form'          => $form->createView(),
            'language'      => $language,
            'vulnerability' => $vulnerability,
            'subtitle'      => $this->get('translator')->trans('form.general.subtitle.new', array('%type%' => 'Description'))
        );
    }

    /**
     * Displays a form to edit an existing VulnDescription entity.
     *
     * @Route("/{slug}/edit", name="description_edit")
     * @Template()
     */
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:VulnDescription')->findOneBySlug($slug);

        if (!$entity) throw $this->createNotFoundException('Unable to find Description entity.');

        $editForm = $this->createForm(new VulnDescriptionType(), $entity);

        return array(
            'entity'        => $entity,
            'vulnerability' => $entity->getVulnerability(),
            'edit_form'     => $editForm->createView(),
            'subtitle'      => $this->get('translator')->trans('form.general.subtitle.edit', array('%type%' => 'Description'))
        );
    }

    /**
     * Edits an existing VulnDescription entity.
     *
     * @Route("/{slug}/update", name="description_update")
     * @Method("POST")
     * @Template("PwcSirBundle:VulnDescription:edit.html.twig")
     */
    public function updateAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:VulnDescription')->findOneBySlug($slug);

        if (!$entity) throw $this->createNotFoundException('Unable to find Description entity.');

        $editForm = $this->createForm(new VulnDescriptionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('description_show', array('slug' => $entity->getSlug())));
        }

        $this->get('session')->getFlashBag()->add('warning', 'form.general.flash.save_unable');

        return array(
            'entity'        => $entity,
            'vulnerability' => $entity->getVulnerability(),
            'edit_form'     => $editForm->createView(),
            'subtitle'      => $this->get('translator')->trans('form.general.subtitle.edit', array('%type%' => 'Description'))
        );
    }

    /**
     * Deletes a VulnDescription entity.
     *
     * @Route("/{slug}/delete", name="description_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $slug)
    {
        $form = $this->createDeleteForm($slug);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PwcSirBundle:VulnDescription')->findOneBySlug($slug);

            if (!$entity) throw $this->createNotFoundException('Unable to find Description entity.');

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('vulnerability_show', array('slug' => $entity->getVulnerability()->getSlug())));
    }

    private function createDeleteForm($slug)
    {
        return $this->createFormBuilder(array('slug' => $slug))
            ->add('slug', 'hidden')
            ->getForm();
    }
}
