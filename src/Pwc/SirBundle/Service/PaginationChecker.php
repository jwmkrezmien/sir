<?php

namespace Pwc\SirBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session,
    Symfony\Component\HttpFoundation\Request;

class PaginationChecker
{
    protected $session;

    protected $request;

    protected $settings;

    protected $default;

    protected $array;

    protected $allowedFieldNames = array();

    public function __construct(Session $session, Request $request)
    {
        $this->session = $session;
        $this->request = $request;

        $this->default['page_name'] = 1;
        $this->default['sort_field_name'] = false;
        $this->default['sort_direction_name'] = 'asc';
    }

    public function getPageLimit()
    {
        return $this->settings['page_limit'];
    }

    public function setAllowedFieldNames(array $array = array())
    {
        $this->allowedFieldNames = $array;
    }

    public function validRequest()
    {
        $result = true;

        // check whether a valid page number is provided
        if (!$this->validPage())
        {
            $this->session->getFlashBag()->add('warning', 'Invalid page name');
            $result = false;
        }

        if(!$this->validSortCombination()) $result = false;

        return $result;
    }

    public function validSortCombination()
    {
        $result = true;

        // check whether a valid sort field is provided
        if (!$this->validSortField())
        {
            $this->session->getFlashBag()->add('warning', 'Invalid sort field');
            $result = false;

            // if a valid name is provided for the name of the sorted field, check whether the direction is correct
        }elseif (!$this->validSortDirection())
        {
            $this->session->getFlashBag()->add('success', 'Invalid sort direction');
            $result = false;
        }

        return $result;
    }

    public function getPage()
    {
        return ($this->validPage() ? $this->getRequestParamValue('page_name') : $this->default['page_name']);
    }

    public function getSortDirection()
    {
        return ($this->validSortDirection() ? $this->getRequestParamValue('sort_direction_name') : $this->default['sort_direction_name']);
    }

    public function getSortField()
    {
        return ($this->validSortField() ? $this->getRequestParamValue('sort_field_name') : isset($this->allowedFieldNames[0]) ? $this->allowedFieldNames[0] : $this->default['sort_field_name']);
    }

    protected function validPage()
    {
        return is_numeric($this->getRequestParamValue('page_name')) && $this->getRequestParamValue('page_name') <= ceil(count($this->array) / $this->settings['page_limit']) ? true : false;
    }

    protected function validSortField()
    {
        return in_array($this->getRequestParamValue('sort_field_name'), $this->allowedFieldNames);
    }

    protected function validSortDirection()
    {
        return $this->getRequestParamValue('sort_direction_name') == 'asc' ||
               $this->getRequestParamValue('sort_direction_name') == 'desc' ? true : false;
    }

    protected function getRequestParamValue($param)
    {
        return $this->request->query->get($this->settings[$param], $this->default[$param]);
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