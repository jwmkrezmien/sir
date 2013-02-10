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
     * @Route("/show/{slug}", name="description_show")
     * @Template()
     */
    public function showAction($slug)
    {
        /*
                $em = $this->getDoctrine()->getManager();

                // get all the languages
                $languages = $em->getRepository('PwcSirBundle:Language')->findAll();

                // walk through the array and check whether one corresponds with the slug provided in the route
                foreach($languages as $language)
                {
                    if($language->getSlug() == $languageSlug)
                    {
                        $languageFound = true;
                        $language->setActive(true);
                        break;
                    }
                };

                // if the language's slug was not found, throw an exception
                if (!isset($languageFound)) throw $this->createNotFoundException('Unable to find Language entity.');
        */

        /*
        $entity = $em->getRepository('PwcSirBundle:Vulnerability')->findOneBySlugWithJoins($slug);
        if (!$entity) throw $this->createNotFoundException('Unable to find Vulnerability entity.');

        // walk through the array and set any language as available
        array_walk($languages, function (&$object, $key, $entity) {

            foreach($entity->getVulnDescriptions() as $description)
            {
                if($description->getLanguage()->getId() == $object->getId()) $object->setAvailable(false);
            }

        }, $entity);

        foreach($entity->getVulnDescriptions() as $description)
        {
            if($description->getLanguage() == $language)
            {
                $descriptionFound = true;
                break;
            }
        }

        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity'       => $entity,
            'description'  => isset($descriptionFound) ? $description : null,
            'languages'    => $languages,
            'language'     => $language,
            'delete_form'  => $deleteForm->createView(),
        );
*/


        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('PwcSirBundle:VulnDescription')->findOneBySlug($slug);

        if (!$entity) throw $this->createNotFoundException('Unable to find VulnDescription entity.');

        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to create a new VulnDescription entity.
     *
     * @Route("/new/{languageSlug}/{slug}", name="description_new")
     * @Template()
     */
    public function newAction($languageSlug, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $vulnerability = $em->getRepository('PwcSirBundle:Vulnerability')->findOneBySlug($slug);
        if (!$vulnerability) throw $this->createNotFoundException('Unable to find Vulnerability entity.');

        $language = $em->getRepository('PwcSirBundle:Language')->findOneBySlug($languageSlug);
        if (!$language) throw $this->createNotFoundException('Unable to find Language entity.');

        $entity = new VulnDescription();
        $entity->setVulnerability($vulnerability);
        $entity->setLanguage($language);
        $form = $this->createForm(new VulnDescriptionType(), $entity);

        return array(
            'entity'        => $entity,
            'form'          => $form->createView(),
            'language'      => $language,
            'vulnerability' => $vulnerability,
        );
    }

    /**
     * Creates a new VulnDescription entity.
     *
     * @Route("/create/{language}/{slug}", name="vulndescription_create")
     * @Method("POST")
     * @Template("PwcSirBundle:VulnDescription:new.html.twig")
     */
    public function createAction(Request $request, $language, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $vulnerability = $em->getRepository('PwcSirBundle:Vulnerability')->findOneBySlug($slug);
        if (!$vulnerability) throw $this->createNotFoundException('Unable to find Vulnerability entity.');

        $language = $em->getRepository('PwcSirBundle:Language')->findOneBySlug($language);
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

            return $this->redirect($this->generateUrl('vulnerability_show', array('slug' => $vulnerability->getSlug(), 'languageSlug' => $language->getSlug())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
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

        if (!$entity) throw $this->createNotFoundException('Unable to find VulnDescription entity.');

        $editForm = $this->createForm(new VulnDescriptionType(), $entity);
        $deleteForm = $this->createDeleteForm($entity->getSlug());

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

        if (!$entity) throw $this->createNotFoundException('Unable to find VulnDescription entity.');

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new VulnDescriptionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('vulnerability_show', array('slug' => $entity->getVulnerability()->getSlug(), 'languageSlug' => $entity->getLanguage()->getSlug())));
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
     * @Route("/{slug}/delete", name="vulndescription_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $slug)
    {
        $form = $this->createDeleteForm($slug);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('PwcSirBundle:VulnDescription')->findOneBySlug($slug);

            if (!$entity) throw $this->createNotFoundException('Unable to find VulnDescription entity.');

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('vulnerability_show', array('slug' => $entity->getVulnerability()->getSlug(), 'languageSlug' => $entity->getLanguage()->getSlug())));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
