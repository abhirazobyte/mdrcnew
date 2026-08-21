<?
class _common extends controller
{
    function init() {}

    function onload()
    {
        $cityID = mysqli_real_escape_string($this->app->set_db_conn(), $this->app->getPostVar('cityID'));
        if($cityID=='undefined'){
            $cityID='MQ==';
        }
		$cityID = $this->app->utility->decrypt($cityID);

        if($cityID!=''){
            $obj_model_city = $this->app->load_model("city");
		    $city = $obj_model_city->execute("SELECT",false,"","city.status='Active' and city.id='".$cityID."'");
            
            $common = array(
                "cityId" => $this->app->utility->encrypt($city[0]['id']),
                "cityName" => $city[0]['name'],
                "citySlug" => $city[0]['slug'],
                "whatsapp"=>'918586988847',
            );
        } else {
            $cityID=1;
            $common = array(
                // "cityId" => 'MQ==',
                "cityId" => 'MQ==',
                "cityName" => 'Gurugram',
                "citySlug" => 'gurgaon',
                "whatsapp"=>'918586988847',
            );
        }

        $pageSectionConfig = [

            // ===== HOME =====
            'home' => [
                'faq' => 'Yes',
                'testimonials' => 'Yes',
            ],

            // ===== ABOUT & STATIC =====
            'about-us' => [
                'faq' => 'No',
                'testimonials' => 'No',
            ],

            'our-milestones' => [
                'faq' => 'Yes',
                'testimonials' => 'No',
            ],

            // ===== FOR DOCTORS =====
            'modern-lab' => [
                'faq' => 'No',
                'testimonials' => 'No',
            ],
            'modern-imaging' => [
                'faq' => 'No',
                'testimonials' => 'No',
            ],
            'super-specialised-services' => [
                'faq' => 'No',
                'testimonials' => 'No',
            ],

            // ===== FOR Patients =====
            'our-doctors' => [
                'faq' => 'No',
                'testimonials' => 'No',
            ],

            'imaging-test-information' => [
                'faq' => 'No',
                'testimonials' => 'Yes',
            ],

            'pathology-lab-information' => [
                'faq' => 'No',
                'testimonials' => 'Yes',
            ],

            'home-sample-collection' => [
                'faq' => 'Yes',
                'testimonials' => 'No',
            ],

            //premium-health-checkup
            'premium-health-checkup' => [
                'faq' => 'Yes',
                'testimonials' => 'Yes',
            ],

            //INVESTOR RELATIONS
            'ipo' => [
                'faq' => 'No',
                'testimonials' => 'No',
            ],
            'policies' => [
                'faq' => 'No',
                'testimonials' => 'No',
            ],
            'news-releases' => [
                'faq' => 'No',
                'testimonials' => 'No',
            ],

            //CONTACT US 
            'reach-us' => [
                'faq' => 'No',
                'testimonials' => 'No',
            ],

            'mdrc-test-booking-enquiry' => [
                'faq' => 'No',
                'testimonials' => 'No',
            ],

            'news-and-events' => [
                'faq' => 'No',
                'testimonials' => 'No',
            ],
            'gallery' => [
                'faq' => 'No',
                'testimonials' => 'No',
            ],
            'video' => [
                'faq' => 'No',
                'testimonials' => 'No',
            ],
            'career' => [
                'faq' => 'No',
                'testimonials' => 'No',
            ],
            'blog' => [
                'faq' => 'No',
                'testimonials' => 'No',
            ],
            'corporate-tieup' => [
                'faq' => 'No',
                'testimonials' => 'No',
            ],

        ];


        //ITEMS
        $obj_model = $this->app->load_model('item');
        $obj_model->join_table("item_other_data", "left", array('item_id', 'item_category_ids', 'item_key_fetures_ids', 'item_department_ids', 'item_diseases_ids', 'item_type_id'), array("id" => "item_id"));
        $obj_model->join_table("item_price", "left", array(), array("id" => "item_id"));
        $city_cond = " and FIND_IN_SET ('" . $cityID . "',item.city_ids) and item_price.city_id='" . $cityID . "'";
        $items = $obj_model->execute("SELECT", false, "", "item.status='Active'" . $city_cond, "item.id desc");

        //ITEM CATEGORY 
        $obj_model = $this->app->load_model('item_category');
        $item_category = $obj_model->execute("SELECT", false, "", "item_category.status='Active'", "sort_order asc");


        //ITEM DISEASES
        $obj_model = $this->app->load_model('item_diseases');
        $item_diseases = $obj_model->execute("SELECT", false, "", "item_diseases.status='Active'", "sort_order asc");

        $obj_model_for_doctors = $this->app->load_model("for_doctors");
        $records = $obj_model_for_doctors->execute("SELECT",false,"","id!=0 and status='Active' and slug='super-specialised-services'");

        $obj_model_for_doctors_services = $this->app->load_model("for_doctors_services");
        $records_services_h = $obj_model_for_doctors_services->execute("SELECT",false,"","id!=0 and status='Active' and for_doctors_id='".$records[0]['id']."'","sort_order ASC");
       


        //===========HOME :: START===========
        //HOME
        $menuList[] = array(
            "title" => 'Home',
            "link" => "/",
            "child" => [],
        );
        //===========HOME :: END===========

        //===========ABOUT-US :: START===========

        $aboutChildren = [];

        //1. About Us Page
        $aboutChildren[] = array(
            "title" => "About Us",
            "link"  => "/about-us",
            "child" => []
        );

        $aboutChildren[] = array(
            "title" => "Lab Services",
            "link"  => "/for-doctors/modern-lab",
            "child" => []
        );
        $aboutChildren[] = array(
            "title" => "Imaging Services",
            "link"  => "/for-doctors/modern-imaging",
            "child" => []
        );

        //2. For Doctors
        // $aboutChildren[] = array(
        //     "title" => "For Doctors",
        //     "link"  => "#",
        //     "child" => array(
        //         array(
        //             "title" => "Modern Lab",
        //             "link"  => "/for-doctors/modern-lab",
        //         ),
        //         array(
        //             "title" => "Modern Imaging",
        //             "link"  => "/for-doctors/modern-imaging",
        //         ),
        //         array(
        //             "title" => "Super Specialised Services",
        //             "link"  => "/for-doctors/super-specialised-services",
        //         )
        //     )
        // );

        // 3. For Patients
        $aboutChildren[] = array(
            "title" => "For Patients",
            "link"  => "#",
            "child" => array(
                array(
                    "title" => "Our Doctors",
                    "link"  => "/our-doctors",
                ),
                array(
                    "title" => "Imaging Test Information",
                    "link"  => "/imaging-test-information",
                ),
                array(
                    "title" => "Pathology Lab Test Information",
                    "link"  => "/pathology-lab-information",
                ),
                array(
                    "title" => "Home Sample Collection",
                    "link"  => "/home-sample-collection/" . $common['citySlug'],
                )
            )
        );

        //4. Our Milestones
        $aboutChildren[] = array(
            "title" => "Our Milestones",
            "link"  => "/our-milestones",
            "child" => []
        );

       //5. Investor Relation

        $aboutChildren[] = array(
            "title" => "Investor Relation",
            "link"  => "#",
            "child" => array(
                array(
                    "title" => "IPO / Offer Documents",
                    "link"  => "/ipo",
                    "child" => []
                ),
                array(
                    "title" => "Policies",
                    "link"  => "/policies",
                    "child" => []
                ),
                array(
                    "title" => "News Releases",
                    "link"  => "/news-releases",
                    "child" => []
                )
            )
        );
       
        // Add About to Menu (MAIN)
        $menuList[] = array(
            "title" => "About Us",
            "link"  => "#",
            "child" => $aboutChildren
        );
        //===========ABOUT-US :: END===========

        //===========Book Your Blood Test :: START===========

        $bloodTestChildren = [];

        $premiumTests = [];
        $j = 0;
        foreach ($items as $test) {
            if ($test['set_at_popular_package'] === 'Yes') {
                if ($j++ >= 30) break;

                $premiumTests[] = array(
                    "title" => $test['name'],
                    "link"  => "/tests/" . $test['slug'] . "/" . $common['citySlug']
                );
            }
        }

        $premiumTests[] = array(
            "title" => 'View All',
            "link"  => "/premium-health-checkup/" . $common['citySlug']
        );


        $bloodTestChildren[] = array(
            "title" => "Full Body Health Checkup",
            "link"  => "/premium-health-checkup/" . $common['citySlug'],
            "child" => $premiumTests
        );


        /**
         * 1. Popular Packages
         */
        $popularPackages = [];
        $j = 0;
        foreach ($items as $test) {
            $deptIds = explode(',', $test['item_other_data_item_department_ids']);
            if (in_array('2', $deptIds) && $test['set_at_popular_package'] === 'Yes') {
                if ($j++ >= 30) break;

                $popularPackages[] = array(
                    "title" => $test['name'],
                    "link"  => "/tests/" . $test['slug'],
                );
            }
        }

        $bloodTestChildren[] = array(
            "title" => "Popular Packages",
            "link"  => "/pathology/lab-blood-test-near/" . $common['citySlug'],
            "child" => $popularPackages
        );

        /**
         * 2. Popular Tests
         */
        $popularTests = [];
        $j = 0;
        foreach ($items as $test) {
            $deptIds = explode(',', $test['item_other_data_item_department_ids']);
            if (in_array('2', $deptIds) && $test['set_at_popular_test'] === 'Yes') {
                if ($j++ >= 30) break;

                $popularTests[] = array(
                    "title" => $test['name'],
                    "link"  => "/tests/" . $test['slug'] . "/" . $common['citySlug']
                );
            }
        }

        $bloodTestChildren[] = array(
            "title" => "Popular Tests",
            "link"  => "/pathology/lab-blood-test-near/" . $common['citySlug'],
            "child" => $popularTests
        );

        /**
         * 3. Health Risk
         */
        $healthRisk = [];
        $j = 0;
        foreach ($item_diseases as $item) {
            $deptIds = explode(',', $item['item_department_ids']);
            if (in_array('2', $deptIds)) {
                if ($j++ >= 30) break;

                $healthRisk[] = array(
                    "title" => $item['name'],
                    "link"  => "/diseases/" . $common['citySlug'] . "/" . $item['slug']
                );
            }
        }

        $bloodTestChildren[] = array(
            "title" => "Tests Health Risk",
            "link"  => "/health-risk/" . $common['citySlug'],
            "child" => $healthRisk
        );

        /**
         * 4. Categories
         */
        $categories = [];
        $j = 0;
        foreach ($item_category as $item) {
            $deptIds = explode(',', $item['item_department_ids']);
            if (in_array('2', $deptIds)) {
                if ($j++ >= 30) break;

                $categories[] = array(
                    "title" => $item['name'],
                    "link"  => "/category/" . $common['citySlug'] . "/" . $item['slug']
                );
            }
        }

        $bloodTestChildren[] = array(
            "title" => "Tests by Categories",
            "link"  => "/categories/" . $common['citySlug'],
            "child" => $categories
        );

        /**
         * 5. Premium Test
         */
        

        



        $menuList[] = array(
            "title" => "Book Your Blood Test",
            "link"  => "/pathology/lab-blood-test-near/" . $common['citySlug'],
            "type"  => "mega",
            "child" => $bloodTestChildren
        );

        //===========Book Your Blood Test :: END===========

        //===========Book Your Scan :: START===========

        $scanChildren = [];
        $scanChildren[] = array(
            "title" => "Book Your Scan Home",
            "link"  => "/radiology/imaging-lab-tests-near/" . $common['citySlug'],
            "child" => []
        );

        // Categories for Radiology (department_id = 1)
        $i = 0;
        foreach ($item_category as $category) {

            $deptIds = explode(',', $category['item_department_ids']);

            if (in_array('1', $deptIds)) {

                if ($i++ > 10) break;

                // Tests under this category
                $tests = [];
                $j = 0;

                foreach ($items as $test) {

                    $testCats = explode(',', $test['item_other_data_item_category_ids']);

                    if (in_array($category['id'], $testCats)) {

                        if ($j++ > 30) break;

                        $tests[] = array(
                            "title" => $test['name'],
                            "link"  => "/tests/" . $test['slug'] . "/" . $common['citySlug']
                        );
                    }
                }

                $scanChildren[] = array(
                    "title" => $category['name'],
                    "link"  => "/category/" . $common['citySlug'] . "/" . $category['slug'],
                    "child" => $tests
                );
            }
        }

        $menuList[] = array(
            "title" => "Radiology Scan",
            "link"  => "/radiology/imaging-lab-tests-near/" . $common['citySlug'],
            "type"  => "mega",
            "child" => $scanChildren
        );

        //===========Book Your Scan :: END===========

        //===========Full Body Check-Up :: START===========

        $menuList[] = array(
            "title" => "Find The Test",
            "link"  => "/pathology/lab-blood-test-near/" . $common['citySlug'],
            "child" => []
        );
        //===========Full Body Check-Up :: END===========


        

         //===========Contact Us :: START===========

        $superSpecChildren = [];
        foreach($records_services_h as $service){
            $superSpecChildren[] = array(
                "title" => $service['title'],
                "link"  => "/service/super-specialised-services/".$service['slug'],
                "child" => []
            );
        };
        $menuList[] = array(
            "title" => "Superspecialised Lab Tests",
            "link"  => "/for-doctors/super-specialised-services",
            "child" =>$superSpecChildren,
        );

        //===========Contact Us :: END===========

        //===========Contact Us :: START===========


        $menuList[] = array(
            "title" => "Contact Us",
            "link"  => "#",
            "child" => array(
                array(
                    "title" => "Reach us",
                    "link"  => "/reach-us",
                ),
                array(
                    "title" => "Book a test",
                    "link"  => "/mdrc-test-booking-enquiry",
                ),
                array(
                    "title" => "News and Events",
                    "link"  => "/news-and-events",
                ),
                array(
                    "title" => "Gallery",
                    "link"  => "/gallery",
                ),
                array(
                    "title" => "Career",
                    "link"  => "/career",
                ),
                array(
                    "title" => "Blogs",
                    "link"  => "/blog",
                ),
                array(
                    "title" => "Corporate Tieup",
                    "link"  => "/corporate-tieup",
                )
            )
        );

        //===========Contact Us :: END===========

        $result = ["menuList" => $menuList, "common" => $common,"pageSectionConfig" =>$pageSectionConfig];
        $message = array("message" => '', "msgCode" => "1", "data" => $result);

        $opt = json_encode($message, JSON_UNESCAPED_UNICODE);
        echo $this->app->utility->indent($opt);
        exit;
    }
}
