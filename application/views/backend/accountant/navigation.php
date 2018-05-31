<div class="sidebar-menu">
    <header class="logo-env" >

        <!-- logo -->
        <div class="logo" style="">
            <a href="<?php echo base_url(); ?>">
                <img src="uploads/logo.png"  style="max-height:60px;"/>
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
            <a href="<?php echo base_url(); ?>index.php?accountant/dashboard">
                <i class="entypo-gauge"></i>
                <span><?php echo get_phrase('dashboard'); ?></span>
            </a>
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
                    <a href="<?php echo base_url(); ?>index.php?accountant/student_payment">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('create_student_payment'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'income') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?accountant/income">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('student_payments'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'expense') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?accountant/expense">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('expense'); ?></span>
                    </a>
                </li>
                <li class="<?php if ($page_name == 'expense_category') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?accountant/expense_category">
                        <span><i class="entypo-dot"></i> <?php echo get_phrase('expense_category'); ?></span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- HR/PAYROLL -->
        <li class="<?php if ($page_name == 'add_employee' || $page_name == 'employee_import' ||
            $page_name == 'employee' || $page_name == 'bank_details' ||
            $page_name == 'pay_head' || $page_name == 'payable_type' ||
            $page_name == 'salary_settings' || $page_name == 'staff_salary' ||
            $page_name == 'generate_pay_slip')
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
                            <a href="<?php echo base_url(); ?>index.php?accountant/employee_import">
                                <span><i class="entypo-dot"></i><?php echo get_phrase('employee_import'); ?></span>
                            </a>
                        </li>

                        <li class="<?php if (( $page_name == 'employee')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?accountant/employee">
                                <span><i class="entypo-dot"></i><?php echo get_phrase('employee_information'); ?></span>
                            </a>
                        </li>

                        <li class="<?php if (( $page_name == 'add_bank_details')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?accountant/bank_details">
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
                            <a href="<?php echo base_url(); ?>index.php?accountant/payHeadMaster">
                                <span><i class="entypo-dot"></i><?php echo get_phrase('pay_head'); ?></span>
                            </a>
                        </li>

                        <li class="<?php if (( $page_name == 'payable_type')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?accountant/payableTypes">
                                <span><i class="entypo-dot"></i><?php echo get_phrase('payable_types'); ?></span>
                            </a>
                        </li>

                        <li class="<?php if (( $page_name == 'salary_settings')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?accountant/salarySettings">
                                <span><i class="entypo-dot"></i><?php echo get_phrase('salary_settings'); ?></span>
                            </a>
                        </li>

                        <li class="<?php if (( $page_name == 'staff_salary')) echo 'active'; ?>">
                            <a href="<?php echo base_url(); ?>index.php?accountant/staffSalary">
                                <span><i class="entypo-dot"></i><?php echo get_phrase('staff_salary'); ?></span>
                            </a>
                        </li>

                    </ul>
                </li>

            </ul>
        </li>


        <!-- ACCOUNT -->
        <li class="<?php if ($page_name == 'manage_profile') echo 'active'; ?> ">
            <a href="<?php echo base_url(); ?>index.php?accountant/manage_profile">
                <i class="entypo-lock"></i>
                <span><?php echo get_phrase('account'); ?></span>
            </a>
        </li>

    </ul>

</div>