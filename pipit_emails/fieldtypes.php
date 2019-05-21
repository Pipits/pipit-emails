<?php
    class PerchFieldType_pipit_email_template extends PerchAPI_FieldType {

        public function render_inputs($details=array()) {
            $items = $this->find_templates();
            
            if ($this->Tag->default() && empty($details)) {
                $details = $this->Tag->default();
            }

            return $this->Form->select($this->Tag->input_id(), $items, $details);
        }
        




        public function get_raw($post=false, $Item=false) {
            if ($post===false) {
                $post = $_POST;
            }

            $id = $this->Tag->id();
            if (isset($post[$id])) {
                $this->raw_item = $post[$id];
                return $this->raw_item;
            }

            return null;
        }




        private function find_templates() {
            $app_templates = $this->get_dir_contents(__DIR__.'/templates/emails');
            $local_templates = $this->get_dir_contents(PERCH_TEMPLATE_PATH.'/emails');

            $templates = array_merge($app_templates, $local_templates);
            sort($templates);
            return $templates;
        }





        private function get_dir_contents($dir) {
            $files = array();

            if (is_dir($dir)) {
                foreach (glob("$dir/*.html") as $file) { 
                    $file_info = pathinfo($file);
                    $files[] = ['value' => $file_info['basename'], 'label' => PerchUtil::filename($file, false)]; 
                }
            }


            return $files;
        }
    }