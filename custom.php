<?php 
/*Template Name: Archive Page*/
get_header();
?>

<div class="page_inr_container">

<div class="page_inr_ctnt">


  <div class="inr_ttl">
          <h1>مرحبًا بك في الأرشيف الرقمي لـ<br> جريدة البلاد</h1>
        </div>
          <div class="inr_para">
            <span>ابحث عن أكثر من 12 عامًا من المقالات والملفات التفاعلية</span>
          </div>

        <div class="tab main-tab">
          <ul class="tabs_one">
            <li class="tab-link" data-tab="tab-4">تفاعلي</li>
            <li class="tab-link current" data-tab="tab-3">مقالات</li>
          </ul>
        </div>
    
        

<div id="tab-4" class="tab-content-one">
  <?php get_template_part('includes/interactive'); ?>
</div>

<div id="tab-3" class="tab-content-one current">
  
 <?php echo do_shortcode('[helloChild_filter]'); ?>



</div>

</div>

<?php
get_footer();
?>