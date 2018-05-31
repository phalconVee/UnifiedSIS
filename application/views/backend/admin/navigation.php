<div class="sidebar-menu">
    <header class="logo-env" >

        <!-- logo -->
        <div class="logo" style="">
            <a href="<?php echo base_url(); ?>">
                <img src="<?=base_url();?>uploads/logo.png"  style="max-height:60px;"/>
            </a>
        </div>

        <!-- logo collapse icon -->
        <div class="sidebar-collapse" style="">
            <a href="#" class="sidebar-collapse-icon with-animation">

                <i class="entypo-menu"></i>
            </a>
        </div>

        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
        <div class="sidebar-mobile-menu visible-xs">
            <a href="#" class="with-animation">
                <i class="entypo-menu"></i>
            </a>
        </div>
    </header>

    <div style=""></div>	
    <ul id="main-menu" class="">
        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->


		<!-- DASHBOARD -->
        <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/dashboard">
                <i class="entypo-gauge"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
        </li>

        <!-- STUDENT -->
        <li class="<?php if ($page_name == 'student_add' ||
                                $page_name == 'student_bulk_add' ||
                                    $page_name == 'student_information' ||
                                        $page_name == 'student_marksheet' ||
                                            $page_name == 'student_promotion')
                                                echo 'opened active has-sub';
        ?> ">
            <a href="#">
                <i class="fa fa-group"></i>
                <span><?php echo get_phrase('student'); ?></span>
            </a>
            <ul>
                <!-- STUDENT ADMISSION -->
                <li class="<?php if ($page_name == 'student_add') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/student_add">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('admit_student'); ?></span>
                    </a>
                </li>

                <!-- STUDENT BULK ADMISSION -->
                <li class="<?php if ($page_name == 'student_bulk_add') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/student_bulk_add">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('admit_bulk_student'); ?></span>
                    </a>
                </li>

                <!-- STUDENT IMPORT -->
                <li class="<?php if ($page_name == 'student_import') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/student_import">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_import'); ?></span>
                    </a>
                </li>

                <!-- STUDENT INFORMATION -->
                <li class="<?php if ($page_name == 'student_information' || $page_name == 'student_marksheet') echo 'opened active'; ?> ">
                    <a href="#">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_information'); ?></span>
                    </a>
                    <ul>
                        <?php
                        $classes = $this->db->get('class')->result_array();
                        foreach ($classes as $row):
                            ?>
                            <li class="<?php if ($page_name == 'student_information' && $class_id == $row['class_id'] || $page_name == 'student_marksheet' && $class_id == $row['class_id']) echo 'active'; ?>">
                            <!--<li class="<?php if ($page_name == 'student_information' && $page_name == 'student_marksheet' && $class_id == $row['class_id']) echo 'active'; ?>">-->
                                <a href="<?php echo base_url(); ?>index.php?admin/student_information/<?php echo $row['class_id']; ?>">
                                    <span><?php echo get_phrase('class'); ?> <?php echo $row['name']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </li>

                <!-- STUDENT PROMOTION -->
                <li class="<?php if ($page_name == 'student_promotion') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/student_promotion">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_promotion'); ?></span>
                    </a>
                </li>

            </ul>
        </li>

        <!-- TEACHER -->
        <li class="<?php if ($page_name == 'teacher') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/teacher">
                <i class="entypo-users"></i>
                <span><?php echo get_phrase('teacher'); ?></span>
            </a>
        </li>

        <!-- PARENTS -->
        <li class="<?php if ($page_name == 'parent') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/parent">
                <i class="entypo-user"></i>
                <span><?php echo get_phrase('parents'); ?></span>
            </a>
        </li>

        <!-- LIBRARIAN -->
        <li class="<?php if ($page_name == 'librarian') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/librarian">
                <i class="fa fa-book"></i>
                <span><?php echo get_phrase('librarian'); ?></span>
            </a>
        </li>

        <!-- ACCOUNTANT -->
        <li class="<?php if ($page_name == 'accountant') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/accountant">
                <i class="entypo-briefcase"></i>
                <span><?php echo get_phrase('accountant'); ?></span>
            </a>
        </li>

        <!-- HR/PAYROLL -->
        <li class="<?php if ($page_name == 'add_employee' || $page_name == 'employee_import' ||
                            $page_name == 'employee' || $page_name == 'bank_details' ||
                            $page_name == 'pay_head' || $page_name == 'payable_type' || 
                            $page_name == 'salary_settings' || $page_name == 'staff_salary' || 
                            $page_name == 'generate_pay_slip' || $page_name == 'leave_category' || 
                            $page_name == 'leave_application' || $page_name == 'staff_attendance' || 
                            $page_name == 'manage_staff_attendance_view' || $page_name == 'staff_attendance_report' || $page_name == 'staff_attendance_report_view')
                            echo 'opened active'; ?> ">
            <a href="#">
                <i class="entypo-eye"></i>
                <span><?php echo get_phrase('HR/Payroll'); ?></span>
            </a>
            <ul>                
                 <li class="<?php if ($page_name == 'employee_import' || $page_name == 'add_bank_details') echo 'opened active'; ?> ">

                    <a href="#">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('employee'); ?></span>
                    </a>

                    <ul>                       
                        <li class="<?php if (( $page_name == 'employee_import')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?admin/employee_import">
                                <span><i class="entypo-dot"></i><?php echo get_phrase('employee_import'); ?></span>
                            </a>
                        </li>

                        <li class="<?php if (( $page_name == 'employee')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?admin/employee">
                                <span><i class="entypo-dot"></i><?php echo get_phrase('employee_information'); ?></span>
                            </a>
                        </li>

                        <li class="<?php if (( $page_name == 'add_bank_details')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?admin/bank_details">
                                <span><i class="entypo-dot"></i><?php echo get_phrase('add_bank_details'); ?></span>
                            </a>
                        </li>
                        
                    </ul>
                 </li>

                 <!-- PAYROLL -->
                 <li class="<?php if ($page_name == 'pay_head' || 
                                            $page_name == 'payable_type' || 
                                                $page_name == 'salary_settings' || 
                                                    $page_name == 'staff_salary' || 
                                                        $page_name == 'generate_pay_slip') echo 'opened active'; ?> ">

                    <a href="#">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('payroll'); ?></span>
                    </a>

                    <ul>
                        <li class="<?php if ( $page_name == 'pay_head') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?admin/payHeadMaster">
                                <span><i class="entypo-dot"></i><?php echo get_phrase('pay_head'); ?></span>
                            </a>
                        </li>

                        <li class="<?php if (( $page_name == 'payable_type')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?admin/payableTypes">
                                <span><i class="entypo-dot"></i><?php echo get_phrase('payable_types'); ?></span>
                            </a>
                        </li>

                        <li class="<?php if (( $page_name == 'salary_settings')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?admin/salarySettings">
                                <span><i class="entypo-dot"></i><?php echo get_phrase('salary_settings'); ?></span>
                            </a>
                        </li>

                        <li class="<?php if (( $page_name == 'staff_salary')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?admin/staffSalary">
                                <span><i class="entypo-dot"></i><?php echo get_phrase('staff_salary'); ?></span>
                            </a>
                        </li>

                        <!--<li class="<?php if (( $page_name == 'generate_pay_slip')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?admin/generate_pay_slip">
                                <span><i class="entypo-dot"></i><?php echo get_phrase('generate_pay_slip'); ?></span>
                            </a>
                        </li>-->                       
                        
                    </ul>
                 </li>    

                 <!-- lEAVE MANAGEMENT -->
                 <li class="<?php if ($page_name == 'leave_category' || $page_name == 'leave_application' || $page_name == 'leave_approvals') echo 'opened active'; ?> ">

                    <a href="#">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('leave_management'); ?></span>
                    </a>

                    <ul>
                        <li class="<?php if (( $page_name == 'leave_category')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?admin/leaveCategory">
                                <span><i class="entypo-dot"></i><?php echo get_phrase('leave_category'); ?></span>
                            </a>
                        </li>                        

                        <li class="<?php if (( $page_name == 'leave_application')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?admin/leaveApplication">
                                <span><i class="entypo-dot"></i><?php echo get_phrase('leave_application'); ?></span>
                            </a>
                        </li>
                 
                        
                    </ul>
                 </li>   

                 <!-- STAFF ATTENDANCE -->
                 <li class="<?php if ($page_name == 'staff_attendance' || $page_name == 'staff_attendance_report' || $page_name == 'staff_attendance_report_view') echo 'opened active'; ?> ">

                    <a href="#">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('staff_attendance'); ?></span>
                    </a>

                    <ul>
                        <li class="<?php if ( $page_name == 'staff_attendance') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?admin/staffAttendance">
                                <span><i class="entypo-dot"></i><?php echo get_phrase('staff_attendance'); ?></span>
                            </a>
                        </li>                        

                        <li class="<?php if ($page_name == 'staff_attendance_report') echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?admin/staffAttendanceReport">
                                <span><i class="entypo-dot"></i><?php echo get_phrase('staff_attendance_report'); ?></span>
                            </a>
                        </li>                 
                        
                    </ul>
                 </li>                                         

            </ul>
        </li>

        <!-- CLASS -->
        <li class="<?php
        if ($page_name == 'class' ||
                $page_name == 'section' ||
                    $page_name == 'academic_syllabus')
            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-flow-tree"></i>
                <span><?php echo get_phrase('class'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'class') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/classes">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('manage_classes'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'section') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/section">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('manage_sections'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'academic_syllabus') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/academic_syllabus">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('academic_syllabus'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- GENERATE ID CARDS -->
        <li class="<?php
        if ($page_name == 'student_id_card' ||
                $page_name == 'teacher_id_card' ||
                    $page_name == 'accountant_id_card' ||
                        $page_name == 'librarian_id_card')
            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-vcard"></i>
                <span><?php echo get_phrase('generate_id_cards'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'student_id_card') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/student_id_card">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_id_card'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'teacher_id_card') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/teacher_id_card">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('teacher_id_card'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'accountant_id_card') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/accountant_id_card">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('accountant_id_card'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'librarian_id_card') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/librarian_id_card">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('librarian_id_card'); ?></span>
                    </a>
                </li>
            </ul>
        </li>


        <!-- SUBJECT -->
        <li class="<?php if ($page_name == 'subject') echo 'opened active'; ?> ">
            <a href="#">
                <i class="entypo-docs"></i>
                <span><?php echo get_phrase('subject'); ?></span>
            </a>
            <ul>
                <?php
                $classes = $this->db->get('class')->result_array();
                foreach ($classes as $row):
                    ?>
                    <li class="<?php if ($page_name == 'subject' && $class_id == $row['class_id']) echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>index.php?admin/subject/<?php echo $row['class_id']; ?>">
                            <span><?php echo get_phrase('class'); ?> <?php echo $row['name']; ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>

        <!-- CLASS ROUTINE -->
        <li class="<?php if ($page_name == 'class_routine_view' ||
                                $page_name == 'class_routine_add') 
                                    echo 'opened active'; ?> ">
            <a href="#">
                <i class="entypo-target"></i>
                <span><?php echo get_phrase('class_routine'); ?></span>
            </a>
            <ul>
                <?php
                $classes = $this->db->get('class')->result_array();
                foreach ($classes as $row):
                    ?>
                    <li class="<?php if ($page_name == 'class_routine_view' && $class_id == $row['class_id']) echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>index.php?admin/class_routine_view/<?php echo $row['class_id']; ?>">
                            <span><?php echo get_phrase('class'); ?> <?php echo $row['name']; ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </li>


        <!-- DAILY ATTENDANCE -->
        <li class="<?php if ($page_name == 'manage_attendance' ||
                                $page_name == 'manage_attendance_view' || $page_name == 'attendance_report' || $page_name == 'attendance_report_view') 
                                    echo 'opened active'; ?> ">

            <a href="#">
                <i class="entypo-chart-area"></i>
                <span><?php echo get_phrase('daily_attendance'); ?></span>
            </a>
            <ul>
                
                    <li class="<?php if (($page_name == 'manage_attendance' || $page_name == 'manage_attendance_view')) echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>index.php?admin/manage_attendance">
                            <span><i class="entypo-dot"></i><?php echo get_phrase('daily_atendance'); ?></span>
                        </a>
                    </li>
               
            </ul>
            <ul>
                
                    <li class="<?php if (( $page_name == 'attendance_report' || $page_name == 'attendance_report_view')) echo 'active'; ?>">
                        <a href="<?php echo base_url(); ?>index.php?admin/attendance_report">
                            <span><i class="entypo-dot"></i><?php echo get_phrase('attendance_report'); ?></span>
                        </a>
                    </li>
               
            </ul>
        </li>


        <!-- EXAMS -->
        <li class="<?php
        if ($page_name == 'exam' ||
                $page_name == 'grade' ||
                  $page_name == 'marks_manage' ||
                    $page_name == 'submit_term_result' ||
                      $page_name == 'exam_marks_sms' ||
                        $page_name == 'tabulation_sheet' ||
                            $page_name == 'marks_manage_view' || $page_name == 'question_paper')
                                echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-graduation-cap"></i>
                <span><?php echo get_phrase('exam'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'exam') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/exam">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('exam_list'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'grade') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/grade">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('exam_grades'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'marks_manage' || $page_name == 'marks_manage_view') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/marks_manage">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('manage_marks'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'exam_marks_sms') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/exam_marks_sms">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('send_marks_by_sms'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'submit_term_result') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/submit_term_result">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('submit_term_result'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'tabulation_sheet') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/tabulation_sheet">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('tabulation_sheet'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'question_paper') echo 'active'; ?>">
                    <a href="<?php echo base_url(); ?>index.php?admin/question_paper">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('question_paper'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        
        <!-- ACCOUNTING -->
        <li class="<?php
        if ($page_name == 'income' ||
                $page_name == 'expense' ||
                    $page_name == 'expense_category' ||
                        $page_name == 'student_payment')
                            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-suitcase"></i>
                <span><?php echo get_phrase('accounting'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'student_payment') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/student_payment">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('create_student_payment'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'income') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/income">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_payments'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'expense') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/expense">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('expense'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'expense_category') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/expense_category">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('expense_category'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- SCRATCH CARDS -->
        <li class="<?php if ($page_name == 'scratch_cards') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/scratch_cards">
                <i class="entypo-vcard"></i>
                <span><?php echo get_phrase('scratch cards'); ?></span>
            </a>
        </li>

        <!-- SCRATCH CARDS -->
        <li class="<?php if ($page_name == 'bulk_sms') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/bulk_sms">
                <i class="entypo-mail"></i>
                <span><?php echo get_phrase('bulk_sms'); ?></span>
            </a>
        </li>


        <!-- LIBRARY -->
        <li class="<?php if ($page_name == 'book') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/book">
                <i class="entypo-book"></i>
                <span><?php echo get_phrase('library'); ?></span>
            </a>
        </li>

        <!-- TRANSPORT -->
        <li class="<?php if ($page_name == 'transport') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/transport">
                <i class="entypo-location"></i>
                <span><?php echo get_phrase('transport'); ?></span>
            </a>
        </li>

        <!-- DORMITORY -->
        <li class="<?php if ($page_name == 'dormitory') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/dormitory">
                <i class="entypo-home"></i>
                <span><?php echo get_phrase('dormitory'); ?></span>
            </a>
        </li>

        <!-- NOTICEBOARD -->
        <li class="<?php if ($page_name == 'noticeboard') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/noticeboard">
                <i class="entypo-doc-text-inv"></i>
                <span><?php echo get_phrase('noticeboard'); ?></span>
            </a>
        </li>

        <!-- MESSAGE -->
        <li class="<?php if ($page_name == 'message') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/message">
                <i class="entypo-share"></i>
                <span><?php echo get_phrase('private_message'); ?></span>
            </a>
        </li>

        <!-- SETTINGS -->
        <li class="<?php
        if ($page_name == 'system_settings' ||
                $page_name == 'manage_language' ||
                    $page_name == 'sms_settings' ||
                        $page_name == 'frontend_settings' ||
                           $page_name == 'backup_restore')
                        echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-lifebuoy"></i>
                <span><?php echo get_phrase('settings'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'system_settings') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/system_settings">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('backend_settings'); ?></span>
                    </a>
                </li>


                <li class="<?php if ($page_name == 'sms_settings') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/sms_settings">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('sms_settings'); ?></span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'reportcard_settings') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/result_checker_settings">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('result_checker_settings'); ?></span>
                    </a>
                </li>

                <!--<li class="<?php if ($page_name == 'manage_language') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/manage_language">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('language_settings'); ?></span>
                    </a>
                </li>-->

                <li class="<?php if ($page_name == 'backup_restore') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/backup_restore">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('backup'); ?></span>
                    </a>
                </li>

            </ul>
        </li>

        <!-- FRONTEND SEETINGS -->
        <li class="<?php
        if ($page_name == 'frontend_pages' ||
            $page_name == 'frontend_themes')
            echo 'opened active';
        ?> ">
            <a href="#">
                <i class="entypo-lifebuoy"></i>
                <span><?php echo get_phrase('frontend_settings'); ?></span>
            </a>
            <ul>
                <li class="<?php if ($page_name == 'frontend_pages') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/frontend_pages/general">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('pages'); ?></span>
                    </a>
                </li>

                <li class="<?php if ($page_name == 'frontend_themes') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?admin/frontend_themes">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('themes'); ?></span>
                    </a>
                </li>

            </ul>
        </li>


        <!-- ACCOUNT -->
        <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?admin/manage_profile">
                <i class="entypo-lock"></i>
                <span><?php echo get_phrase('account'); ?></span>
            </a>
        </li>

    </ul>

</div>