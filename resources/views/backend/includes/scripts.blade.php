<script src="{{ asset('vendors/js/vendor.bundle.base.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/js/bootstrap.min.js.map') }}" type="text/javascript"></script>
<script src="{{ asset('js/chart.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/chartist.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/dashboard.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/misc.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/off-canvas.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/typeahead.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/chart.js/Chart.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/chartist/chartist.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendors/chartist/chartist.min.js.map') }}" type="text/javascript"></script>

<script>
    $(document).ready(function () {
        //
    });

    const lengthMenu = [[5,10, 25, 50, 200, 400, 1000, 2000, -1], [5,10, 25, 50, 200, 400, 1000, 'All']];
    const pagle      = 25;
    const language   = { url: "{!! __('base.lang_data_table') !!}" };
    var options = {
        processing: true,
            serverSide: true,
            lengthMenu: lengthMenu,
            pageLength: pagle,
            language: language,
            rowCallback: function(row, data) {
                if( data["deleted_at"] ){
                    $(row).css('background-color', "rgb(201, 76, 76, 0.1)");
                }
            },
    }
    function dataTableActions(data,type,row,meta){
        var actions = '<span class="d-flex element-icon">';
        row.actions.forEach(icon => {
            if(icon.type == 'icon' && icon.method == 'POST'){
                actions += `<a href="javascript:;" onclick="replicateConfirmation('#delete_${icon.request_type}')" id="${icon.id}" class="${icon.class} mx-1" title="${icon.label}">
                                <i class="${icon.icon}"></i>
                            </a>`;
                actions += `<form id="delete_${icon.request_type}" onsubmit="OnFormSubmit(event);" method="POST" action="${icon.link}" style="display: none;">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="user_id" value="${icon.id}">
                            </form>`;
            } else {
                actions += `<a href="${icon.link}" id="${icon.id}" class="${icon.class} mx-1" title="${icon.label}">
                                <i class="${icon.icon}"></i>
                            </a>`;
            }
            actions += '</span>';
        });
        return actions;
    }
    function replicateConfirmation(subm){
        $(subm).submit();

        // $.confirm({
        //     title: "{{ __('base.confirm.label') }}",
        //     content: "{{ __('base.confirm.description') }}",
        //     type: 'green',
        //     buttons: {
        //         ok: {
        //             text: "{{ __('base.confirm.ok') }}",
        //             btnClass: 'btn-success',
        //             keys: ['enter'],
        //             action: function(){
        //                 $(subm).submit();
        //             },
        //         },
        //         cancel: {
        //             text: "{{ __('base.confirm.cancel') }}",
        //             btnClass: 'btn-success',
        //             keys: ['enter'],
        //             action: function(){
        //                 console.log('cancel');
        //             }
        //         }
        //     }
        // });
    }
    function OnFormSubmit(ev) {
        ev.preventDefault();
        ev.stopPropagation();
        let form   = $(ev.target),
            data   = new FormData(),
            action = form.attr('action'),
            method = form.attr('method');

            var files = form.find('[type=file]');
            $.each(files, function (key, input) {
                if(input.files[0] != undefined)
                {
                    data.append(input.name, input.files[0]);
                }
            });

            $.each(form.serializeArray(), function (key, input) {
                data.append(input.name, input.value);
            });

            let = response_type = '',response_title = '',response_description = '';

            $.confirm({
                title: "{{ __('base.confirm.label') }}",
                content: "{{ __('base.confirm.description') }}",
                type: method == "POST" ? 'red' : 'green',
                buttons: {
                    ok: {
                        text: "{{ __('base.confirm.ok') }}",
                        btnClass: method == "POST" ? 'btn-danger' : 'btn-success' ,
                        keys: ['enter'],
                        action: function(){
                            $.ajax({
                                data        : data,
                                url         : action,
                                type        : method,
                                processData : false,
                                contentType : false,
                                success: function (data) {
                                    response_type           = data.type;
                                    response_title          = data.title;
                                    response_description    = data.description;
                                    if($('#data-table').length)
                                    {
                                        $('#data-table').DataTable().ajax.reload();
                                    }
                                    if(data.redirect_url)
                                    {
                                        window.location = data.redirect_url;
                                    }

                                    if(!data.success)
                                    {
                                        $('.form-control-feedback').remove();
                                            if(typeof data.errors !== 'undefined')
                                            {
                                                let $data = data.errors;
                                                var error_text = '';
                                                Object.keys($data).forEach((key) => {
                                                    error_text = `<div class="form-control-feedback"> ${$data[key][0]}</div>`;
                                                    $(`input[name=${key}]`).after( error_text );
                                                })
                                            }
                                    }
                                    // $(`.form-control-feedback`).fadeOut(6000);
                                    show_toastr(response_type, response_title, response_description)
                                },
                                error: function (error) {
                                    if(!error.success)
                                    {
                                        $('.form-control-feedback').remove();
                                            if(typeof error.errors !== 'undefined')
                                            {
                                                let $data = error.errors;
                                                var error_text = '';
                                                Object.keys($data).forEach((key) => {
                                                    error_text = `<div class="form-control-feedback"> ${$data[key][0]}</div>`;
                                                    $(`input[name=${key}]`).after( error_text );
                                                })
                                            }
                                    }
                                    // $(`.form-control-feedback`).fadeOut(6000);
                                    response_type           = error.type;
                                    response_title          = error.title;
                                    response_description    = error.description;
                                    show_toastr(response_type, response_title, response_description)
                                },
                            });
                        }
                    },
                    cancel: {
                        text: "{{ __('base.confirm.cancel') }}",
                        btnClass: method == "POST" ? 'btn-danger' : 'btn-success' ,
                        keys: ['enter'],
                        action: function(){
                            console.log('cancel');
                        }
                    }
                }
            });
    }
</script>
