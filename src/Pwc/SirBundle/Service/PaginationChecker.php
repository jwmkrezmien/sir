<?php

namespace Pwc\SirBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Bundle\FrameworkBundle\Translation\Translator;

use Knp\Component\Pager\Paginator;

class PaginationChecker
{
    protected $session;

    protected $translator;

    protected $request;

    protected $settings;

    protected $default;

    protected $array;

    protected $allowedFieldNames = array();

    protected $paginator;

    public function __construct(Session $session, Translator $translator, Request $request, Paginator $paginator)
    {
        $this->session = $session;
        $this->translator = $translator;
        $this->request = $request;
        $this->paginator = $paginator;

        $this->default['page_name'] = 1;
        $this->default['sort_field_name'] = false;
        $this->default['sort_direction_name'] = 'asc';
    }

    public function getPagination($notifyByFlash = true)
    {
        $pagination = $this->paginator->paginate(
            $this->array,
            $this->getPage(),
            $this->getPageLimit()
        );

        $this->validateRequest($notifyByFlash);

        $pagination->setParam('sort', empty($this->allowedFieldNames) ? null : $this->getSortField());
        $pagination->setParam('direction', empty($this->allowedFieldNames) ? null : $this->getSortDirection());

        return $pagination;
    }

    protected function getPageLimit()
    {
        return $this->settings['page_limit'];
    }

    public function addAllowedFieldName($field)
    {
        if(is_string($field)) $this->allowedFieldNames[] = $field;
    }

    public function isSortable()
    {
        return !empty($this->allowedFieldNames) ? true: false;
    }

    protected function validateRequest($notifyByFlash = true)
    {
        if(!$this->validInputPage($notifyByFlash)) $result = false;
        if(!empty($this->allowedFieldNames) && !$this->validInputSortCombination($notifyByFlash)) $result = false;

        return isset($result) ? $result : true;
    }

    protected function validInputPage($notifyByFlash = true)
    {
        // check whether a valid page number is provided
        if(is_null($this->getRequestParamValue('page_name')))
        {
            $result = true;

        }else
        {
            if ($this->validPage())
            {
                $result = true;

            }else
            {
                if ($notifyByFlash) $this->session->getFlashBag()->add('warning', $this->translator->trans('form.general.flash.invalid_page'));
                $result = false;
            }
        }

        return $result;
    }

    protected function validInputSortCombination($notifyByFlash = true)
    {
        // check whether a valid sort field is provided
        if(is_null($this->getRequestParamValue('sort_field_name')) && is_null($this->getRequestParamValue('sort_direction_name')))
        {
            if ($notifyByFlash) $this->session->getFlashBag()->add('info', $this->translator->trans('form.general.flash.sorted_by_default', array('%field%' => $this->getSortField())));
            $result = true;

        }elseif(!is_null($this->getRequestParamValue('sort_field_name')) && is_null($this->getRequestParamValue('sort_direction_name')))
        {
            if ($notifyByFlash) $this->session->getFlashBag()->add('warning', $this->translator->trans('form.general.flash.direction_not_provided', array('%field%' => $this->getSortField())));
            $result = false;

        }elseif(is_null($this->getRequestParamValue('sort_field_name')) && !is_null($this->getRequestParamValue('sort_direction_name')))
        {
            if ($notifyByFlash) $this->session->getFlashBag()->add('warning', $this->translator->trans('form.general.flash.field_not_provided', array('%field%' => $this->getSortField())));
            $result = false;

        }elseif(!is_null($this->getRequestParamValue('sort_field_name')) && !is_null($this->getRequestParamValue('sort_direction_name')))
        {
            $result = true;

            if (!$this->validSortField())
            {
                if ($notifyByFlash) $this->session->getFlashBag()->add('warning', $this->translator->trans('form.general.flash.invalid_sort_field', array('%field%' => $this->getSortField())));
                $result = false;
            }

            if (!$this->validSortDirection())
            {
                if ($notifyByFlash) $this->session->getFlashBag()->add('warning', $this->translator->trans('form.general.flash.invalid_sort_direction', array('%field%' => $this->getSortField())));
                $result = false;

            }
        }

        return $result;
    }

    public function getPage()
    {
        return !is_null($this->getRequestParamValue('page_name')) && $this->validPage() ? $this->getRequestParamValue('page_name') : $this->default['page_name'];
    }

    protected function validPage()
    {
        // page is valid when (1) no page is provided,
        // or (2) when a page is provided, which is numeric and in range
        return is_numeric($this->getRequestParamValue('page_name')) && $this->getRequestParamValue('page_name') <= ceil(count($this->array) / $this->settings['page_limit']) ? true : false;
    }

    public function getSortField()
    {
        return ($this->validSortField() ? $this->getRequestParamValue('sort_field_name') : !empty($this->allowedFieldNames) &&  isset($this->allowedFieldNames[0]) ? $this->allowedFieldNames[0] : $this->default['sort_field_name']);
    }

    protected function validSortField()
    {
        return in_array($this->getRequestParamValue('sort_field_name'), $this->allowedFieldNames);
    }

    public function getSortDirection()
    {
        return ($this->validSortDirection() ? $this->getRequestParamValue('sort_direction_name') : $this->default['sort_direction_name']);
    }

    protected function validSortDirection()
    {
        return $this->getRequestParamValue('sort_direction_name') == 'asc' ||
               $this->getRequestParamValue('sort_direction_name') == 'desc' ? true : false;
    }

    protected function getRequestParamValue($param)
    {
        return $this->request->query->get($this->settings[$param]);
    }

    /**
     * Set the complete array to paginate
     *
     * @param array $array
     */
    public function setPaginatedSubject(array $array = array())
    {
        $this->array = $array;
    }

    /**
     * Set the page name
     *
     * @param string $name
     */
    public function setPageName($name)
    {
        $this->settings['page_name'] = $name;
    }

    /**
     * Set the page name
     *
     * @param string $limit
     */
    public function setPageLimit($limit)
    {
        $this->settings['page_limit'] = $limit;
    }

    /**
     * Set the sort field name
     *
     * @param string $name
     */
    public function setSortFieldName($name)
    {
        $this->settings['sort_field_name'] = $name;
    }

    /**
     * Set direction name
     *
     * @param string $name
     */
    public function setDirectionName($name)
    {
        $this->settings['sort_direction_name'] = $name;
    }
}