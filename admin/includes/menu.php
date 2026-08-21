<aside class="aside aside-fixed">

  <div class="aside-header"> <a href="index.php" class="aside-logo"><?= PROJECT_TILLE ?></a> <a href="" class="aside-menu-link"> <i data-feather="menu"></i> <i data-feather="x"></i> </a> </div>

  <div class="aside-body">

    <div class="aside-loggedin">

      <div class="d-flex align-items-center justify-content-start"> <a href="" class="avatar"><img src="../images/favicon.png" class="rounded-circle" alt=""></a>

        <div class="aside-alert-link">

          <!--<a href="" class="new" data-toggle="tooltip" title="You have 2 unread messages"><i data-feather="message-square"></i></a> <a href="" class="new" data-toggle="tooltip" title="You have 4 new notifications"><i data-feather="bell"></i></a>-->

          <a onclick="userLogout()" data-toggle="tooltip" title="Sign out" class="userLogout"><i data-feather="log-out"></i></a>
        </div>

      </div>

      <div class="aside-loggedin-user"> <a href="#loggedinMenu" class="d-flex align-items-center justify-content-between mg-b-2" data-toggle="collapse">

          <h6 class="tx-semibold mg-b-0">

            <?= $_SESSION['adminName']; ?>

          </h6>

          <i data-feather="chevron-down"></i>
        </a>

        <p class="tx-color-03 tx-12 mg-b-0">Administrator</p>

      </div>

      <div class="collapse" id="loggedinMenu">

        <ul class="nav nav-aside mg-b-0">

          <li class="nav-item"><a href="index.php?view=account_setting" class="nav-link"><i data-feather="edit"></i> <span>Edit Profile</span></a></li>

          <li class="nav-item"><a onclick="userLogout()" class="nav-link userLogout"><i data-feather="log-out"></i> <span>Sign Out</span></a></li>

        </ul>

      </div>

    </div>

    <!-- aside-loggedin -->

    <ul class="nav nav-aside sidebar-nav">

      <li class="nav-label">Dashboard</li>

      <li class="nav-item mysub" data-main="home"><a href="index.php?view=home" class="nav-link"><i data-feather="shopping-bag"></i> <span>Sales Monitoring</span></a></li>

      <li class="nav-label mg-t-25">Mannage Website</li>

      <li class="nav-item with-sub mysub" data-main="ipo_pdfs_list,faq_list,gallery_list,video_gallery_list,gallery,banner_list,popup_list,testimonial_list,offer_message_list,web_feature_list,offer_banner_list,pages,pages_addedit,branch_list"> <a href="" class="nav-link"><i data-feather="globe"></i> <span>Mannage Website</span></a>

        <ul class="sub_main1">

          <li data-sub="popup_list" class=""><a href="index.php?view=popup_list">Popup Image List</a></li>

          <li data-sub="banner_list" class=""><a href="index.php?view=banner_list">Banner List</a></li>

          <li data-sub="pages" class=""><a href="index.php?view=pages">Pages List</a></li>

          <li data-sub="testimonial_list" class=""><a href="index.php?view=testimonial_list">Testimonial List</a></li>

          <li data-sub="branch_list" class=""><a href="index.php?view=branch_list">Branch List</a></li>

          <li data-sub="gallery_list" class=""><a href="index.php?view=gallery_list">Gallery List</a></li>

          <li data-sub="video_gallery_list" class=""><a href="index.php?view=video_gallery_list">Video Gallery List</a></li>

          <li data-sub="faq_list" class=""><a href="index.php?view=faq_list">FAQ List</a></li>
          <li data-sub="faq_list" class=""><a href="index.php?view=page_info_content&page_id=20">Premium HealthCheckup</a></li>
          <li data-sub="ipo_pdfs_list" class=""><a href="index.php?view=ipo_pdfs_list">IPO Pdfs</a></li>

        </ul>

      </li>




      <li class="nav-item with-sub mysub" data-main="for_doctors_list"> <a href="" class="nav-link"><i data-feather="rss"></i> <span>Mannage For Doctors</span></a>

        <ul class="sub_main1">

          <li data-sub="for_doctors_list" class=""><a href="index.php?view=for_doctors_list">For Doctors</a></li>


        </ul>

      </li>




      <li class="nav-item with-sub mysub" data-main="blog_list,blog_addedit,blog_tag_list,blog_category_list"> <a href="" class="nav-link"><i data-feather="bold"></i> <span>Mannage Blog</span></a>

        <ul class="sub_main1">

          <li data-sub="blog_category_list" class=""><a href="index.php?view=blog_category_list">Category</a></li>

          <li data-sub="blog_tag_list" class=""><a href="index.php?view=blog_tag_list">Tag</a></li>

          <li data-sub="blog_list" class=""><a href="index.php?view=blog_list">Blog</a></li>

        </ul>

      </li>

      <li class="nav-item with-sub mysub" data-main="event_list,event_addedit,event_gallery"> <a href="" class="nav-link"><i data-feather="coffee"></i> <span>Mannage Events</span></a>
        <ul class="sub_main1">
          <li data-sub="event_list" class=""><a href="index.php?view=event_list">Events</a></li>
        </ul>
      </li>

      <li class="nav-label mg-t-25">Doctors</li>

      <li class="nav-item with-sub mysub" data-main="doctor_category_list,doctor_list"> <a href="" class="nav-link"><i data-feather="users"></i> <span>Doctor</span></a>

        <ul class="sub_main1">

          <li data-sub="doctor_category_list" class=""><a href="index.php?view=doctor_category_list">Category</a></li>

          <li data-sub="doctor_list" class=""><a href="index.php?view=doctor_list">Doctor</a></li>

        </ul>

      </li>










      <li class="nav-item with-sub mysub" data-main="item_diseases_banner_list,item_category_banner_list,item_key_fetures_list,lis_item_list,item_type_list,item_category_list,item_department_list,item_diseases_list,item_list,item_addedit,item_data_list,item_lab_list,item_certificate_list"> <a href="" class="nav-link"><i data-feather="menu"></i> <span>Items</span></a>

        <ul class="sub_main1">
          <li data-sub="item_key_fetures_list" class=""><a href="index.php?view=item_key_fetures_list">Key Fetures</a></li>
          <li data-sub="item_certificate_list" class=""><a href="index.php?view=item_certificate_list">Certificate Types</a></li>

          <li data-sub="item_lab_list" class=""><a href="index.php?view=item_lab_list">Lab</a></li>

          <li data-sub="item_type_list" class=""><a href="index.php?view=item_type_list">Type</a></li>

          <li data-sub="item_department_list" class=""><a href="index.php?view=item_department_list">Department</a></li>

          <li data-sub="item_category_list" class=""><a href="index.php?view=item_category_list">Category</a></li>
          <li data-sub="item_category_banner_list" class=""><a href="index.php?view=item_category_banner_list">Category Banner</a></li>

          <li data-sub="item_diseases_list" class=""><a href="index.php?view=item_diseases_list">Diseases</a></li>
          <li data-sub="item_diseases_banner_list" class=""><a href="index.php?view=item_diseases_banner_list">Diseases Banner</a></li>

          <li data-sub="item_list" class=""><a href="index.php?view=item_list">Items</a></li>
          <li data-sub="lis_item_list" class=""><a href="index.php?view=lis_item_list">LIS Items</a></li>

        </ul>

      </li>



      <li class="nav-label mg-t-25">Mannage Order</li>
      <li class="nav-item with-sub mysub" data-main="order_list,order_detail,holidays"> <a href="" class="nav-link"><i data-feather="shopping-bag"></i> <span>Mannage Order</span></a>

        <ul class="sub_main1">
        <li data-sub="holidays" class=""><a href="index.php?view=holidays">Holidays</a></li>
          <li data-sub="order_list" class=""><a href="index.php?view=order_list">Order Master</a></li>

        </ul>

      </li>





      <li class="nav-label mg-t-25">Users & Wallet</li>

      <li class="nav-item with-sub mysub" data-main="test_booking_enquiry_list,collection_appointment_list,get_tuch_inq_list,help_list,add_money_list,customer_list,newsletter_list"> <a href="" class="nav-link"><i data-feather="users"></i> <span>Users & Wallet</span></a>

        <ul class="sub_main1">

          <li data-sub="customer_list" class=""><a href="index.php?view=customer_list">User List</a></li>

          <li data-sub="add_money_list" class=""><a href="index.php?view=add_money_list">Wallet Transction List</a></li>

          <li data-sub="newsletter_list" class=""><a href="index.php?view=newsletter_list">Newsletter List</a></li>

          <li data-sub="help_list" class=""><a href="index.php?view=help_list">Contact Inquiry</a></li>

          <li data-sub="get_tuch_inq_list" class=""><a href="index.php?view=get_tuch_inq_list">Get In Touch Inquiry</a></li>


          <li data-sub="collection_appointment_list" class=""><a href="index.php?view=collection_appointment_list">Collection Appointment</a></li>


          <li data-sub="test_booking_enquiry_list" class=""><a href="index.php?view=test_booking_enquiry_list">Test Booking Enquiry</a></li>
        </ul>
      </li>
      <li class="nav-item mysub" data-main="user_cart_list"><a href="index.php?view=user_cart_list" class="nav-link"><i data-feather="shopping-cart"></i> <span>Abandoned Cart</span></a></li>
      <li class="nav-item mysub" data-main="user_cart_notification_list"><a href="index.php?view=user_cart_notification_list" class="nav-link"><i data-feather="alert-circle"></i> <span>User Cart Notification</span></a></li>



      <li class="nav-label mg-t-25">Job Opening</li>

      <li class="nav-item with-sub mysub" data-main="job_opening_list"> <a href="" class="nav-link"><i data-feather="users"></i> <span>Job Opening</span></a>

        <ul class="sub_main1">

          <li data-sub="job_opening_list" class=""><a href="index.php?view=job_opening_list">Job Opening List</a></li>

        </ul>

      </li>



      <li class="nav-label mg-t-25">Pay Now Order</li>

      <li class="nav-item with-sub mysub" data-main="direct_payment_order_list"> <a href="" class="nav-link"><i data-feather="shopping-bag"></i> <span>Pay Now Order</span></a>

        <ul class="sub_main1">

          <li data-sub="direct_payment_order_list" class=""><a href="index.php?view=direct_payment_order_list">Pay Now Order List</a></li>

        </ul>

      </li>



      <li class="nav-label mg-t-25">Mannage State</li>

      <li class="nav-item with-sub mysub" data-main="state_list,city_list,area_list,pincode_list"> <a href="" class="nav-link"><i data-feather="users"></i> <span>Mannage State</span></a>

        <ul class="sub_main1">

          <li data-sub="state_list" class=""><a href="index.php?view=state_list">State List</a></li>

          <li data-sub="city_list" class=""><a href="index.php?view=city_list">City List</a></li>

          <li data-sub="area_list" class=""><a href="index.php?view=area_list">Area List</a></li>

          <li data-sub="pincode_list" class=""><a href="index.php?view=pincode_list">Pincode List</a></li>

        </ul>

      </li>





      <li class="nav-item mysub" data-main="coupon_list"><a href="index.php?view=coupon_list" class="nav-link"><i data-feather="menu"></i> <span>Coupons List</span></a></li>

      <li class="nav-label mg-t-25">Setting</li>

      <li class="nav-item with-sub mysub" data-main="sms_data_list,sms_history_list"> <a href="javascript:void(0)" class="nav-link"><i data-feather="mail"></i> <span>SMS Setting</span></a>

        <ul class="sub_main1">

          <li data-sub="sms_data_list" class=""><a href="index.php?view=sms_data_list">SMS Data</a></li>

          <li data-sub="sms_history_list" class=""><a href="index.php?view=sms_history_list">SMS History</a></li>

        </ul>

      </li>
      <li class="nav-item with-sub mysub" data-main="push_notification_list"> <a href="javascript:void(0)" class="nav-link"><i data-feather="bell"></i> <span>Notification</span></a>

        <ul class="sub_main1">

          <li data-sub="push_notification_list" class=""><a href="index.php?view=push_notification_list">Notification Data</a></li>


        </ul>

      </li>

      <li class="nav-label mg-t-25">System Setting</li>

      <li class="nav-item with-sub mysub" data-main="page_info,general_settings,admin_logins_list,general_settings,account_list"> <a href="javascript:void(0)" class="nav-link"><i data-feather="settings"></i> <span>System Setting</span></a>

        <ul class="sub_main1">

          <?php if ($_SESSION['admin'] == '1') { ?>

            <li data-sub="account_list" class=""><a href="index.php?view=account_list">Admin User</a></li>

          <?php } ?>

          <li data-sub="general_settings" class=""><a href="index.php?view=general_settings">General Setting</a></li>

          <li data-sub="notification_settings" class=""><a href="index.php?view=notification_settings">Notification Setting</a></li>

          <li data-sub="page_info" class=""><a href="index.php?view=page_info">Meta Setting</a></li>

          <li data-sub="admin_logins_list" class=""><a href="index.php?view=admin_logins_list">Login History</a></li>

        </ul>

      </li>
      <li class="nav-item mysub" data-main="site_map"><a href="index.php?view=site_map" class="nav-link"><i data-feather="map"></i> <span>Site Map</span></a></li>
    </ul>

  </div>

</aside>