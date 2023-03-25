@if( $lang_direction == 'rtl' )
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/css/vendor.bundle.base.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.css.map') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendors/chartist/chartist.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendors/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/select2/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    <style>
        div.dataTables_wrapper div.dataTables_filter {
            text-align: left !important;
            width: 100%;
        }
    </style>
@else
    <link href="{{ asset('css/toastr.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/css/vendor.bundle.base.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.css.map') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendors/chartist/chartist.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('vendors/flag-icon-css/css/flag-icon.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/daterangepicker/daterangepicker.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/select2/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendors/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/fontawesome.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />
    <style>
        div.dataTables_wrapper div.dataTables_filter {
            text-align: right !important;
            width: 100%;
        }
    </style>
@endif
<style>
    .m-topbar .m-topbar__nav.m-nav>.m-nav__item.m-topbar__user-profile.m-topbar__user-profile--img.m-dropdown--arrow .m-dropdown__arrow {
        color: #ffffff;
    }
    .m-aside-menu .m-menu__nav>.m-menu__item>.m-menu__heading .m-menu__link-text, .m-aside-menu .m-menu__nav>.m-menu__item>.m-menu__link .m-menu__link-text {
        font-weight: 400;
        font-size: 1.02rem;
        text-transform: initial;
    }
    .fileinput-preview img {
        width: 100%;
    }
    .dataTables_wrapper table.dataTable.dtr-inline.collapsed>tbody>tr[role="row"]>td:first-child:before{
        right : -26px;
    }
    .din{
        display: inherit;
        cursor: help;
    }
    .nav-category:first-child{
        margin-top: 70px;
    }
    .footer{
        margin-top: 100px;
        bottom: 0;
        width: 100%;
    }
    .main-content{
        margin: 20px;
        position: relative;
        box-shadow: rgba(0, 0, 0, 0.15) 0px 5px 15px 0px;
    }
    .sub-content{
        padding: 30px;
    }
    .element-icon {
        display: inline-grid !important;
        justify-content: space-between !important;
        align-items: center !important;
    }
    .cms-buttons-{
        padding: 20px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #bfbfbf54;
    }
    .page-title{
        font-size: 20px;
        font-weight: bold;
        color: #525252c5;
    }
    .actions-component{
        display: flex;
        justify-content: center;
        align-items: center
    }
    .actions-component a{
        margin: 0 5px;
    }
    .cms-buttons-bottom{
        padding: 20px;
        margin-top: 10px;
        display: flex;
        align-items: center;
        justify-content: start;
        border-top: 1px solid #bfbfbf54;
    }
    .input-group-button-password{
        width: 40px;
        background: #38ce3c;
        color: #Fff;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .input-group-button-password:hover, .input-group-button-password:focus, .input-group-button-password:active{
        background: #38ce3dc5 !important;
    }
    .form-control-feedback{
        background: #ff4747;
        border-radius: 5px;
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 10px;
        position: absolute;
        right: 0;
        font-size: 14px;
        height: 27px;
        top: -31px;
        box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
        font-family: Arial, Helvetica, sans-serif
    }
    .form-control-feedback.hide{
        transition: all 2s ease-in-out;
    }
    #toast-container{
        margin: 20px auto;
    }
    .restore-action,
    .delete-action,
    .soft-delete-action,
    .update-action,
    .restore-action:hover,
    .delete-action:hover,
    .soft-delete-action:hover,
    .update-action:hover
    {
        text-decoration: none;
    }
    .restore-action,
    .delete-action,
    .soft-delete-action,
    .update-action{
        margin: 4px;
        padding: 5px;
        border-radius: 15px;
    }
    .restore-action i,
    .delete-action, i
    .soft-delete-action i,
    .update-action i ,
    .aproved-action i{
        font-size: 14px
    }

    .restore-action:hover,
    .delete-action:hover,
    .soft-delete-action:hover,
    .update-action:hover,
    .update-action:hover
    {
        background-color: #fff;
    }
    .restore-action {
        color: #4E6E81;
    }
    .aproved-action {
        color: green;
    }
    .delete-action {
        color: #DF2E38;
    }
    .soft-delete-action {
        color: #DF2E38;
    }
    .update-action {
        color: #B4E4FF;
    }
    .restore-action:hover {
        color: #4e6e81ce;
    }
    .delete-action:hover {
        color: #df2e37d8;
    }
    .soft-delete-action:hover {
        color: #df2e37d8;
    }
    .update-action:hover {
        color: #b4e4ffd0;
    }
    .aproved-action:hover {
        color: rgba(0, 128, 0, 0.747);
    }
</style>
