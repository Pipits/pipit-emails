<?php

    class PipitEmails_Emails extends PerchAPI_Factory {
        protected $pk                  = 'id';
        protected $table               = 'pipit_emails';
        protected $default_sort_column = 'created';
        protected $created_date_column = 'created';
        protected $default_sort_direction = 'DESC';
        public $dynamic_fields_column = 'dynamicFields';

        protected $singular_classname  = 'PipitEmails_Email';
        public $static_fields = ['title', 'event', 'template', 'enabled'];
        
        public function create($data) {
            if (isset($this->created_date_column)) {
                $data[$this->created_date_column] = gmdate('Y-m-d H:i:s');
            }

            $Result = parent::create($data);
            if (is_object($Result)) {
                $Result->update($data);
            }

            return $Result;
        }
    }