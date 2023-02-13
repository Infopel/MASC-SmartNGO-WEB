<?php

namespace App\Models;

class Boot{

    protected $project_id;
    protected $project_identifier;
    protected $project_name;
    protected $modules;

    /**
     * Get the value of project_id
     */
    public function getProject_id()
    {
        return $this->project_id;
    }

    /**
     * Set the value of project_id
     *
     * @return  self
     */
    public function setProject_id($project_id)
    {
        $this->project_id = $project_id;

        return $this;
    }

    /**
     * Get the value of project_identifier
     */
    public function getProject_identifier()
    {
        return $this->project_identifier;
    }

    /**
     * Set the value of project_identifier
     *
     * @return  self
     */
    public function setProject_identifier($project_identifier)
    {
        $this->project_identifier = $project_identifier;

        return $this;
    }

    /**
     * Get the value of project_name
     */
    public function getProject_name()
    {
        return $this->project_name;
    }

    /**
     * Set the value of project_name
     *
     * @return  self
     */
    public function setProject_name($project_name)
    {
        $this->project_name = $project_name;

        return $this;
    }

    /**
     * Get the value of modules
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * Set the value of modules
     *
     * @return  self
     */
    public function setModules($modules)
    {
        $this->modules = $modules;

        return $this;
    }
}
