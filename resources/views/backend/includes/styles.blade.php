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
<link rel="stylesheet" href="{{ asset('vendors/datatables/datatables.bundle.css') }}">

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
        margin: auto 0 0 0 ;
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
    #icon-bell{
        display:block;
        font-size: 25px;
        color: #9e9e9e;
        cursor: pointer;
    }
    #icon-bell.active{
        color: red;
        -webkit-animation: ring 4s .7s ease-in-out infinite;
        -webkit-transform-origin: 50% 4px;
        -moz-animation: ring 4s .7s ease-in-out infinite;
        -moz-transform-origin: 50% 4px;
        animation: ring 4s .7s ease-in-out infinite;
        transform-origin: 50% 4px;
    }
    .order_count{
        position: relative;
    }
    .order_count a:hover{
        color: #fff !important;

    }
    .order_count span{
        position: absolute;
        z-index: 99999999;
        top: -5px;
        right: 0px;
        background: red;
        border-radius: 50%;
        color: #fff;
        width: 16px;
        height: 16px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: 900;
    }
    .header-statistic{
        display: flex;
        justify-content: space-between;
        align-content: center;
        align-items: center;
        margin: 0 25px;
    }
    .header-statistic .units,
    .header-statistic .money .dropbtn,
    .header-statistic .user_units .dropbtn{
        background-color: #fff;
        padding: 10px;
        border-radius: 7px;
        border: 2px solid #FC2947;
        color: #FC2947;
        font-weight: 500;
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;
        transition: .2s all ease-in;
        cursor: pointer;
        margin: 0 5px;
    }
    .header-statistic .units:hover,
    .header-statistic .money .dropdown:hover .dropbtn,
    .header-statistic .user_units .dropdown:hover .dropbtn{
        background-color: #FC2947;
        border: 2px solid #fff;
        color: #fff;
    }
    .header-statistic .money .dropdown:hover .dropdown-content,
    .header-statistic .user_units .dropdown:hover .dropdown-content {
        display: grid;
        justify-content: center;
        align-items: center;
        padding: 10px;
        color: #252525;
        background-color: #F6F6F6;
        width: min-content;
        border-radius: 15px;
        font-weight: 500;
        font-family: 'Lucida Sans', 'Lucida Sans Regular', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif
    }
    .header-statistic .money .dropdown ,
    .header-statistic .user_units .dropdown{
        position: relative;
        display: inline-block;
    }
    .header-statistic .money .dropdown-content,
    .header-statistic .user_units .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: max-content;
        z-index: 1;
    }
    .header-statistic .money .dropdown-content a,
    .header-statistic .user_units .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }
    @-webkit-keyframes ring {
        0% { -webkit-transform: rotateZ(0); }
        1% { -webkit-transform: rotateZ(30deg); }
        3% { -webkit-transform: rotateZ(-28deg); }
        5% { -webkit-transform: rotateZ(34deg); }
        7% { -webkit-transform: rotateZ(-32deg); }
        9% { -webkit-transform: rotateZ(30deg); }
        11% { -webkit-transform: rotateZ(-28deg); }
        13% { -webkit-transform: rotateZ(26deg); }
        15% { -webkit-transform: rotateZ(-24deg); }
        17% { -webkit-transform: rotateZ(22deg); }
        19% { -webkit-transform: rotateZ(-20deg); }
        21% { -webkit-transform: rotateZ(18deg); }
        23% { -webkit-transform: rotateZ(-16deg); }
        25% { -webkit-transform: rotateZ(14deg); }
        27% { -webkit-transform: rotateZ(-12deg); }
        29% { -webkit-transform: rotateZ(10deg); }
        31% { -webkit-transform: rotateZ(-8deg); }
        33% { -webkit-transform: rotateZ(6deg); }
        35% { -webkit-transform: rotateZ(-4deg); }
        37% { -webkit-transform: rotateZ(2deg); }
        39% { -webkit-transform: rotateZ(-1deg); }
        41% { -webkit-transform: rotateZ(1deg); }
        43% { -webkit-transform: rotateZ(0); }
        100% { -webkit-transform: rotateZ(0); }
    }
    @-moz-keyframes ring {
        0% { -moz-transform: rotate(0); }
        1% { -moz-transform: rotate(30deg); }
        3% { -moz-transform: rotate(-28deg); }
        5% { -moz-transform: rotate(34deg); }
        7% { -moz-transform: rotate(-32deg); }
        9% { -moz-transform: rotate(30deg); }
        11% { -moz-transform: rotate(-28deg); }
        13% { -moz-transform: rotate(26deg); }
        15% { -moz-transform: rotate(-24deg); }
        17% { -moz-transform: rotate(22deg); }
        19% { -moz-transform: rotate(-20deg); }
        21% { -moz-transform: rotate(18deg); }
        23% { -moz-transform: rotate(-16deg); }
        25% { -moz-transform: rotate(14deg); }
        27% { -moz-transform: rotate(-12deg); }
        29% { -moz-transform: rotate(10deg); }
        31% { -moz-transform: rotate(-8deg); }
        33% { -moz-transform: rotate(6deg); }
        35% { -moz-transform: rotate(-4deg); }
        37% { -moz-transform: rotate(2deg); }
        39% { -moz-transform: rotate(-1deg); }
        41% { -moz-transform: rotate(1deg); }
        43% { -moz-transform: rotate(0); }
        100% { -moz-transform: rotate(0); }
    }
    @keyframes ring {
        0% { transform: rotate(0); }
        1% { transform: rotate(30deg); }
        3% { transform: rotate(-28deg); }
        5% { transform: rotate(34deg); }
        7% { transform: rotate(-32deg); }
        9% { transform: rotate(30deg); }
        11% { transform: rotate(-28deg); }
        13% { transform: rotate(26deg); }
        15% { transform: rotate(-24deg); }
        17% { transform: rotate(22deg); }
        19% { transform: rotate(-20deg); }
        21% { transform: rotate(18deg); }
        23% { transform: rotate(-16deg); }
        25% { transform: rotate(14deg); }
        27% { transform: rotate(-12deg); }
        29% { transform: rotate(10deg); }
        31% { transform: rotate(-8deg); }
        33% { transform: rotate(6deg); }
        35% { transform: rotate(-4deg); }
        37% { transform: rotate(2deg); }
        39% { transform: rotate(-1deg); }
        41% { transform: rotate(1deg); }
        43% { transform: rotate(0); }
        100% { transform: rotate(0); }
    }
</style>
