<?php

    class PipitEmails_Email extends PerchAPI_Base {
        protected $pk                  = 'id';
        protected $table               = 'pipit_emails';
        protected $updated_date_column = 'updated';
        

        
        
        /**
         * 
         */
        public function update($data) {
            if (isset($this->updated_date_column)) {
                $data[$this->updated_date_column] = gmdate('Y-m-d H:i:s');
            }

            $result = parent::update($data);

            return $result;
        }




        /**
         * 
         */
        public function to_array(){
            $details = parent::to_array();
            

            if(isset($details['dynamicFields']) && $details['dynamicFields'] != '') {
                $dynamic_fields = PerchUtil::json_safe_decode($details['dynamicFields'], true);

                if (PerchUtil::count($dynamic_fields) && $this->prefix_vars) {
                    foreach($dynamic_fields as $key=>$value) {
                        $details['perch_'.$key] = $value;
                    }
                }

                if (is_array($dynamic_fields)) {
                    $details = array_merge($dynamic_fields, $details);
                }
            }
            
            return $details;
        }
    }